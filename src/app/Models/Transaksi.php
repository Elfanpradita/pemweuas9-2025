<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'metode_pengiriman',
        'alamat',
        'snap_token',
        'status',
    ];

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke toko
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // Relasi ke detail transaksi (item-item obat yang dibeli)
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

}
