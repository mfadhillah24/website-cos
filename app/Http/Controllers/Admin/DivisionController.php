<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Services\DivisionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DivisionController extends Controller
{
    protected DivisionService $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(Request $request): View
    {
        $this->authorize('view_division');

        // Apply division scope if set
        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        
        $divisions = Division::withCount('divisionMembers')
            ->when($scopedDivisionId, function ($query) use ($scopedDivisionId) {
                return $query->where('id', $scopedDivisionId);
            })
            ->get();

        return view('admin.divisions.index', compact('divisions'));
    }

    public function create(): View
    {
        $this->authorize('manage_division');
        return view('admin.divisions.create');
    }

    public function store(StoreDivisionRequest $request): RedirectResponse
    {
        $this->authorize('manage_division');
        $this->divisionService->createDivision($request->validated());

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dibuat.');
    }

    public function show(Division $division, Request $request): View
    {
        $this->authorize('view_division');
        $this->checkScope($request, $division->id);

        $division->load(['divisionMembers.member', 'divisionMembers.period', 'programs']);
        
        $activePeriod = \App\Models\Period::where('is_active', true)->first();
        
        // Only Anggota Tetap (status_id = 2) or Pendiri (status_id = 4)
        $availableMembers = \App\Models\Member::whereIn('status_id', [2, 4])
            ->whereDoesntHave('divisionMembers', function($q) use ($division, $activePeriod) {
                $q->where('division_id', $division->id);
                if ($activePeriod) {
                    $q->where('period_id', $activePeriod->id);
                }
            })->get();

        return view('admin.divisions.show', compact('division', 'availableMembers', 'activePeriod'));
    }

    public function storeMember(Request $request, Division $division): RedirectResponse
    {
        $this->authorize('manage_division');
        
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'role_in_division' => 'nullable|string|max:100',
            'joined_at' => 'nullable|date',
        ]);
        
        $activePeriod = \App\Models\Period::where('is_active', true)->first();
        if (!$activePeriod) {
            return back()->with('error', 'Tidak ada periode aktif saat ini.');
        }

        \App\Models\DivisionMember::create([
            'division_id' => $division->id,
            'member_id' => $request->member_id,
            'period_id' => $activePeriod->id,
            'role_in_division' => $request->role_in_division ?? 'Anggota',
            'joined_at' => $request->joined_at ?? now(),
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan ke divisi.');
    }

    public function destroyMember(Division $division, $memberId): RedirectResponse
    {
        $this->authorize('manage_division');
        
        $divisionMember = \App\Models\DivisionMember::where('division_id', $division->id)
            ->where('id', $memberId)
            ->firstOrFail();
            
        $divisionMember->delete();
        
        return back()->with('success', 'Anggota berhasil dihapus dari divisi.');
    }

    public function edit(Division $division, Request $request): View
    {
        $this->authorize('manage_division');
        $this->checkScope($request, $division->id);

        return view('admin.divisions.edit', compact('division'));
    }

    public function update(UpdateDivisionRequest $request, Division $division): RedirectResponse
    {
        $this->authorize('manage_division');
        $this->checkScope($request, $division->id);

        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($division->cover_image) {
                \Illuminate\Support\Facades\File::delete(public_path('images/' . $division->cover_image));
            }
            $file = $request->file('cover_image');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/divisions/covers'), $filename);
            $validated['cover_image'] = 'divisions/covers/' . $filename;
        }

        if ($request->hasFile('logo')) {
            if ($division->logo) {
                \Illuminate\Support\Facades\File::delete(public_path('images/' . $division->logo));
            }
            $file = $request->file('logo');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/divisions/logos'), $filename);
            $validated['logo'] = 'divisions/logos/' . $filename;
        }

        if (isset($validated['focus_areas'])) {
            $validated['focus_areas'] = array_map('trim', explode(',', $validated['focus_areas']));
        }

        $this->divisionService->updateDivision($division, $validated);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division): RedirectResponse
    {
        $this->authorize('manage_division');
        $this->divisionService->deleteDivision($division);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }

    protected function checkScope(Request $request, int $divisionId)
    {
        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        if ($scopedDivisionId && $scopedDivisionId != $divisionId) {
            abort(403, 'Unauthorized action.');
        }
    }
}
