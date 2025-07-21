<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'apoteker']);
        Role::firstOrCreate(['name' => 'pembeli']); // role ini sebenernya ga perlu soalnya dia cuma diluar
        // tambahkan role lain di sini bila diperlukan
    }
}