<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@ukmitcos.org'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // Admin biasa
        $admin = User::firstOrCreate(
            ['email' => 'admin@ukmitcos.org'],
            [
                'name'      => 'Admin',
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['Admin']);

        $this->command->info('✅ Admin users seeded.');
        $this->command->table(
            ['Name', 'Email', 'Role', 'Password'],
            [
                ['Super Admin', 'superadmin@ukmitcos.org', 'Super Admin', 'password'],
                ['Admin',       'admin@ukmitcos.org',       'Admin',       'password'],
            ]
        );
    }
}
