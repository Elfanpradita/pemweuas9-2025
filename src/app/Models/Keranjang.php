<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'obat_id',
        'qty',
    ];

    // Relasi ke User (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
