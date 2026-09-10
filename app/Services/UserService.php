<?php

namespace App\Services;

use App\Models\User;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Buat user baru dan assign role.
     */
    public function store(array $data): User
    {
        $divisionId = $this->resolveDivisionId($data['roles'] ?? []);

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'is_active'   => $data['is_active'] ?? true,
            'division_id' => $divisionId,
        ]);

        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Update data user dan sync role.
     */
    public function update(User $user, array $data): User
    {
        $divisionId = $this->resolveDivisionId($data['roles'] ?? []);

        $payload = [
            'name'        => $data['name'],
            'email'       => $data['email'],
            'is_active'   => $data['is_active'] ?? $user->is_active,
            'division_id' => $divisionId,
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Resolve division_id from roles array.
     * Maps specific Kabid roles to their division automatically.
     */
    protected function resolveDivisionId(array $roles): ?int
    {
        $roleMap = [
            'Kabid Networking'               => 'networking',
            'Kabid Programming'             => 'programming',
            'Kabid Desain Komunikasi Visual' => 'dkv',
        ];

        foreach ($roles as $roleName) {
            if (isset($roleMap[$roleName])) {
                $division = Division::where('slug', $roleMap[$roleName])->first();
                return $division?->id;
            }
        }

        return null;
    }

    /**
     * Toggle status aktif user.
     */
    public function toggleActive(User $user): User
    {
        $user->update(['is_active' => !$user->is_active]);
        return $user;
    }
}
