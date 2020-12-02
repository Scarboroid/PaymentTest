<?php

namespace App\Http\Controllers;

use App\Models\Payment\Payment;
use App\Models\Payment\PaymentService;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentController extends Controller
{
    public function create()
    {
        $paymentServices = PaymentService::all();

        return view('payment.create', compact('paymentServices'));
    }

    public function store(Request $request, PaymentGatewayFactory $gatewayFactory)
    {
        $validated = $request->validate([
            'sum'             => 'required:integer',
            'name'            => '',
            'payment_service' => [
                'required',
                'exists:App\Models\Payment\PaymentService,code',
            ],
        ]);

        $payment = new Payment();

        if ($validated['name']) {
            $payment->name = $validated['name'];
        }

        $paymentService = PaymentService::query()
            ->firstWhere('code', $validated['payment_service']);

        $payment->sum                = $validated['sum'];
        $payment->user_id            = Auth::id();
        $payment->payment_service_id = $paymentService->id;

        $payment->save();

        $paymentGateway = $gatewayFactory->create($request->payment_service);
        $paymentGateway->pay($payment);

        return $paymentGateway->getResponse();
    }

    protected function fetchPayment(int $id): Payment
    {
        /** @var Payment $paymentRequest */
        $payment = Payment::query()
            ->with(['user', 'paymentService'])
            ->where('is_success', false)
            ->find($id);

        if (!$payment) {
            throw new HttpException(400, 'Payment was already paid');
        }

        return $payment;
    }
}
