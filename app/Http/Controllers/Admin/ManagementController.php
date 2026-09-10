<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Management;
use App\Models\Member;
use App\Models\Period;
use App\Models\Position;
use App\Http\Requests\StoreManagementRequest;
use App\Http\Requests\UpdateManagementRequest;
use App\Services\ManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManagementController extends Controller
{
    protected ManagementService $managementService;

    public function __construct(ManagementService $managementService)
    {
        $this->managementService = $managementService;
    }

    public function index(): View
    {
        $this->authorize('view_management');

        $periods = Period::orderByDesc('start_date')->get();
        
        $selectedPeriodId = request('period_id');
        $activePeriod = null;

        if ($selectedPeriodId) {
            $activePeriod = Period::find($selectedPeriodId);
        }

        if (!$activePeriod) {
            $activePeriod = Period::where('is_active', true)->first();
        }

        $managements = Management::with(['member', 'period', 'position', 'user'])
            ->whereHas('member')
            ->when($activePeriod, function ($query) use ($activePeriod) {
                return $query->where('period_id', $activePeriod->id);
            })
            ->get()
            ->sortBy(function ($management) {
                return $management->position->order ?? 999;
            });

        return view('admin.managements.index', compact('managements', 'activePeriod', 'periods'));
    }

    public function create(): View
    {
        $this->authorize('manage_management');

        $members = Member::whereHas('status', function ($query) {
            $query->where('name', 'Anggota Tetap');
        })->orderBy('name')->get();
        $periods = Period::orderBy('start_date', 'desc')->get();
        $positions = Position::orderBy('order')->get();

        return view('admin.managements.create', compact('members', 'periods', 'positions'));
    }

    public function store(StoreManagementRequest $request): RedirectResponse
    {
        $this->authorize('manage_management');

        $this->managementService->createManagement($request->validated());

        return redirect()->route('admin.managements.index')
            ->with('success', 'Anggota berhasil ditugaskan ke jabatan.');
    }

    public function edit(Management $management): View
    {
        $this->authorize('manage_management');

        $members = Member::whereHas('status', function ($query) {
            $query->where('name', 'Anggota Tetap');
        })->orderBy('name')->get();
        $periods = Period::orderBy('start_date', 'desc')->get();
        $positions = Position::orderBy('order')->get();

        return view('admin.managements.edit', compact('management', 'members', 'periods', 'positions'));
    }

    public function update(UpdateManagementRequest $request, Management $management): RedirectResponse
    {
        $this->authorize('manage_management');

        $this->managementService->updateManagement($management, $request->validated());

        return redirect()->route('admin.managements.index')
            ->with('success', 'Jabatan anggota berhasil diperbarui.');
    }

    public function destroy(Management $management): RedirectResponse
    {
        $this->authorize('manage_management');

        $management->delete();

        return redirect()->route('admin.managements.index')
            ->with('success', 'Jabatan anggota berhasil dihapus.');
    }
}
