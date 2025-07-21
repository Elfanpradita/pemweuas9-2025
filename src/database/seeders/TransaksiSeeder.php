<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        Transaksi::create([
            'user_id' => 3,
            'total' => 20000,
            'metode_pengiriman' => 'ambil',
            'alamat' => null,
            'status' => 'pending',
        ]);
    }
}
