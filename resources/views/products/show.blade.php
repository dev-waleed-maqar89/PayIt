@extends('layouts.mainTemblate')
@section('content')
    <div class="container single-product-card">
        <h2 class="single-product-name">
            {{ $product->name }}
        </h2>
        <span class="d-block single-product-price">
            L.E {{ $product->price }}
        </span>
        <span class="d-block single-product-quantity">
            {{ $product->quantity }} available
        </span>
        <div class="">
            <img src="{{ $product->image }}" class="single-product-image">
        </div>
        @auth
            <form action="{{ route('product.addToCart', $product->id) }}" method="POST" class="add-product-to-cart mt-2">
                @csrf
                <div class="form-group row">
                    <label for="quantity" class="form-control col-2">
                        Quantity
                    </label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}"
                        id="quantity" class="form-control offset-1 col-1">
                </div>
                @error('quantity')
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
        </div>
        <div class="form-group row">
            <input type="submit" value="Add to cart" class="form-control offset-2 col-4">
        </div>
        </form>
    @else
        <div class="alert alert-secondary mt-1">
            <a href="{{ route('user.login') }}">Login</a> to add product to cart
        </div>
    @endauth
    </div>
@endsection
