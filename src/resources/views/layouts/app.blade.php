<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        {{-- Navbar --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">🩺 Apotek Sehat</h2>
            <div>
                @auth
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

        @yield('content')
    </div>
</body>
</html>
