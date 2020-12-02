<?php

return [
    'xyzpayment' => [
        'key' => env('SECRET_XYZ'),
        'url' => 'https://xyz-payment.ru/pay',
    ],
    'oldpay' => [
        'key' => env('SECRET_OLD'),
        'url' => 'https://old-pay.ru/api/create',
        'getStatusUrl' => 'https://old-pay.ru/api/get-status',
    ],
];
