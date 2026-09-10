<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

/**
 * KabidMemberPolicy
 *
 * Memastikan bahwa KABID hanya dapat melihat anggota yang berada
 * di bidang (division) yang menjadi tanggung jawabnya.
 *
 * Authorization dilakukan SEPENUHNYA di server-side:
 * - Memeriksa permission view_division_members
 * - Memeriksa bahwa user memiliki division_id
 * - Memeriksa bahwa member berada di division milik KABID pada periode aktif
 */
class KabidMemberPolicy
{
    /**
     * KABID dapat melihat detail anggota hanya jika:
     * 1. User memiliki permission view_division_members
     * 2. User memiliki division_id (bidang yang ditugaskan)
     * 3. Member tersebut berada di division yang sama dengan KABID (periode aktif)
     */
    public function view(User $user, Member $member): bool
    {
        // Harus memiliki permission view_division_members
        if (!$user->can('view_division_members')) {
            return false;
        }

        // Harus memiliki division_id yang dikonfigurasi
        if (!$user->division_id) {
            return false;
        }

        // Member harus berada di division KABID pada periode aktif
        return $member->divisionMembers()
            ->where('division_id', $user->division_id)
            ->whereHas('period', fn ($q) => $q->where('is_active', true))
            ->exists();
    }
}
