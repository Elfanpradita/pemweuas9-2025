<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $managerPermissions = [
            // Manager biasanya hanya bisa melihat (tanpa CRUD penuh)
            'view_manager',
            'view_any_manager',
            'view_apoteker',
            'view_any_apoteker',
            'view_obat',
            'view_any_obat',
            'view_transaksi',
            'view_any_transaksi',
            'view_dashboard',
            'export_transaksi',

            // Akses data tambahan (opsional)
            'view_toko',
            'view_any_toko',
            'view_role',
            'view_any_role',
        ];

        $apotekerPermissions = [
            // Full access (CRUD) untuk obat & transaksi
            'view_obat',
            'view_any_obat',
            'create_obat',
            'update_obat',
            'delete_obat',
            'delete_any_obat',

            'view_transaksi',
            'view_any_transaksi',
            'create_transaksi',
            'update_transaksi',
            'delete_transaksi',
            'delete_any_transaksi',

            // Keranjang mungkin terkait dalam proses checkout
            'view_keranjang',
            'view_any_keranjang',
            'create_keranjang',
            'update_keranjang',
            'delete_keranjang',
            'delete_any_keranjang',

            // Akses terhadap resource terkait
            'view_toko',
            'view_any_toko',
            'view_role',
            'view_any_role',

            // Login admin
            'login_admin',

            // Opsional tambahan
            'view_dashboard',
        ];

        $allPermissions = array_unique(array_merge(
            $managerPermissions,
            $apotekerPermissions
        ));

        foreach ($allPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $roles = [
            'manager' => $managerPermissions,
            'apoteker' => $apotekerPermissions,
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions(Permission::whereIn('name', $permissions)->get());
        }
    }
}
