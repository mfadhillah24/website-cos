<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Division;

class MigrateKetuaBidangSeeder extends Seeder
{
    public function run(): void
    {
        $oldRole = Role::where('name', 'Ketua Bidang')->first();
        
        $permissions = [
            'view_dashboard', 'view_division', 'manage_division', 
            'view_programs', 'manage_programs', 'view_activities', 'manage_activities', 
            'view_reports', 'submit_reports'
        ];

        $rolesToCreate = [
            'Networking' => 'Kabid Networking',
            'Programming' => 'Kabid Programming',
            'DKV' => 'Kabid Desain Komunikasi Visual'
        ];

        foreach ($rolesToCreate as $divName => $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        }

        // Migrate users if oldRole exists
        if ($oldRole) {
            $users = User::role('Ketua Bidang')->get();
            foreach ($users as $user) {
                // Try to infer division from name or explicitly assign
                if (str_contains(strtolower($user->name), 'networking')) {
                    $div = Division::where('slug', 'networking')->first();
                    $user->syncRoles('Kabid Networking');
                    $user->division_id = $div->id ?? null;
                    $user->save();
                } elseif (str_contains(strtolower($user->name), 'programming')) {
                    $div = Division::where('slug', 'programming')->first();
                    $user->syncRoles('Kabid Programming');
                    $user->division_id = $div->id ?? null;
                    $user->save();
                } elseif (str_contains(strtolower($user->name), 'dkv')) {
                    $div = Division::where('slug', 'dkv')->first();
                    $user->syncRoles('Kabid Desain Komunikasi Visual');
                    $user->division_id = $div->id ?? null;
                    $user->save();
                } else {
                    // Remove role but don't delete user if we can't infer
                    $user->removeRole('Ketua Bidang');
                }
            }
            // Delete old role
            $oldRole->delete();
        }
        
        $this->command->info('✅ Role Ketua Bidang has been migrated to specific Kabid roles.');
    }
}
