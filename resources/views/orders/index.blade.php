@extends('layouts.mainTemblate')
@section('content')
    {{ $orders->links() }}
    <table class="table">
        <tr>
            <th>Orde number</th>
            <th>Created at</th>
            <th>Amount</th>
            <th>Checout</th>
        </tr>
        @forelse ($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('order.show', $order->id) }}">
                        {{ $order->id }}
                    </a>
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
                <td>
                    {{ $order->amount }}
                </td>
                @if ($order->paid)
                    <td>
                        <div class="alert alert-success">
                            Order paid!
                        </div>
                    </td>
                @else
                    <td>
                        <form action="{{ route('order.checkout', $order->id) }}" method="Post" class="Checkout-form">
                            @csrf
                            <div class="form-group">
                                <input type="submit" value="Checkout" class="form-control">
                            </div>
                        </form>
                    </td>
                @endif
            </tr>
        @empty
        @endforelse
    </table>
@endsection
