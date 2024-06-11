@extends('layouts.mainTemblate')
@section('content')
    {{ $products->render() }}
    <div class="products-container">
        @forelse ($products as $product)
            <a href="{{ route('product.show', $product->id) }}">
                <div class="single-product-card">
                    <img src="{{ $product->image }}" alt="" class="single-product-image">
                    <h5 class="single-product-name">
                        {{ $product->name }}
                    </h5>
                    <p class="single-product-price">
                        {{ $product->price }}
                    </p>
                </div>
            </a>
        @empty
        @endforelse
    </div>
@endsection
