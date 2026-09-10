<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Division;
use App\Models\Period;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Services\ProgramService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgramController extends Controller
{
    protected ProgramService $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index(Request $request): View
    {
        $this->authorize('view_programs');

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        $activePeriod = Period::where('is_active', true)->first();

        $programs = Program::with(['division', 'pic'])
            ->when($scopedDivisionId, function ($query) use ($scopedDivisionId) {
                return $query->where('division_id', $scopedDivisionId);
            })
            ->when($activePeriod, function ($query) use ($activePeriod) {
                return $query->where('period_id', $activePeriod->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.programs.index', compact('programs', 'activePeriod'));
    }

    public function create(Request $request): View
    {
        $this->authorize('manage_programs');
        
        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        $divisions = Division::when($scopedDivisionId, function($q) use ($scopedDivisionId) {
            return $q->where('id', $scopedDivisionId);
        })->get();

        return view('admin.programs.create', compact('divisions'));
    }

    public function store(StoreProgramRequest $request): RedirectResponse
    {
        $this->authorize('manage_programs');
        
        // Scope check in request
        $this->checkScope($request, $request->division_id);

        $this->programService->createProgram($request->validated());

        return redirect()->route('admin.programs.index')->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    public function show(Program $program, Request $request): View
    {
        $this->authorize('view_programs');
        $this->checkScope($request, $program->division_id);

        $program->load(['division', 'period', 'pic', 'creator']);
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program, Request $request): View
    {
        $this->authorize('manage_programs');
        $this->checkScope($request, $program->division_id);

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        $divisions = Division::when($scopedDivisionId, function($q) use ($scopedDivisionId) {
            return $q->where('id', $scopedDivisionId);
        })->get();

        return view('admin.programs.edit', compact('program', 'divisions'));
    }

    public function update(UpdateProgramRequest $request, Program $program): RedirectResponse
    {
        $this->authorize('manage_programs');
        $this->checkScope($request, $program->division_id);
        if ($request->has('division_id')) {
            $this->checkScope($request, $request->division_id);
        }

        $this->programService->updateProgram($program, $request->validated());

        return redirect()->route('admin.programs.index')->with('success', 'Program Kerja berhasil diperbarui.');
    }

    public function destroy(Program $program, Request $request): RedirectResponse
    {
        $this->authorize('manage_programs');
        $this->checkScope($request, $program->division_id);

        $this->programService->deleteProgram($program);

        return redirect()->route('admin.programs.index')->with('success', 'Program Kerja berhasil dihapus.');
    }

    protected function checkScope(Request $request, int $divisionId)
    {
        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        if ($scopedDivisionId && $scopedDivisionId != $divisionId) {
            abort(403, 'Unauthorized action (Division Scope Constraint).');
        }
    }
}
