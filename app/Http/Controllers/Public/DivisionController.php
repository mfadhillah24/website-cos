<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Division;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::where('is_active', true)
            ->withCount('programs')
            ->get();

        return view('public.divisions.index', compact('divisions'));
    }

    public function show(Division $division)
    {
        $division->load(['programs' => function ($q) {
            $q->whereIn('status', ['planning', 'on_progress', 'completed']);
        }]);

        $activePeriod = \App\Models\Period::where('is_active', true)->first();
        $kabid = null;
        $members = collect();

        if ($activePeriod) {
            $positionSlug = 'kabid-' . $division->slug;

            $kabidManagement = \App\Models\Management::with(['member.user', 'position'])
                ->where('period_id', $activePeriod->id)
                ->whereHas('position', function($q) use ($positionSlug) {
                    $q->where('slug', $positionSlug);
                })
                ->first();

            if ($kabidManagement && $kabidManagement->member) {
                $kabid = $kabidManagement->member;
                $kabid->position_name = $kabidManagement->position->name;
                $kabid->period_name = $activePeriod->name;
            }

            // Menampilkan seluruh anggota (sama seperti Data Kabid)
            $members = \App\Models\Member::with(['divisionMembers' => function($q) use ($division, $activePeriod) {
                    $q->where('division_id', $division->id)
                      ->where('period_id', $activePeriod->id);
                }])
                ->whereHas('divisionMembers', function($q) use ($division, $activePeriod) {
                    $q->where('division_id', $division->id)
                      ->where('period_id', $activePeriod->id);
                })
                ->get()
                ->map(function($member) {
                    $divMember = $member->divisionMembers->first();
                    $member->role_in_division = $divMember && $divMember->role_in_division 
                        ? $divMember->role_in_division 
                        : 'Anggota Bidang';
                    return $member;
                })
                ->filter(function($member) use ($kabid) {
                    return !$kabid || $member->id !== $kabid->id;
                })
                ->values();
        }

        $upcomingActivities = \App\Models\Activity::where('division_id', $division->id)
            ->where('status', 'published')
            ->whereDate('start_date', '>', now())
            ->orderBy('start_date')
            ->get();

        $activities = \App\Models\Activity::where('division_id', $division->id)
            ->where('status', 'published')
            ->whereDate('start_date', '<=', now())
            ->orderByDesc('start_date')
            ->paginate(6);
            

        return view('public.divisions.show', compact('division', 'kabid', 'members', 'upcomingActivities', 'activities'));
    }
}
