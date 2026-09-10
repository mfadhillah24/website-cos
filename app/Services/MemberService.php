<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberService
{
    protected MemberStatusService $statusService;

    public function __construct(MemberStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function createMember(array $data, ?UploadedFile $photo): Member
    {
        if ($photo) {
            $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/members'), $filename);
            $data['photo'] = 'members/' . $filename;
        }

        $member = Member::create($data);

        // Handle division assignment
        if (!empty($data['division_id'])) {
            $activePeriod = \App\Models\Period::where('is_active', true)->first();
            if ($activePeriod) {
                \App\Models\DivisionMember::create([
                    'member_id' => $member->id,
                    'division_id' => $data['division_id'],
                    'period_id' => $activePeriod->id,
                    'role_in_division' => 'anggota',
                    'joined_at' => now(),
                ]);
            }
        }

        // Record initial status
        if (isset($data['status_id'])) {
            $this->statusService->recordHistory(
                member: $member,
                fromStatusId: null,
                toStatusId: $data['status_id'],
                notes: 'Penambahan anggota baru.'
            );
        }

        return $member;
    }

    public function updateMember(Member $member, array $data, ?UploadedFile $photo): Member
    {
        $oldStatusId = $member->status_id;

        if ($photo) {
            if ($member->photo) {
                \Illuminate\Support\Facades\File::delete(public_path('images/' . $member->photo));
            }
            $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/members'), $filename);
            $data['photo'] = 'members/' . $filename;
        }

        $member->update($data);

        // Handle division assignment update
        if (array_key_exists('division_id', $data)) {
            $activePeriod = \App\Models\Period::where('is_active', true)->first();
            if ($activePeriod) {
                if (empty($data['division_id'])) {
                    // Remove current active division member entry if division_id is empty
                    \App\Models\DivisionMember::where('member_id', $member->id)
                        ->where('period_id', $activePeriod->id)
                        ->delete();
                } else {
                    // Update or create division member entry
                    \App\Models\DivisionMember::updateOrCreate(
                        [
                            'member_id' => $member->id,
                            'period_id' => $activePeriod->id,
                        ],
                        [
                            'division_id' => $data['division_id'],
                            'role_in_division' => 'anggota',
                            'joined_at' => now(),
                        ]
                    );
                }
            }
        }

        // Record status change history if changed
        if (isset($data['status_id']) && $data['status_id'] != $oldStatusId) {
            $this->statusService->recordHistory(
                member: $member,
                fromStatusId: $oldStatusId,
                toStatusId: $data['status_id'],
                notes: $data['status_change_notes'] ?? 'Perubahan status via Edit Anggota.'
            );
        }

        return $member;
    }

    public function deleteMember(Member $member): void
    {
        if ($member->photo) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $member->photo));
        }
        $member->delete(); // Soft deletes applied
    }
}
