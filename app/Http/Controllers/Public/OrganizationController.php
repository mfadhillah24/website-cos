<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Management;
use App\Models\Period;

class OrganizationController extends Controller
{
    public function index()
    {
        $activePeriod = Period::where('is_active', true)->first();

        $managements = collect();
        $allPeriods  = Period::orderByDesc('start_date')->get();

        if ($activePeriod) {
            $managements = Management::with(['member.user', 'position'])
                ->whereHas('member')
                ->where('period_id', $activePeriod->id)
                ->where('is_active', true)
                ->get()
                ->sortBy('position.id');
        }

        return view('public.organization', compact('activePeriod', 'managements', 'allPeriods'));
    }

    public function period(Period $period)
    {
        $managements = Management::with(['member.user', 'position'])
            ->whereHas('member')
            ->where('period_id', $period->id)
            ->get()
            ->sortBy('position.id');

        $allPeriods = Period::orderByDesc('start_date')->get();

        return view('public.organization', compact('period', 'managements', 'allPeriods'));
    }
}
