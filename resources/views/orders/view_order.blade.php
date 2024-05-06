@extends('layouts.admin')

@section('title', __('order.title'))
@section('content-header', __('order.detail'))
@section('content-actions')
<a href="{{route('orders.index')}}" class="btn btn-primary">{{ __('order.order_list') }}</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">            
            <div class="col-md-5">
        <div>
            <h4>Order made by: {{ $order->customer->first_name . " " . $order->customer->last_name }}</h4>
            
            <!-- Add more order details here -->
        </div>

        <div>
            
            
                @php
                    $totalAmount = 0;
                @endphp
                <table width="100%" class="table">
                <thead>
                <tr>
                    <th>{{ __('order.name') }}</th>
                    <th>{{ __('order.quantity') }}</th>
                    <th>{{ __('order.amount') }}</th>
                    
                </tr>
            </thead>
                <tbody>
                    @foreach($order->items as $item)
                <tr>
                    <td><strong>{{ $item->product->name }}</strong></td>
                    <td> {{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>                
                @php
                        $totalAmount += $item->price * $item->quantity;
                    @endphp
                @endforeach
                <tr>
                    <td></td>
                    <td><strong>Total Amount:</strong></td>
                    <td> {{ $totalAmount }}</td>
                </tr>
                </tbody>
                
                </table> 
            
        </div>
    </div>

    </div>
    </div>
    </div>
    

@endsection
