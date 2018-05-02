@extends('layout.default')
@section('title','今日订单')
@section('content')
    <table class="table table-bordered">
        <tr>
            <th>订单号</th>
            <th>下单时间</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->order_code}}</td>
                <td>{{$order->order_birth_time}}</td>
            </tr>
        @endforeach
    </table>
@stop
