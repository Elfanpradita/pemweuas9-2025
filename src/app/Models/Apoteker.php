<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apoteker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'toko_id',
        'manager_id',
        'nama_lengkap',
        'jenis_kelamin',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Toko
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // Relasi ke Manager
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    // Di App\Models\Apoteker.php
public function obats()
{
    return $this->hasMany(Obat::class);
}

}
