<?php

namespace App\Http\Controllers;

use App\Models\EventoInscricao;
use App\Models\Log; // Certifique-se de que o modelo Log existe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as LaravelLog;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class WebhookController extends Controller
{
    /**
     * Mapeia o tipo de pagamento do Mercado Pago para um ID inteiro.
     * Adapte os valores conforme necessário para sua aplicação.
     */
    private function mapPaymentTypeToInt(string $paymentTypeId): int
    {
        $map = [
            'credit_card' => 1,
            'debit_card' => 2,
            'bank_transfer' => 3,
            'ticket' => 4, // Boleto
            'pix' => 5,
        ];
        return $map[strtolower($paymentTypeId)] ?? 0;
    }

    /**
     * Mapeia o método de pagamento (subtipo) para um ID inteiro.
     * Adapte os valores conforme necessário para sua aplicação.
     */
    private function mapPaymentSubTypeToInt(string $paymentMethodId): int
    {
        // Esta é uma lista de exemplos. Você deve completá-la com os
        // valores relevantes para sua aplicação.
        $map = [
            'master' => 1,
            'visa' => 2,
            'elo' => 3,
            'hipercard' => 4,
            'pix' => 10,
            'bolbradesco' => 20,
        ];
        return $map[strtolower($paymentMethodId)] ?? 0;
    }

    public function handleMercadoPago(Request $request)
    {
        LaravelLog::info('Webhook Mercado Pago Recebido:', $request->all());

        $paymentId = $request->input('data.id');
        $topic = $request->input('type');

        if (!$paymentId || $topic !== 'payment') {
            return response()->json(['status' => 'notification_not_processed'], 200);
        }

        try {
            MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));

            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            if (!$payment) {
                LaravelLog::warning("Pagamento com ID {$paymentId} não encontrado.");
                return response()->json(['status' => 'not_found'], 404);
            }

            $inscricao = EventoInscricao::find($payment->external_reference);
            if (!$inscricao) {
                LaravelLog::warning("Inscrição com external_reference {$payment->external_reference} não encontrada.");
                return response()->json(['status' => 'not_found'], 404);
            }

            DB::beginTransaction();

            $status = $payment->status;

            if ($status === 'approved') {
                // A cláusula WHERE previne que uma inscrição já processada (3, 4, 6, etc.) seja alterada
                $updated = EventoInscricao::where('id', $inscricao->id)
                    ->whereNotIn('situacao', [3, 4, 6, 85, 93])
                    ->update([
                                 'dataconfirm' => ($inscricao->dataconfirm == null || $inscricao->dataconfirm->year == 1900) ? now() : $inscricao->dataconfirm,
                                 'paymentType' => $this->mapPaymentTypeToInt($payment->payment_type_id),
                                 'paymentSubType' => $this->mapPaymentSubTypeToInt($payment->payment_method_id),
                                 'paymentNetAmount' => $inscricao->paymentNetAmount > 0 ? $inscricao->paymentNetAmount : ($payment->transaction_details->net_received_amount ?? 0),
                                 'paymentInstallments' => $payment->installments ?? 0,
                                 'situacao' => 3,
                                 // Adicione os outros campos do seu script original se necessário
                                 // 'vlrlib' => 1,
                                 // 'vlrDisponivel' => 1,
                                 // 'dtVlrDisponivel' => now(),
                                 // 'paymentId' => $paymentId,
                             ]);

            } else if ($status === 'cancelled') {
                // Apenas cancela se a inscrição ainda estiver pendente (ou em outro estado inicial)
                EventoInscricao::where('id', $inscricao->id)
                    ->where('situacao', '<', 3)
                    ->update(['situacao' => 7]);

            } else if ($status === 'refunded' || $status === 'charged_back') {
                EventoInscricao::where('id', $inscricao->id)
                    ->update(['situacao' => 6]);
            }
            // Adicione outras condições de status aqui se necessário (ex: 'in_process', 'rejected')

            // Cria o registro de log, similar ao script original
            Log::create([
                            'ds_log' => json_encode($payment),
                            'dt_data' => now(),
                            'cod_transacao' => $inscricao->id,
                            'cod_situacao' => $status,
                            'tipo_pg' => $this->mapPaymentTypeToInt($payment->payment_type_id),
                            'subtipo_pg' => $this->mapPaymentSubTypeToInt($payment->payment_method_id),
                            'parcelas_pg' => $payment->installments ?? 0,
                            'valorliquido_pg' => $payment->transaction_details->net_received_amount ?? 0,
                            'paytag' => $payment->card->last_four_digits ?? null,
                        ]);

            DB::commit();

            LaravelLog::info("Inscrição #{$inscricao->id} processada para o status '{$status}'.");
            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            LaravelLog::error("Erro no webhook do Mercado Pago: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error'], 500);
        }
    }
}
