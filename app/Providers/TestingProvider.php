<?php

namespace App\Providers;

use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class TestingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Http::fake([
            config('payment.xyzpayment.url') . '*' => Http::response(),
            config('payment.oldpay.url') . '*' => Http::response([
                'status' => 'success',
                'redirect_to' => 'https://google.com/',
            ]),
            config('payment.oldpay.getStatusUrl') . '*' => function () {
                $payment = Payment::query()->find(request()->order_id);

                return Http::response([
                    'status'   => 'success',
                    'sum'      => $payment->sum,
                    'order_id' => $payment->id,
                ]);
            },
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $user = User::first();

        if ($user) {
            Auth::setUser($user);
        }
    }
}
