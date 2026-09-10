<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_meetings');

        $query = Meeting::with('minute')->latest('meeting_date');

        if ($search = $request->search) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($from = $request->date_from) { $query->where('meeting_date', '>=', $from); }

        $meetings = $query->paginate(15)->withQueryString();

        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $this->authorize('manage_meetings');
        return view('admin.meetings.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage_meetings');

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'meeting_date'     => 'required|date',
            'start_time'       => 'nullable|date_format:H:i',
            'end_time'         => 'nullable|date_format:H:i|after:start_time',
            'location'         => 'nullable|string|max:255',
            'agenda'           => 'nullable|string',
            'attendance_count' => 'nullable|integer|min:0|max:10000',
        ], [
            'end_time.after' => 'Waktu selesai harus lebih lambat dari waktu mulai.',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status']     = 'terjadwal';

        $meeting = Meeting::create($validated);

        NotificationService::sendToRole(
            ['Ketua Umum', 'Sekretaris'],
            'Rapat Baru Dijadwalkan',
            "Rapat '{$meeting->title}' dijadwalkan pada {$meeting->meeting_date}.",
            'meeting_created',
            route('admin.meetings.show', $meeting->id)
        );

        return redirect()->route('admin.meetings.show', $meeting)
            ->with('success', 'Rapat berhasil dijadwalkan.');
    }

    public function show(Meeting $meeting)
    {
        $this->authorize('manage_meetings');
        $meeting->load('minute', 'creator');
        return view('admin.meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $this->authorize('manage_meetings');
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('manage_meetings');

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'meeting_date'     => 'required|date',
            'start_time'       => 'nullable|date_format:H:i',
            'end_time'         => 'nullable|date_format:H:i|after:start_time',
            'location'         => 'nullable|string|max:255',
            'agenda'           => 'nullable|string',
            'attendance_count' => 'nullable|integer|min:0|max:10000',
        ], [
            'end_time.after' => 'Waktu selesai harus lebih lambat dari waktu mulai.',
        ]);

        $meeting->update($validated);

        return redirect()->route('admin.meetings.show', $meeting)
            ->with('success', 'Rapat berhasil diperbarui.');
    }

    public function destroy(Meeting $meeting)
    {
        $this->authorize('manage_meetings');
        $meeting->delete();

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Rapat berhasil dihapus.');
    }
}