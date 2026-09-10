<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Services\PeriodService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeriodController extends Controller
{
    protected PeriodService $periodService;

    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    public function index(): View
    {
        $this->authorize('manage_periods');
        
        $periods = Period::with('closedBy')->latest('start_date')->paginate(10);
        
        return view('admin.periods.index', compact('periods'));
    }

    public function create(): View
    {
        $this->authorize('manage_periods');
        
        return view('admin.periods.create');
    }

    public function store(StorePeriodRequest $request): RedirectResponse
    {
        $this->authorize('manage_periods');
        
        $this->periodService->createPeriod($request->validated());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode kepengurusan berhasil ditambahkan.');
    }

    public function edit(Period $period): View
    {
        $this->authorize('manage_periods');
        
        return view('admin.periods.edit', compact('period'));
    }

    public function update(UpdatePeriodRequest $request, Period $period): RedirectResponse
    {
        $this->authorize('manage_periods');
        
        $this->periodService->updatePeriod($period, $request->validated());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode kepengurusan berhasil diperbarui.');
    }

    public function destroy(Period $period): RedirectResponse
    {
        $this->authorize('manage_periods');
        
        $period->delete();

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode kepengurusan berhasil dihapus.');
    }

    public function close(Period $period): RedirectResponse
    {
        $this->authorize('manage_periods');
        
        if (!$period->is_active) {
            return back()->with('error', 'Periode ini sudah tidak aktif.');
        }

        $this->periodService->closePeriod($period, auth()->id());

        return back()->with('success', 'Periode berhasil ditutup.');
    }
}
