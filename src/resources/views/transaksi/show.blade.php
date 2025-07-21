<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h1>📦 Detail Transaksi</h1>

    <div class="card shadow-sm p-3">
        <p><strong>ID Transaksi:</strong> {{ $transaksi->id }}</p>
        <p><strong>Total:</strong> Rp{{ number_format($transaksi->total) }}</p>
        <p><strong>Status:</strong> 
            <span class="badge bg-{{ $transaksi->status == 'settlement' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'secondary') }}">
                {{ ucfirst($transaksi->status) }}
            </span>
            <a href="{{ route('transaksi.cekStatus', $transaksi->id) }}" class="btn btn-sm btn-outline-primary ms-2">
                🔄 Cek Status
            </a>
        </p>
        <p><strong>Metode Pengiriman:</strong> {{ ucfirst($transaksi->metode_pengiriman) }}</p>
        <p><strong>Alamat:</strong> {{ $transaksi->alamat }}</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
