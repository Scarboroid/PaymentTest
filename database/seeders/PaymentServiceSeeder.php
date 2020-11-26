<?php

namespace Database\Seeders;

use App\Models\Payment\PaymentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            [
                'code' => 'xyzpayments',
                'name' => 'XYZ Payment\'s',
            ],
            [
                'code' => 'oldpay',
                'name' => 'OLDPay',
            ]
        ] as $paymentService) {
            PaymentService::query()->create($paymentService);
        }
    }
}
