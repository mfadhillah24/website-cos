<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class DispositionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_dispositions');

        $query = Disposition::with(['letter', 'assignedTo'])->latest();

        if ($status = $request->status) { $query->where('status', $status); }

        $dispositions = $query->paginate(15)->withQueryString();

        return view('admin.dispositions.index', compact('dispositions'));
    }

    public function create(Request $request)
    {
        $this->authorize('manage_dispositions');

        $letterId = $request->letter_id;
        $letter   = $letterId ? Letter::find($letterId) : null;
        $users    = User::where('is_active', true)->orderBy('name')->get();
        $letters  = Letter::where('type', 'incoming')->whereIn('status', ['baru','diproses'])->latest()->get();

        return view('admin.dispositions.create', compact('letter', 'users', 'letters'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage_dispositions');

        $validated = $request->validate([
            'letter_id'        => 'required|exists:letters,id',
            'user_id'          => 'required|exists:users,id',
            'instruction'      => 'required|string',
            'notes'            => 'nullable|string',
            'disposition_date' => 'required|date',
            'deadline'         => 'nullable|date|after_or_equal:disposition_date',
        ]);

        $validated['status']     = 'menunggu';
        $validated['created_by'] = Auth::id();

        $disposition = Disposition::create($validated);

        // Update letter status
        Letter::find($validated['letter_id'])->update(['status' => 'didisposisikan']);

        $disposition->load(['letter', 'assignedTo']);
        NotificationService::sendToUser(
            $disposition->assignedTo,
            'Disposisi Baru',
            "Anda mendapatkan disposisi baru terkait surat: {$disposition->letter->subject}.",
            'disposition_created',
            route('admin.dispositions.show', $disposition->id)
        );

        return redirect()->route('admin.dispositions.show', $disposition)
            ->with('success', 'Disposisi berhasil dibuat.');
    }

    public function show(Disposition $disposition)
    {
        $this->authorize('manage_dispositions');
        $disposition->load(['letter', 'assignedTo', 'creator']);
        return view('admin.dispositions.show', compact('disposition'));
    }

    public function edit(Disposition $disposition)
    {
        $this->authorize('manage_dispositions');
        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.dispositions.edit', compact('disposition', 'users'));
    }

    public function update(Request $request, Disposition $disposition)
    {
        $this->authorize('manage_dispositions');

        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'instruction'      => 'required|string',
            'notes'            => 'nullable|string',
            'disposition_date' => 'required|date',
            'deadline'         => 'nullable|date',
            'status'           => 'required|in:menunggu,diproses,selesai',
        ]);

        $disposition->update($validated);

        return redirect()->route('admin.dispositions.show', $disposition)
            ->with('success', 'Disposisi berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Disposition $disposition)
    {
        $this->authorize('manage_dispositions');

        $validated = $request->validate(['status' => 'required|in:menunggu,diproses,selesai']);
        $disposition->update($validated);

        if ($validated['status'] === 'selesai') {
            $allDone = $disposition->letter->dispositions()->where('status', '!=', 'selesai')->doesntExist();
            if ($allDone) {
                $disposition->letter->update(['status' => 'selesai']);
            }
        }

        return back()->with('success', 'Status disposisi diperbarui.');
    }

    public function destroy(Disposition $disposition)
    {
        $this->authorize('manage_dispositions');
        $disposition->delete();

        return redirect()->route('admin.dispositions.index')
            ->with('success', 'Disposisi berhasil dihapus.');
    }
}