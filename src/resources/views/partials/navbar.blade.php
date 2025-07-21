<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Apotek Online</a>
        <div class="ms-auto d-flex align-items-center">

            @auth
                <!-- Tampilkan Keranjang -->
                <a href="{{ route('keranjang.index') }}" class="btn btn-light text-primary me-3">
                    🛒 Keranjang <span class="badge bg-danger">{{ $cartCount ?? 0 }}</span>
                </a>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light">
                        {{ Auth::user()->name }} | Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn
