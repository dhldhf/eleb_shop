@extends('layout.default')
@section('title','今日菜品订单')
@section('content')
    <table class="table table-bordered">
        <tr>
            <th>今天订单</th>
            <th>这月订单</th>
        </tr>
        <tr>
            <td>{{ $num }}</td>
            <td>{{ $num1 }}</td>
        </tr>
        <form method="post" action="">
            <input type="date" name="order_birth_time">至<input type="date" name="order_birth_time1"><input type="submit" value="查询">
            {{ csrf_field() }}
        </form>
    </table>
    <div><a href="" class="btn btn-success">累计订单</a></div>
@stop
