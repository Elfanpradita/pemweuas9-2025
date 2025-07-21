<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Keranjang;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@apotek.test',
            'password' => bcrypt('password'),
        ]);

        Keranjang::create([
            'user_id' => $user->id,
            'obat_id' => 1,
            'qty' => 2,
        ]);
    }
}
