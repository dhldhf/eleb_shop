<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(5);
        return view('orders.index',compact('orders'));
        }

    public function show(Order $order)
    {
        return view('orders.show',compact('order'));
    }

    public function edit(Order $order)
    {
        $order->update(
            [
                'order_status'=>-1,
            ]
        );
        return redirect()->route('orders.index');
    }

    public function ship(Order $order)
    {
        $order->update(
            [
                'order_status'=>2,
            ]
        );
        return redirect()->route('orders.index');
    }

    public function jinri()
{
//        echo 123;die;
    $orders = DB::select("select * from `orders`WHERE order_birth_time BETWEEN '2018-05-02 00:00:00' AND '2018-05-02 23:59:59'");
    return view('orders.day',compact('orders'));
}
    public function month()
    {
//        echo 123;die;
        $orders = DB::select("select * from `orders`WHERE order_birth_time BETWEEN '2018-05-01 00:00:00' AND '2018-06-01 23:59:59'");
        return view('orders.day',compact('orders'));
    }
}
