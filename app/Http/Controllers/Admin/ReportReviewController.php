<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisionReport;
use App\Models\ReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\NotificationService;

class ReportReviewController extends Controller
{
    /**
     * Daftar laporan yang perlu/sudah di-review (untuk Ketua)
     */
    public function index(): View
    {
        $this->authorize('review_reports');
        $reports = DivisionReport::with(['division', 'period', 'author'])
            ->whereIn('status', ['submitted', 'reviewing', 'revision', 'approved'])
            ->orderBy('submitted_at', 'desc')
            ->get();
        return view('admin.report_reviews.index', compact('reports'));
    }

    /**
     * Halaman detail laporan untuk reviewer
     */
    public function show(DivisionReport $divisionReport): View
    {
        $this->authorize('review_reports');
        $divisionReport->load(['division', 'period', 'author', 'reviews.reviewer', 'photos']);

        // Set to reviewing if it was submitted
        if ($divisionReport->status === 'submitted') {
            $divisionReport->update(['status' => 'reviewing']);
        }

        return view('admin.report_reviews.show', compact('divisionReport'));
    }

    /**
     * Submit review decision (approve or revision needed)
     */
    public function store(Request $request, DivisionReport $divisionReport)
    {
        $this->authorize('review_reports');

        $data = $request->validate([
            'action' => ['required', 'in:approved,revision'],
            'notes'  => ['required', 'string'],
        ]);

        ReportReview::create([
            'report_id'   => $divisionReport->id,
            'reviewer_id' => Auth::id(),
            'notes'       => $data['notes'],
            'action'      => $data['action'],
        ]);

        $newStatus = $data['action'] === 'approved' ? 'approved' : 'revision';
        $divisionReport->update([
            'status'      => $newStatus,
            'approved_at' => $data['action'] === 'approved' ? now() : null,
        ]);

        $notifTitle = $data['action'] === 'approved' ? 'Laporan Disetujui' : 'Laporan Perlu Revisi';
        $notifMessage = $data['action'] === 'approved' 
            ? "Laporan '{$divisionReport->title}' telah disetujui oleh Ketua Umum."
            : "Laporan '{$divisionReport->title}' membutuhkan revisi.";
        $notifType = $data['action'] === 'approved' ? 'report_approved' : 'report_revision';

        NotificationService::sendToUser(
            $divisionReport->author,
            $notifTitle,
            $notifMessage,
            $notifType,
            route('admin.division-reports.show', $divisionReport->id)
        );

        $msg = $data['action'] === 'approved' ? 'Laporan berhasil disetujui.' : 'Laporan dikembalikan untuk direvisi.';
        return redirect()->route('admin.report-reviews.index')->with('success', $msg);
    }
}
