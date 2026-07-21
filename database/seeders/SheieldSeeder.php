<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use App\Models\User;


class SheieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Otomatis generate seluruh permission resource & page Filament Shield
        //Artisan::call('shield:generate', ['--all' => true]);

        // 3. Ambil / Buat Role super_admin dari config Filament Shield
        $roleName = config('filament-shield.super_admin.role_name', 'super_admin');
        $superAdminRole = Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);

        // 4. Buat Akun User Super Admin
        $user = User::firstOrCreate(
            ['email' => 'admin@arsip.com'], // Ganti dengan email Anda
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Ganti dengan password pilihan Anda
                'email_verified_at' => now(),
            ]
        );

        // 5. Hubungkan User dengan Role super_admin
        if (! $user->hasRole($superAdminRole)) {
            $user->assignRole($superAdminRole);
        }
    }
}
