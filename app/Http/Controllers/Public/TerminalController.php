<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use Carbon\Carbon;

class TerminalController extends Controller
{
    public function activities(Request $request)
    {
        $activities = Activity::where('status', '!=', 'draft')
            ->orderBy('start_date', 'asc')
            ->whereDate('start_date', '>=', Carbon::today())
            ->limit(5)
            ->get();

        $formatted = $activities->map(function ($act) {
            $dateStr = $act->start_date ? $act->start_date->format('d M Y') : 'TBA';
            return [
                'title' => $act->title,
                'date' => $dateStr,
                'location' => $act->location ?? 'TBA',
                'slug' => $act->slug,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }
}
