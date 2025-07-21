<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
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

    {{-- Judul dan Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">🛒 Keranjang Belanja</h1>
        <a href="{{ url('/') }}" class="btn btn-secondary">⬅ Kembali Belanja</a>
    </div>

    {{-- Tabel Keranjang --}}
    @if(count($items) > 0)
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Obat</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($items as $item)
                    @php $subtotal = $item->qty * $item->obat->harga; @endphp
                    <tr>
                        <td>{{ $item->obat->nama_obat }}</td>
                        <td>Rp{{ number_format($item->obat->harga) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp{{ number_format($subtotal) }}</td>
                        <td>
                            <form method="POST" action="{{ route('keranjang.hapus', $item->id) }}" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php $total += $subtotal; @endphp
                @endforeach
                <tr class="fw-bold table-secondary">
                    <td colspan="3" class="text-end">Total</td>
                    <td colspan="2">Rp{{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Form Checkout --}}
        <hr class="my-4">
        <h4>✅ Checkout</h4>
        <form method="POST" action="{{ route('keranjang.checkout') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Metode Pengiriman</label>
                <select name="metode_pengiriman" class="form-select" id="metode" required>
                    <option value="ambil">Ambil di Toko</option>
                    <option value="antar">Antar ke Rumah</option>
                </select>
            </div>
            <div class="mb-3" id="alamatBox" style="display:none;">
                <label class="form-label">Alamat Pengiriman</label>
                <textarea name="alamat" class="form-control" rows="2"></textarea>
            </div>
            <button class="btn btn-success">Bayar Sekarang</button>
        </form>
    @else
        <p class="text-muted">Keranjang masih kosong.</p>
    @endif

</div>

<script>
document.getElementById('metode').addEventListener('change', function() {
    document.getElementById('alamatBox').style.display = this.value === 'antar' ? 'block' : 'none';
});
</script>

</body>
</html>
