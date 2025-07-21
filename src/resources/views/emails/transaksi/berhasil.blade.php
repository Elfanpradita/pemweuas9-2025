@component('mail::message')
# ✅ Terima Kasih Telah Berbelanja di Apotek Sehat

Halo **{{ $transaksi->user->name }}**,  
Berikut detail transaksi Anda:

- **ID Transaksi:** {{ $transaksi->id }}  
- **Total Pembayaran:** Rp{{ number_format($transaksi->total) }}  
- **Status:** {{ ucfirst($transaksi->status) }}  
- **Metode Pengiriman:** {{ ucfirst($transaksi->metode_pengiriman) }}  
- **Alamat:** {{ $transaksi->alamat }}

@component('mail::button', ['url' => url('/transaksi/'.$transaksi->id)])
Lihat Detail Transaksi
@endcomponent

Terima kasih telah mempercayai kami.  
Salam hangat,  
**Apotek Sehat**
@endcomponent
