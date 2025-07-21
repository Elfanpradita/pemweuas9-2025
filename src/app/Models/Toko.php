<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'address',
    ];

    // Di App\Models\Toko.php
public function managers()
{
    return $this->hasMany(Manager::class);
}

public function apotekers()
{
    return $this->hasMany(Apoteker::class);
}

// Di App\Models\Toko.php
public function obats()
{
    return $this->hasMany(Obat::class);
}

public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}


}
