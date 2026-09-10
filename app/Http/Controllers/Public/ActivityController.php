<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('division')
            ->orderByDesc('start_date')
            ->paginate(12);

        return view('public.activities.index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        $activity->load(['division', 'photos']);

        $related = Activity::where('id', '!=', $activity->id)
            ->where(function($q) use ($activity) {
                $q->where('division_id', $activity->division_id)
                  ->orWhere('period_id', $activity->period_id);
            })
            ->orderByDesc('start_date')
            ->limit(3)
            ->get();

        return view('public.activities.show', compact('activity', 'related'));
    }
}
