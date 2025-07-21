<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h1 class="mb-4">🛒 Keranjang Belanja</h1>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($items->count() > 0)
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->obat->nama_obat }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp{{ number_format($item->qty * $item->obat->harga) }}</td>
                    </tr>
                    @php $total += $item->qty * $item->obat->harga; @endphp
                @endforeach
                <tr class="fw-bold table-secondary">
                    <td colspan="2">Total</td>
                    <td>Rp{{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Form Checkout --}}
        <hr class="my-4">
        <h3>🚚 Checkout</h3>
        <form method="POST" action="{{ route('keranjang.checkout') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Metode Pengiriman</label>
                <select name="metode_pengiriman" class="form-select" required id="metode">
                    <option value="ambil">Ambil di Toko</option>
                    <option value="antar">Antar ke Rumah</option>
                </select>
            </div>
            <div class="mb-3" id="alamat-box" style="display: none;">
                <label for="alamat" class="form-label">Alamat Pengiriman</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
            </div>
            <button class="btn btn-success btn-lg">Bayar Sekarang</button>
        </form>
    @else
        <p class="text-muted">Keranjang masih kosong.</p>
    @endif
</div>

<script>
    document.getElementById('metode').addEventListener('change', function () {
        document.getElementById('alamat-box').style.display =
            this.value === 'antar' ? 'block' : 'none';
    });
</script>

</body>
</html>
