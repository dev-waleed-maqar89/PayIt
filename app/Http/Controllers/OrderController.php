<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->paginate(10);
        return view('orders.index', compact(['orders']));
    }

    public function show($id)
    {
        $order = order::findOrFail($id);
        $products = $order->products;
        return view('orders.show', compact(['order', 'products']));
    }
}