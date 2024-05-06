@extends('layouts.admin')

@section('title', __('cart.title'))
@section('content-header', __('cart.title'))
@section('content-actions')
<a href="{{route('orders.index')}}" class="btn btn-primary">{{ __('order.order_list') }}</a>
@endsection

@section('content')
    <div id="cart"></div>
    <!--cart></cart-->

@endsection
