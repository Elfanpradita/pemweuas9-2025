<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>
<body class="p-5">

<div class="container text-center">
    <h1>💳 Pembayaran Pesanan</h1>
    <p>Total Pembayaran: <strong>Rp{{ number_format($transaksi->total) }}</strong></p>
    <button id="pay-button" class="btn btn-primary btn-lg">Bayar Sekarang</button>
</div>

<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("✅ Pembayaran berhasil!");
                console.log(result);
                window.location.href = "/transaksi/{{ $transaksi->id }}";
            },
            onPending: function(result){
                alert("⏳ Menunggu pembayaran...");
                console.log(result);
            },
            onError: function(result){
                alert("❌ Pembayaran gagal!");
                console.error(result);
            },
            onClose: function(){
                alert("⚠️ Kamu menutup popup sebelum menyelesaikan pembayaran.");
            }
        });
    });
</script>

</body>
</html>
