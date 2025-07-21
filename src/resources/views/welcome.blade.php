<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Navbar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">🩺 Apotek Sehat</h1>
        <div class="d-flex align-items-center">
            @auth
                <a href="{{ route('keranjang.index') }}" class="btn btn-light text-primary me-3">
                    🛒 Keranjang <span class="badge bg-danger">{{ $cartCount ?? 0 }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger">{{ Auth::user()->name }} | Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </div>

    {{-- Daftar Obat --}}
    <h3>💊 Daftar Obat</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($obats as $obat)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $obat->nama_obat }}</h5>
                    <p class="card-text">Harga: Rp{{ number_format($obat->harga) }}</p>

                    @auth
                    <form method="POST" action="{{ route('keranjang.tambah') }}">
                        @csrf
                        <input type="hidden" name="obat_id" value="{{ $obat->id }}">
                        <input type="number" name="qty" value="1" class="form-control mb-2" min="1">
                        <button class="btn btn-primary w-100">Tambah ke Keranjang</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-warning w-100">Login untuk membeli</a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
</body>
</html>
