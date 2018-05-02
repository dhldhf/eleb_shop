@extends('layout.default')
@section('title','订单列表')
@section('content')
    <table class="table table-bordered" id="orders">
        <tr>
            <th>订单号</th>
            <th>下单时间</th>
            <th>操作</th>
        </tr>
        @foreach($orders as $order)
            <tr data-id="{{ $order->id }}">
                <td>{{$order->order_code}}</td>
                <td>{{$order->order_birth_time}}</td>
                <td>
                    <a href="{{ route('orders.show',['order'=>$order]) }}" class="btn btn-sm btn-success">订单详情</a>
                    @if($order->order_status != -1)<a href="{{ route('orders.edit',['order'=>$order]) }}" class="btn btn-danger">取消订单</a>@endif
                    @if($order->order_status != 2 && $order->order_status != -1)<a href="{{ route('ship',['order'=>$order]) }}" class="btn btn-primary">发货</a>@endif
                </td>
            </tr>
        @endforeach
    </table>
    <div>{{ $orders->links() }}</div>
    <div><a href="{{ route('jinri') }}" class="btn btn-primary">今日订单</a></div>
    <br/>
    <div><a href="{{ route('month') }}" class="btn btn-success">这月订单</a></div>
@stop
