<?php

namespace App\Services\Payment;

use InvalidArgumentException;

class PaymentGatewayFactory
{
    protected $map = [
        'xyzpayments' => XYZPaymentGateway::class,
        'oldpay'      => OldPayGateway::class,
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function create(string $code): PaymentGateway
    {
        $class = $this->map[$code] ?? null;

        if (!$class) {
            throw new InvalidArgumentException('Undefined payment service code');
        }

        return new $class;
    }
}
