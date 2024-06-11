<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact("products"));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact(['product']));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(
            [
                'quantity' => ['integer', 'min:1', 'max:' . $product->quantity],
            ],
            [
                'quantity.max' => 'Only ' . $product->quantity . ' peice(s) are availble'
            ]
        );
        if (Auth::user()->cart) {
            $order = Auth::user()->cart;
        } else {
            $order = order::create(
                [
                    'user_id' => Auth::id(),
                    'amount' => 0
                ]
            );
        }
        $orderProduct = OrderProduct::where('product_id', $product->id)->where('order_id', $order->id)->first();
        if ($orderProduct) {
            $orderProduct->quantity += $request->quantity;
            $orderProduct->save();
        } else {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }
        $product->quantity -= $request->quantity;
        $product->save();
        return redirect(route('order.show', $order->id));
    }
}