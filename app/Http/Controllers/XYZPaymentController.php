<?php

namespace App\Http\Controllers;

use App\Http\Requests\XYZPaymentRequest;
use App\Services\Payment\PaymentGatewayFactory;

class XYZPaymentController extends PaymentController
{
    public function update(XYZPaymentRequest $request, PaymentGatewayFactory $gatewayFactory)
    {
        $payment = $this->fetchPayment($request->order_id);

        if (
            $payment->sum !== (float) $request->sum
            || $payment->name !== $request->name
        ) {
            return response('Insonsistent data', 400);
        }

        $gateway = $gatewayFactory->create($payment->paymentService->code);

        $gateway->enroll($payment);
    }
}
