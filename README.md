# 💊 Aplikasi Apotek Online – UAS Pemrograman Web

Aplikasi ini dibangun menggunakan Laravel 12 dan Filament v3 untuk memudahkan pembeli dalam membeli obat secara online, serta memudahkan apoteker dan manajer dalam mengelola data melalui dashboard admin.

## 🔧 Teknologi yang Digunakan

- **Laravel 12** – Framework PHP modern dan powerful
- **Filament v3** – Admin panel cepat & mudah
- **Midtrans Snap** – Gateway pembayaran online
- **Laravel Mail** – Untuk mengirim email invoice otomatis
- **WhatsApp API** – Notifikasi WhatsApp (opsional/manual via webhook)

## 👥 Role & Fitur Utama

### Pembeli (Frontend)
- Registrasi & login
- Lihat daftar obat
- Tambah ke keranjang
- Checkout (pilih metode ambil/antar)
- Pembayaran via Midtrans Snap
- Email invoice otomatis

### Apoteker (Backend - Filament)
- Login admin
- CRUD data obat
- Proses transaksi
- Update status pengiriman

### Manajer (Backend - Filament)
- Login admin
- Lihat laporan penjualan
- Export data transaksi
- Monitoring performa toko

## 📦 Ronaldo