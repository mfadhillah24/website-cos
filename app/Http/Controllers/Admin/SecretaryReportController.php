<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Disposition;
use App\Models\Meeting;
use App\Models\MeetingMinute;
use App\Models\Archive;
use App\Models\Agenda;
use Illuminate\Http\Request;

class SecretaryReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_admin_reports');

        $year  = $request->year ?? now()->year;
        $month = $request->month;

        $incomingQuery = Letter::where('type', 'incoming')->whereYear('created_at', $year);
        $outgoingQuery = Letter::where('type', 'outgoing')->whereYear('created_at', $year);

        if ($month) {
            $incomingQuery->whereMonth('created_at', $month);
            $outgoingQuery->whereMonth('created_at', $month);
        }

        $incomingLetters = $incomingQuery->latest()->get();
        $outgoingLetters = $outgoingQuery->latest()->get();
        $dispositions    = Disposition::with(['letter','assignedTo'])->whereYear('disposition_date', $year)->get();
        $meetings        = Meeting::whereYear('meeting_date', $year)->get();
        $archives        = Archive::whereYear('created_at', $year)->get();
        $agendas         = Agenda::whereYear('agenda_date', $year)->get();

        $years = range(now()->year, 2020);

        return view('admin.reports.secretary', compact(
            'incomingLetters', 'outgoingLetters', 'dispositions',
            'meetings', 'archives', 'agendas', 'year', 'month', 'years'
        ));
    }
}