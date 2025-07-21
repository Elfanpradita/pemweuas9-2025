<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'nama_obat',
        'harga',
        'stok',
        'apoteker_id',
    ];

    // Relasi ke Toko
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // Relasi ke Apoteker
    public function apoteker()
    {
        return $this->belongsTo(Apoteker::class);
    }

    // Relasi ke keranjang (satu obat bisa banyak keranjang)
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    // Relasi ke detail transaksi (satu obat bisa muncul di banyak transaksi)
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}