<?php

namespace App\Services;

use App\Models\Management;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class ManagementService
{
    /**
     * Create a new management assignment.
     */
    public function createManagement(array $data): Management
    {
        return DB::transaction(function () use ($data) {
            $member = Member::findOrFail($data['member_id']);
            $userId = $member->user_id;

            $data['user_id'] = $userId;
            $data['is_active'] = true;

            $management = Management::create($data);

            if (array_key_exists('email', $data)) {
                $member->update(['email' => $data['email']]);
            }

            if ($userId) {
                // Here we could sync roles to the User based on Position
                // Syncing role logic would go here if needed.
            }

            return $management;
        });
    }

    /**
     * Update a management assignment.
     */
    public function updateManagement(Management $management, array $data): Management
    {
        return DB::transaction(function () use ($management, $data) {
            $member = Member::findOrFail($data['member_id'] ?? $management->member_id);
            $userId = $member->user_id;

            $data['user_id'] = $userId;

            $management->update($data);

            if (array_key_exists('email', $data)) {
                $member->update(['email' => $data['email']]);
            }

            if ($userId) {
                // Re-sync roles if needed.
            }

            return $management;
        });
    }

    /**
     * Deactivate a management assignment (e.g., when a period is closed).
     */
    public function deactivateManagement(Management $management, string $endedAt = null): bool
    {
        return $management->update([
            'is_active' => false,
            'ended_at' => $endedAt ?? now()->toDateString(),
        ]);
    }
}
