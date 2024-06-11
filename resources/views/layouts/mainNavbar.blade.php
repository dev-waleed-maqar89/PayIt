<nav class="navbar-container">
    <ul class="pt-2 main-navbar">
        <li><a class="navbar-link" href="{{ route('product.index') }}">products</a></li>
        @auth
            <li><a class="navbar-link" href="{{ route('order.index') }}">Orders</a></li>
            @if (auth()->user()->cart)
                <li><a class="navbar-link" href="{{ route('order.show', auth()->user()->cart->id) }}">Cart</a></li>
            @endif
            <li><a class="navbar-link" href="{{ route('user.logout') }}">Logout</a></li>
        @else
            <li><a class="navbar-link" href="{{ route('user.login') }}">Login</a></li>
            <li><a class="navbar-link" href="{{ route('user.create') }}">register</a></li>
        @endauth
    </ul>
</nav>
