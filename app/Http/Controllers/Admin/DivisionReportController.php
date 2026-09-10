<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisionReport;
use App\Models\Division;
use App\Models\Period;
use App\Models\ReportPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Services\NotificationService;

class DivisionReportController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_reports');

        $user = Auth::user();
        $query = DivisionReport::with(['division', 'period', 'author'])->orderBy('activity_date', 'desc');

        // If user is a Ketua Bidang, only show their own reports
        if (!$user->hasPermissionTo('manage_all_reports') && !$user->hasRole(['Super Admin', 'Admin'])) {
            $query->where('author_id', $user->id);
        }

        $reports = $query->get();
        return view('admin.division_reports.index', compact('reports'));
    }

    public function create(): View
    {
        $this->authorize('submit_reports');
        $divisions = Division::all();
        $periods   = Period::orderBy('start_year', 'desc')->get();
        return view('admin.division_reports.create', compact('divisions', 'periods'));
    }

    public function store(Request $request)
    {
        $this->authorize('submit_reports');

        $data = $request->validate([
            'division_id'   => ['required', 'exists:divisions,id'],
            'period_id'     => ['required', 'exists:periods,id'],
            'title'         => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'activity_type' => ['required', 'in:pembelajaran,program_kerja,rapat,lainnya'],
            'content'       => ['required', 'string'],
        ]);

        $data['author_id'] = Auth::id();
        $data['status']    = 'draft';

        $report = DivisionReport::create($data);

        return redirect()->route('admin.division-reports.show', $report)
            ->with('success', 'Laporan kegiatan berhasil dibuat. Unggah foto dokumentasi di bawah, lalu ajukan ke Ketua.');
    }

    public function show(DivisionReport $divisionReport): View
    {
        $this->authorize('view_reports');
        $divisionReport->load(['division', 'period', 'author', 'reviews.reviewer', 'photos']);
        return view('admin.division_reports.show', compact('divisionReport'));
    }

    public function edit(DivisionReport $divisionReport): View
    {
        $this->authorize('submit_reports');
        abort_unless($divisionReport->isEditable(), 403, 'Laporan ini tidak dapat diedit karena sudah diajukan.');
        $divisions = Division::all();
        $periods   = Period::orderBy('start_year', 'desc')->get();
        return view('admin.division_reports.edit', compact('divisionReport', 'divisions', 'periods'));
    }

    public function update(Request $request, DivisionReport $divisionReport)
    {
        $this->authorize('submit_reports');
        abort_unless($divisionReport->isEditable(), 403, 'Laporan ini tidak dapat diedit.');

        $data = $request->validate([
            'division_id'   => ['required', 'exists:divisions,id'],
            'period_id'     => ['required', 'exists:periods,id'],
            'title'         => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'activity_type' => ['required', 'in:pembelajaran,program_kerja,rapat,lainnya'],
            'content'       => ['required', 'string'],
        ]);

        $divisionReport->update($data);
        return redirect()->route('admin.division-reports.show', $divisionReport)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function submit(DivisionReport $divisionReport)
    {
        $this->authorize('submit_reports');
        abort_unless($divisionReport->isEditable(), 403, 'Laporan ini tidak bisa diajukan.');

        $divisionReport->update([
            'status'       => 'submitted',
            'submitted_at' => now(),
        ]);

        NotificationService::sendToRole(
            'Ketua Umum',
            'Laporan Baru',
            "Laporan '{$divisionReport->title}' diajukan oleh " . $divisionReport->author->name,
            'report_submitted',
            route('admin.report-reviews.show', $divisionReport->id)
        );

        return redirect()->route('admin.division-reports.show', $divisionReport)
            ->with('success', 'Laporan berhasil diajukan ke Ketua Umum untuk direview.');
    }

    public function uploadPhotos(Request $request, DivisionReport $divisionReport)
    {
        $this->authorize('submit_reports');

        $request->validate([
            'photos'     => ['required', 'array'],
            'photos.*'   => ['image', 'max:3072'],
            'captions'   => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($request->file('photos') as $index => $photo) {
            $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/report_photos'), $filename);
            $path = 'report_photos/' . $filename;
            ReportPhoto::create([
                'report_id'  => $divisionReport->id,
                'photo_path' => $path,
                'caption'    => $request->captions[$index] ?? null,
            ]);
        }

        return redirect()->route('admin.division-reports.show', $divisionReport)
            ->with('success', 'Foto dokumentasi berhasil diunggah.');
    }

    public function destroyPhoto(ReportPhoto $photo)
    {
        $this->authorize('submit_reports');
        \Illuminate\Support\Facades\File::delete(public_path('images/' . $photo->photo_path));
        $reportId = $photo->report_id;
        $photo->delete();
        return redirect()->route('admin.division-reports.show', $reportId)
            ->with('success', 'Foto berhasil dihapus.');
    }

    public function destroy(DivisionReport $divisionReport)
    {
        $this->authorize('submit_reports');
        

        // Delete associated photos from storage
        foreach ($divisionReport->photos as $photo) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $photo->photo_path));
            $photo->delete();
        }

        $divisionReport->delete();

        return redirect()->route('admin.division-reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}

