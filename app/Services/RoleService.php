<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Buat role baru dan assign permissions.
     */
    public function store(array $data): Role
    {
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);

        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        Cache::forget('spatie.permission.cache');
        return $role;
    }

    /**
     * Update role dan sync permissions.
     */
    public function update(Role $role, array $data): Role
    {
        // Guard: Jangan izinkan rename role Super Admin
        if ($role->name !== 'Super Admin') {
            $role->update(['name' => $data['name']]);
        }

        if (isset($data['permissions'])) {
            // Super Admin selalu punya semua permission
            if ($role->name === 'Super Admin') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($data['permissions']);
            }
        }

        Cache::forget('spatie.permission.cache');
        return $role;
    }

    /**
     * Hapus role (kecuali Super Admin).
     */
    public function delete(Role $role): bool
    {
        if ($role->name === 'Super Admin') {
            return false;
        }

        $role->delete();
        Cache::forget('spatie.permission.cache');
        return true;
    }
}
