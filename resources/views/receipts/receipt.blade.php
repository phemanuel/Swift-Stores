<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Swift-Store :: Receipt </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- app favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <!-- overlayScrollbars -->
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            line-height: 1.6;
        }
        .receipt {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #000;
        }
        .receipt h1 {
            font-size: 16px;
            margin: 0 0 10px;
            text-align: center;
        }
        .receipt p {
            margin: 0;
            font-size: 14px;
        }
        .receipt .item {
            margin-bottom: 5px;
        }
        .receipt .total {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    <style>
    .font-size-12 {
        font-size: 12px;
    }
</style>
</head>
<body>
<div class="header">    
    <div class="receipt">
    <div align="center">
    <div class="avatar">        
        <img src="{{ asset('storage/' . config('settings.avatar')) }}" alt="Avatar" width="80" height="80">
    </div>
    <div class="contact-info">
        <p class="font-size-12">{{ config('settings.address') }}</p>
        <p class="font-size-12">{{ config('settings.phone') }}</p>
    </div>
</div>
    <hr>
        <!-- <h1>Receipt</h1> -->
        <p><strong>Date:</strong>  {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        
        <p><strong>Order ID:</strong>  {{ $order->transaction_id }}</p>
       
        <p><strong>Order made by:</strong>  {{ $order->customer->first_name . " " . $order->customer->last_name }}</p>
        <!-- <hr>
        <h1><strong>Items</strong> </h1> -->
        <table class="table">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <p class="total">Amount to Pay: {{ config('settings.currency_symbol') }} {{ number_format($order->total(), 2) }}</p>
        <p class="total">Received Amount: {{ config('settings.currency_symbol') }} {{ number_format($order->receivedAmount(), 2) }}</p>
        <p class="total">Change: {{ config('settings.currency_symbol') }} {{ number_format($order->receivedAmount() - $order->total(), 2) }}</p>
<br>
<strong>
    <div align="center"  class="font-size-12"><i>Goods bought in good condition cannot be returned.</i> </div>
        <div align="center" class="font-size-12">Thanks for your patronage...</div>
</strong>
        
        
    </div>
    
</body>
</html>
