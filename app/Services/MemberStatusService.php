<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberStatusHistory;

class MemberStatusService
{
    /**
     * Catat histori perubahan status anggota.
     */
    public function recordHistory(Member $member, ?int $fromStatusId, int $toStatusId, ?string $notes = null): MemberStatusHistory
    {
        return MemberStatusHistory::create([
            'member_id'      => $member->id,
            'from_status_id' => $fromStatusId,
            'to_status_id'   => $toStatusId,
            'changed_by'     => auth()->id(),
            'notes'          => $notes,
        ]);
    }
}
