<!DOCTYPE html>
<html>
<head>
    <title>Register - Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 500px">
    <h2 class="text-center mb-4">📝 Daftar Akun Baru</h2>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">👤 Nama</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">📧 Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">🔑 Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">🔁 Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Daftar</button>
    </form>

    <p class="mt-3 text-center">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a>
    </p>
</div>
</body>
</html>
    