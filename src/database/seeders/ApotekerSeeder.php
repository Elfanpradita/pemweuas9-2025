<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Apoteker;
use Illuminate\Database\Seeder;

class ApotekerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Apoteker Satu',
            'email' => 'apoteker@apotek.test',
            'password' => bcrypt('password'),
        ]);

        Apoteker::create([
            'user_id' => $user->id,
            'toko_id' => 1,
            'manager_id' => 1,
            'nama_lengkap' => 'Apoteker Satu',
            'jenis_kelamin' => 'P',
        ]);
    }
}
