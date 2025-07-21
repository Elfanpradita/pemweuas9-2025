<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">🩺 Apotek Sehat</a>
        <div class="ms-auto d-flex align-items-center">

            @auth
                <a href="{{ route('keranjang.index') }}" class="btn btn-light text-primary me-3">
                    🛒 Keranjang <span class="badge bg-danger">{{ $cartCount ?? 0 }}</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-light me-3">
                    📜 Transaksi Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light">
                        {{ Auth::user()->name }} | Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-light text-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>
