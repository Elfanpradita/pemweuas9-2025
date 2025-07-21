<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Manager Apotek',
            'email' => 'manager@apotek.test',
            'password' => bcrypt('password'),
        ]);

        Manager::create([
            'user_id' => $user->id,
            'toko_id' => 1,
            'nama_lengkap' => 'Manager Apotek Sehat',
            'jenis_kelamin' => 'L',
        ]);
    }
}
