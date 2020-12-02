<?php

namespace App\Services\Payment;

use App\Models\Payment\Payment;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class XYZPaymentGateway extends PaymentGateway
{
    public function pay(Payment $payment)
    {
        $queryData = [
            'sum'      => $payment->sum,
            'order_id' => $payment->id,
        ];

        if ($payment->name) {
            $queryData['name'] = $payment->name;
        }

        Http::get(config('payment.xyzpayment.url'), $queryData)->throw();
    }

    public function getResponse(): Response
    {
        return back()->with('success', 'Запрос на оплату успешно создан!');
    }
}
