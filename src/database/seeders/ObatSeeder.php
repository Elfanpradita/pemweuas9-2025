<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        Obat::create([
            'toko_id' => 1,
            'apoteker_id' => 1,
            'nama_obat' => 'Paracetamol',
            'harga' => 10000,
            'stok' => 200,
        ]);

        Obat::create([
            'toko_id' => 1,
            'apoteker_id' => 1,
            'nama_obat' => 'Amoxicillin',
            'harga' => 15000,
            'stok' => 150,
        ]);
    }
}
