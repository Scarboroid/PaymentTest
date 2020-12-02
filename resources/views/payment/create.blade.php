@extends('welcome')

@section('content')

    <style>
        .payment-form {
            padding: 20px 15px;
            border: 1px solid #ddd;
        }

        .payment-form__btn {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            margin-top: 10px;
            background-color: #79e279;
            color: white;
            font-weight: bold;
            font-size: 15px;
        }

        .payment-form__control {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }
    </style>

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="status">{{ session('success') }}</div>
    @endif

    <form class="payment-form" action="{{ route('payment.store') }}" method="POST">

        @csrf

        <select class="payment-form__control" name="payment_service">
            @foreach ($paymentServices as $paymentService)
                <option value="{{ $paymentService->code }}">{{ $paymentService->name }}</option>
            @endforeach
        </select>

        <div>
            <input class="payment-form__control" type="text" name="name" placeholder="Имя">
        </div>
        <div>
            <input class="payment-form__control" type="number" name="sum" placeholder="Сумма" required>
        </div>

        <input class="payment-form__btn" type="submit" value="Оплатить">
    </form>

@endsection