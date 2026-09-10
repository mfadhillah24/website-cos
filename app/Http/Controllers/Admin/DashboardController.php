<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Letter;
use App\Models\Disposition;
use App\Models\Agenda;
use App\Models\Meeting;
use App\Models\Archive;
use App\Models\Program;
use App\Models\Activity;
use App\Models\Division;
use App\Models\DivisionMember;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    protected const KABID_ROLES = [
        'Kabid Networking',
        'Kabid Programming',
        'Kabid Desain Komunikasi Visual',
    ];

    public function index(): View
    {
        $this->authorize('view_dashboard');

        $user = Auth::user();

        // ── Sekretaris Dashboard ──────────────────────────────────────────────
        if ($user->hasRole('Sekretaris')) {
            $incomingTotal    = Letter::where('type', 'incoming')->count();
            $incomingNew      = Letter::where('type', 'incoming')->where('status', 'baru')->count();
            $outgoingTotal    = Letter::where('type', 'outgoing')->count();
            $outgoingThisMonth= Letter::where('type', 'outgoing')
                ->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $dispositionPending = Disposition::where('status', 'menunggu')->count();
            $agendaNext       = Agenda::where('agenda_date', '>=', now()->toDateString())->orderBy('agenda_date')->first();
            $meetingCount     = Meeting::count();
            $archiveCount     = Archive::count();
            $recentLetters = Letter::where('type', 'incoming')->latest()->take(5)->get();

            return view('admin.dashboard.secretary', compact(
                'incomingTotal', 'incomingNew', 'outgoingTotal', 'outgoingThisMonth',
                'dispositionPending', 'agendaNext', 'meetingCount', 'archiveCount', 'recentLetters'
            ));
        }

        // ── Kabid Dashboard (Dynamic Division Scope) ──────────────────────────
        foreach (self::KABID_ROLES as $kabidRole) {
            if ($user->hasRole($kabidRole)) {
                return $this->kabidDashboard($user);
            }
        }

        // ── Default Dashboard ─────────────────────────────────────────────────
        $stats = [
            'total_users'   => User::count(),
            'active_users'  => User::where('is_active', true)->count(),
            'total_roles'   => Role::count(),
            'total_members' => \App\Models\Member::count(),
        ];

        // Jadwal organisasi mendatang + acara multi-hari yang sedang berlangsung
        $upcomingAgendas = Agenda::where(function ($q) {
                // Agenda 1 hari atau mulai hari ini ke depan
                $q->where('agenda_date', '>=', now()->toDateString())
                  // Atau acara multi-hari yang belum selesai (end_date >= hari ini)
                  ->orWhere('end_date', '>=', now()->toDateString());
            })
            ->orderBy('agenda_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'upcomingAgendas'));
    }

    /**
     * Build dynamic Kabid dashboard scoped to the user's division.
     */
    protected function kabidDashboard(User $user): View
    {
        $divisionId = $user->division_id;
        $division   = $divisionId ? Division::find($divisionId) : null;

        $programs = Program::with('pic')
            ->when($divisionId, fn($q) => $q->where('division_id', $divisionId))
            ->latest()
            ->take(5)
            ->get();

        $totalPrograms = Program::when($divisionId, fn($q) => $q->where('division_id', $divisionId))->count();

        $activities = Activity::with('division')
            ->when($divisionId, fn($q) => $q->where('division_id', $divisionId))
            ->latest('start_date')
            ->take(5)
            ->get();

        $totalActivities = Activity::when($divisionId, fn($q) => $q->where('division_id', $divisionId))->count();

        $totalMembers = DivisionMember::when($divisionId, fn($q) => $q->where('division_id', $divisionId))->count();

        return view('admin.dashboard.kabid', compact(
            'user', 'division',
            'programs', 'totalPrograms',
            'activities', 'totalActivities',
            'totalMembers'
        ));
    }
}
