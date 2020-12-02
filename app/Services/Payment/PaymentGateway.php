<?php

namespace App\Services\Payment;

use App\Models\Payment\Payment;
use Symfony\Component\HttpFoundation\Response;

abstract class PaymentGateway
{
    public function enroll(Payment $payment)
    {
        $user = $payment->user;

        $user->update([
            'balance' => $user->balance + $payment->sum,
        ]);

        $payment->is_success = true;
        $payment->save();
    }

    abstract public function pay(Payment $payment);

    abstract public function getResponse(): Response;
}
