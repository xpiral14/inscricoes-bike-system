<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoInscricao;
use App\Models\EventoInscrito;

// Supondo que você tenha este modelo
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InscricaoController extends Controller
{
    /**
     * Armazena uma nova inscrição no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados recebidos do frontend
        $validator = Validator::make($request->all(), [
            'userId' => 'required|integer|exists:tb_usuarios,id',
            'eventId'                        => 'required|integer|exists:tb_eventos,id',
            'tickets'                        => 'required|array|min:1',
            'tickets.*.categoryId'           => 'required|integer|exists:tb_event_categories,id', // Ajuste a tabela de categorias
            'tickets.*.clients'              => 'required|array|min:1',
            'tickets.*.clients.*.name'       => 'required|string|max:145',
            'tickets.*.clients.*.cpf'        => 'required|string|size:11',
            'tickets.*.clients.*.celular'    => 'required|string|min:10|max:11',
            'tickets.*.clients.*.nascimento' => 'required|date_format:Y-m-d',
            'tickets.*.clients.*.estado'     => 'required|string|max:2',
            'tickets.*.clients.*.cidade'     => 'required|string|max:145',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dados inválidos.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $evento        = Evento::find($validatedData['eventId']);
        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        if (!$evento->podeInscrever()) {
            return response()->json(['message' => 'O evento não pode mais receber inscrições'], 400);
        }

        DB::beginTransaction();
        try {

            $data      = [
                'evento_id'  => $validatedData['eventId'],
                'usuario_id' => $request->userId
            ];
            $inscricao = EventoInscricao::query()->create($data);

            $usuarios = Usuario::query()->whereIn('cpf', array_column($validatedData['tickets'], 'clients.*.cpf'))->get()->keyBy('id');

            foreach ($validatedData['tickets'] as $ticket) {
                foreach ($ticket['clients'] as $client) {
                    $usuario = $usuarios[$client['cpf']] ?? null;
                    if (!$usuario) {
                        $usuario = Usuario::create([
                                                       'nome'            => $client['name'],
                                                       'telefone'        => $client['celular'],
                                                       'cpf'             => $client['cpf'],
                                                       'uf'              => $client['estado'],
                                                       'cidade'          => $client['cidade'],
                                                       'data_nascimento' => $client['nascimento'],
                                                       'email'           => Str::random('10') . '@teste-inscricao.com',
                                                       'sexo'            => 'm', // modificar
                                                   ]);
                    }
                    $inscricao->inscritos()->create([
                                                        'evento'     => $validatedData['eventId'],
                                                        'usuario_id' => $request->userId,
                                                        'usuario'    => $usuario->id, // O comprador é sempre o usuário logado
                                                        'categoryID' => $ticket['categoryId'],
                                                    ]);
                }
            }

            DB::commit();

            $redirectUrl = url('/minhas-inscricoes/sucesso'); // Exemplo de URL

            return response()->json([
                                        'message' => 'Inscrição realizada com sucesso!',
                                        'redirect_url' => $redirectUrl, 'redirect_url' => $redirectUrl
                                    ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            throw $e;
            //return response()->json(['message' => 'Ocorreu um erro interno ao processar sua inscrição.'], 500);
        }
    }
}
