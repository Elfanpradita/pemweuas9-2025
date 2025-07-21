<?php

namespace Database\Seeders;

use App\Models\Toko;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        Toko::create([
            'name' => 'Apotek Sehat',
            'address' => 'Jl. Kesehatan No.1, Jakarta',
            'logo' => 'logo.png',
        ]);
    }
}
