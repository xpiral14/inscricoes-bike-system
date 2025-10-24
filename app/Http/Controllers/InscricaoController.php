<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoCategoria;
use App\Models\EventoCupom; // Certifique-se de que este modelo exista
use App\Models\EventoInscricao;
use App\Models\User;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class InscricaoController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eventId' => 'required|integer|exists:tb_eventos,id',
            'tickets' => 'required|array|min:1',
            'tickets.*.categoryId' => 'required|integer|exists:tb_event_categories,id',
            'tickets.*.clients' => 'required|array|min:1',
            'tickets.*.clients.*.name' => 'required|string|max:145',
            'tickets.*.clients.*.cpf' => 'required|string|size:11',
            'tickets.*.clients.*.celular' => 'required|string|min:10|max:11',
            'tickets.*.clients.*.nascimento' => 'required|date_format:Y-m-d',
            'tickets.*.clients.*.estado' => 'required|string|max:2',
            'tickets.*.clients.*.cidade' => 'required|string|max:145',
            // Validação para o cupom opcional
            'cupom' => 'nullable|string|max:45',
            'userId' => 'required|integer|exists:tb_usuarios,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dados inválidos.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $user = Usuario::find($request->userId);
        $evento = Evento::findOrFail($validatedData['eventId']);

        if (!$evento->podeInscrever()) {
            return response()->json(['message' => 'O evento não pode mais receber inscrições.'], 400);
        }

        $cupomModel = null;
        $discountPct = 0;

        // 1. LÓGICA DE CUPOM (Inspirado no arquivo legado)
        if (!empty($validatedData['cupom'])) {
            $cupomModel = EventoCupom::where('evento', $evento->id)
                ->where('codigoCupom', $validatedData['cupom'])
                ->where('usadoPor', 0)
                ->first();

            if (!$cupomModel) {
                return response()->json(['message' => 'Cupom inválido ou já utilizado.'], 422);
            }
            $discountPct = (float) $cupomModel->desconto;
        }

        $totalAmount = 0;
        $paymentItems = [];

        DB::beginTransaction();
        try {
            $inscricao = EventoInscricao::create([
                                                     'situacao' => 94,
                                                     'evento_id' => $evento->id,
                                                     'usuario_id' => $user->id,
                                                     'datacad' => now(),
                                                 ]);

            foreach ($validatedData['tickets'] as $ticket) {
                $categoria = EventoCategoria::findOrFail($ticket['categoryId']);
                $ticketBasePrice = (float) $categoria->price;

                // Aplica o desconto do cupom ao valor do ingresso
                $ticketDiscount = ($ticketBasePrice / 100) * $discountPct;
                $ticketFinalPrice = $ticketBasePrice - $ticketDiscount;

                $totalAmount += $ticketFinalPrice;

                // Cria o item para o Mercado Pago
                $paymentItems[] = [
                    "id" => "CAT-{$categoria->id}-INS-{$inscricao->id}",
                    "title" => substr("Inscrição: " . $evento->titulo . " - " . $categoria->nome, 0, 256),
                    "quantity" => 1, // Um item por ingresso/categoria
                    "unit_price" => (float) number_format($ticketFinalPrice, 2, '.', ''),
                    "currency_id" => "BRL",
                ];

                // Cria os participantes (inscritos)
                foreach ($ticket['clients'] as $client) {
                    $participante = Usuario::firstOrCreate(
                        ['cpf' => $client['cpf']],
                        [
                            'nome' => $client['name'],
                            'telefone' => $client['celular'],
                            'uf' => $client['estado'],
                            'cidade' => $client['cidade'],
                            'data_nascimento' => $client['nascimento'],
                            'email' => $client['cpf'] . '@inscrições.bike', // Email placeholder
                        ]
                    );

                    $inscricao->inscritos()->create([
                                                        'evento' => $evento->id,
                                                        'usuario_id' => $user->id,
                                                        'usuario' => $participante->id,
                                                        'categoryID' => $ticket['categoryId'],
                                                        'price' => $ticketFinalPrice // Salva o preço já com desconto
                                                    ]);
                }
            }

            // 2. ADICIONA TAXAS EXTRAS COMO ITENS SEPARADOS (Lógica do arquivo legado)
            if ($evento->seguro == "1" && $evento->vlrSeguro > 0) {
                $paymentItems[] = [
                    "id" => "SEGURO-{$inscricao->id}", "title" => "Seguro Atleta", "quantity" => 1,
                    "unit_price" => (float) number_format($evento->vlrSeguro, 2, '.', ''), "currency_id" => "BRL",
                ];
                $totalAmount += (float) $evento->vlrSeguro;
            }
            if ($evento->taxaconv == "1" && $evento->vlrTaxaConv > 0) {
                $paymentItems[] = [
                    "id" => "CONV-{$inscricao->id}", "title" => "Taxa de Conveniência", "quantity" => 1,
                    "unit_price" => (float) number_format($evento->vlrTaxaConv, 2, '.', ''), "currency_id" => "BRL",
                ];
                $totalAmount += (float) $evento->vlrTaxaConv;
            }
            if ($evento->valorfrete > 0) {
                $paymentItems[] = [
                    "id" => "FRETE-{$inscricao->id}", "title" => "Valor do Frete", "quantity" => 1,
                    "unit_price" => (float) number_format($evento->valorfrete, 2, '.', ''), "currency_id" => "BRL",
                ];
                $totalAmount += (float) $evento->valorfrete;
            }

            $inscricao->paymentNetAmount = $totalAmount;

            // Se um cupom foi usado, associa à inscrição
            if ($cupomModel) {
                $inscricao->cupomDesc = $cupomModel->id;
                $inscricao->pctDesconto = $discountPct;
                $cupomModel->update(['usadoPor' => $inscricao->id]);
            }
            $inscricao->save();

            // 3. VERIFICAÇÃO DE CORTESIA (Lógica do arquivo legado)
            if ($totalAmount < 0.99) {
                $inscricao->update([
                                       'situacao' => 93, // Código para "Pago" ou "Cortesia"
                                       'dataconfirm' => now(),
                                       'infomarkpaid' => "Confirmado como cortesia (Cupom/Valor Zero) em " . now()->format('d/m/Y H:i:s')
                                   ]);
                DB::commit();
                return response()->json([
                                            'status' => 'success_free',
                                            'message' => 'Sua inscrição foi confirmada como cortesia e não requer pagamento!',
                                        ], 200);
            }

            // 4. PREPARAÇÃO DO PAGAMENTO NO MERCADO PAGO
            MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));
            $client = new PreferenceClient();

            $arr        = [
                "items"              => $paymentItems,
                "payer"              => [
                    'name'           => $user->nome,
                    'email'          => $user->email,
                    'phone'          => [
                        'area_code' => substr($user->telefone, 0, 2),
                        'number'    => substr($user->telefone, 2)
                    ],
                    'identification' => [
                        'type'   => 'CPF',
                        'number' => $user->cpf
                    ],
                ],
                "back_urls"          => [
                    'success' => config('app.url') . "/inscricao/$inscricao->id/success",
                    'failure' => config('app.url') . "/inscricao/$inscricao->id/failure",
                    'pending' => config('app.url') . "/inscricao/$inscricao->id/pending"
                ],
                "auto_return"        => "approved",
                "external_reference" => $inscricao->id,
                "notification_url"   =>  config('app.url') . "api/webhook/mercadopago",
            ];
            $preference = $client->create($arr);
            $inscricao->paymentLink = $preference->init_point;
            $inscricao->save();

            DB::commit();

            return response()->json([
                                        'message' => 'Inscrição realizada! Redirecionando para o pagamento.',
                                        'redirect_url' => $preference->init_point,
                                    ], 200);

        } catch (MPApiException $e) {
            DB::rollBack();

            Log::error('Erro na API do Mercado Pago', [
                'response' => $e->getApiResponse()->getContent()
            ]);
            return response()->json(['message' => 'Ocorreu um erro ao comunicar com o gateway de pagamento.'], 500);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            Log::error('Erro interno ao processar inscrição: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Ocorreu um erro interno ao processar sua inscrição.'], 500);
        }
    }
}
