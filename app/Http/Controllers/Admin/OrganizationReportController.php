<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisionReport;
use App\Models\Division;
use App\Models\Period;
use Illuminate\View\View;

class OrganizationReportController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_org_reports');

        $reports = DivisionReport::with(['division', 'period', 'author'])
            ->where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->get();

        $divisions = Division::withCount(['reports as approved_reports_count' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

        return view('admin.organization_reports.index', compact('reports', 'divisions'));
    }

    public function show(DivisionReport $divisionReport): View
    {
        $this->authorize('view_org_reports');
        abort_unless($divisionReport->status === 'approved', 403, 'Laporan ini belum disetujui.');
        $divisionReport->load(['division', 'period', 'author', 'reviews.reviewer', 'photos']);
        return view('admin.organization_reports.show', compact('divisionReport'));
    }
}
