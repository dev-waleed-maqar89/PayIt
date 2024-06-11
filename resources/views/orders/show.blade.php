@extends('layouts.mainTemblate')
@section('content')
    @if ($order->paid)
        <div class="alert alert-success">
            Order Paid!
        </div>
    @else
        <form action="{{ route('order.checkout', $order->id) }}" method="Post" class="Checkout-form">
            @csrf
            <div class="form-group">
                <input type="submit" value="Checkout" class="form-control">
            </div>
        </form>
    @endif
    <div class="products-container">
        @forelse ($products as $product)
            <a href="{{ route('product.show', $product->product->id) }}">
                <div class="single-product-card">
                    <img src="{{ $product->product->image }}" alt="" class="single-product-image">
                    <h5 class="single-product-name">
                        {{ $product->product->name }}
                    </h5>
                    <p class="single-product-price">
                        L.E {{ $product->product->price }}
                        Quantity: {{ $product->quantity }} <br>
                        <strong>Amount: {{ $product->amount }}</strong>
                    </p>
                </div>
            </a>
        @empty
        @endforelse
    </div>
@endsection
