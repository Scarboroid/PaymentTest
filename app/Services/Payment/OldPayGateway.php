<?php

namespace App\Services\Payment;

use App\Models\Payment\Payment;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class OldPayGateway extends PaymentGateway
{
    protected array $response;

    public function pay(Payment $payment)
    {
        $this->response = Http::post(config('payment.oldpay.url'), [
            'order_id' => $payment->order_id,
            'sum'      => $payment->sum,
            'name'     => $payment->name,
        ])->throw()->json();

        if ($this->response['status'] !== 'success') {
            throw new PaymentGatewayException('Error from payment service');
        }
    }

    public function getResponse(): Response
    {
        if ($this->response['redirect_to']) {
            return redirect($this->response['redirect_to']);
        } else {
            return back()->with('status', 'Запрос на оплату успешно создан!');
        }
    }
}
