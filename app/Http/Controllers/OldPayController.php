<?php

namespace App\Http\Controllers;

use App\Exceptions\Payment\PaymentControllerException;
use App\Http\Requests\OldPayRequest;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Support\Facades\Http;

class OldPayController extends PaymentController
{
    public function update(OldPayRequest $request, PaymentGatewayFactory $gatewayFactory)
    {
        $response = Http::withHeaders([
            'X-Secret-Key' => config('payment.oldpay.key'),
        ])->get(config('payment.oldpay.getStatusUrl'), [
            'id' => $request->payment_id,
        ])->json();

        if ($response['status'] !== 'success') {
            throw new PaymentControllerException('Failed payment status');
        }

        $payment = $this->fetchPayment($response['order_id']);

        if ($payment->sum !== (float) $response['sum']) {
            return response('Insonsistent data', 400);
        }

        $gateway = $gatewayFactory->create($payment->paymentService->code);

        $gateway->enroll($payment);
    }
}
