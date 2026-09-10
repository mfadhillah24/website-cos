<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingMinute;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MeetingMinuteController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_minutes');

        $query = MeetingMinute::with('meeting')->latest();

        if ($search = $request->search) {
            $query->whereHas('meeting', fn($q) => $q->where('title', 'like', "%{$search}%"));
        }

        $minutes = $query->paginate(15)->withQueryString();

        return view('admin.minutes.index', compact('minutes'));
    }

    public function create(Request $request)
    {
        $this->authorize('manage_minutes');

        $meetingId = $request->meeting_id;
        $meeting   = $meetingId ? Meeting::findOrFail($meetingId) : null;
        $meetings  = Meeting::whereDoesntHave('minute')->latest('meeting_date')->get();

        return view('admin.minutes.create', compact('meeting', 'meetings'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage_minutes');

        $validated = $request->validate([
            'meeting_id'          => 'required|exists:meetings,id|unique:meeting_minutes,meeting_id',
            'leader'              => 'nullable|string|max:255',
            'notulist'            => 'nullable|string|max:255',
            'discussion_results'  => 'required|string',
            'decisions'           => 'nullable|string',
            'follow_up'           => 'nullable|string',
            'follow_up_deadline'  => 'nullable|date',
            'attachment'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('minutes', 'public');
        }

        unset($validated['attachment']);
        $minute = MeetingMinute::create($validated);

        return redirect()->route('admin.minutes.show', $minute)
            ->with('success', 'Notulen berhasil disimpan.');
    }

    public function show(MeetingMinute $minute)
    {
        $this->authorize('manage_minutes');
        $minute->load('meeting', 'creator');
        return view('admin.minutes.show', compact('minute'));
    }

    public function edit(MeetingMinute $minute)
    {
        $this->authorize('manage_minutes');

        // Include meetings that either have no minute yet, OR belong to this very minute (so current selection is preserved)
        $meetings = Meeting::where(function ($q) use ($minute) {
            $q->whereDoesntHave('minute')
              ->orWhereHas('minute', fn($q2) => $q2->where('id', $minute->id));
        })->latest('meeting_date')->get();

        return view('admin.minutes.edit', compact('minute', 'meetings'));
    }

    public function update(Request $request, MeetingMinute $minute)
    {
        $this->authorize('manage_minutes');

        $validated = $request->validate([
            'leader'             => 'nullable|string|max:255',
            'notulist'           => 'nullable|string|max:255',
            'discussion_results' => 'required|string',
            'decisions'          => 'nullable|string',
            'follow_up'          => 'nullable|string',
            'follow_up_deadline' => 'nullable|date',
            'attachment'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('attachment')) {
            if ($minute->attachment_path) {
                Storage::disk('public')->delete($minute->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('minutes', 'public');
        }

        unset($validated['attachment']);
        $minute->update($validated);

        return redirect()->route('admin.minutes.show', $minute)
            ->with('success', 'Notulen berhasil diperbarui.');
    }

    public function destroy(MeetingMinute $minute)
    {
        $this->authorize('manage_minutes');

        if ($minute->attachment_path) {
            Storage::disk('public')->delete($minute->attachment_path);
        }
        $minute->delete();

        return redirect()->route('admin.minutes.index')
            ->with('success', 'Notulen berhasil dihapus.');
    }

    public function downloadPdf(MeetingMinute $minute)
    {
        $this->authorize('manage_minutes');

        $minute->load('meeting', 'creator');
        $meeting = $minute->meeting;

        // Format tanggal Indonesia
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tgl = $meeting?->meeting_date;
        $tanggalFmt = $tgl
            ? $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year
            : '—';

        // Format waktu 24 jam WITA
        $waktuFmt = '—';
        if ($meeting?->start_time && $meeting?->end_time) {
            $waktuFmt = \Carbon\Carbon::parse($meeting->start_time)->format('H:i')
                      . ' – '
                      . \Carbon\Carbon::parse($meeting->end_time)->format('H:i')
                      . ' WITA';
        } elseif ($meeting?->start_time) {
            $waktuFmt = \Carbon\Carbon::parse($meeting->start_time)->format('H:i') . ' WITA';
        }

        // Nama file dinamis berdasarkan topik
        $slug     = Str::slug($meeting?->title ?? 'notulen-rapat');
        $filename = 'notulen-rapat-' . $slug . '.pdf';

        $data = [
            'minute'     => $minute,
            'meeting'    => $meeting,
            'tanggalFmt' => $tanggalFmt,
            'waktuFmt'   => $waktuFmt,
            'logoPath'   => public_path('images/logo.png'),
        ];

        $pdf = Pdf::loadView('pdf.meeting_minute', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'    => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        return $pdf->download($filename);
    }
}