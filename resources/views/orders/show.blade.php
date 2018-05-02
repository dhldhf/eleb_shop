@extends('layout.default')
@section('title','订单列表')
@section('content')
<div>订单号:{{ $order->order_code }}</div>
<div>下单时间: {{ $order->order_birth_time }}</div>
<div>订单状态: {{ $order->order_status==0?'代付款':'已取消' }}</div>
<div>用户名: {{ $order->name }}</div>
<div> 详细地址:{{ $order->order_address }}</div>
<div> 商家名称:{{ $order->shop_name }}</div>
<div> 用户电话{{ $order->tel }}</div>
<div> 价格:{{ $order->order_price }}</div>
@stop