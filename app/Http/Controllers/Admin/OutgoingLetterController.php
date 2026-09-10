<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OutgoingLetterController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_outgoing_letters');

        $query = Letter::where('type', 'outgoing')->latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('receiver', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        if ($status = $request->status) { $query->where('status', $status); }
        if ($from = $request->date_from) { $query->where('letter_date', '>=', $from); }
        if ($to = $request->date_to) { $query->where('letter_date', '<=', $to); }

        $letters = $query->paginate(15)->withQueryString();

        return view('admin.letters.outgoing.index', compact('letters'));
    }

    public function create()
    {
        $this->authorize('manage_outgoing_letters');

        $letterNumber = $this->generateLetterNumber();

        return view('admin.letters.outgoing.create', compact('letterNumber'));
    }

    protected function generateLetterNumber(): string
    {
        $count = Letter::where('type', 'outgoing')->whereYear('created_at', now()->year)->count() + 1;
        $month = now()->month;
        $romans = ['','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $roman  = $romans[$month];
        $year   = now()->year;
        return str_pad($count, 3, '0', STR_PAD_LEFT) . '/UKM-IT-COS/' . $roman . '/' . $year;
    }

    public function store(Request $request)
    {
        $this->authorize('manage_outgoing_letters');

        $validated = $request->validate([
            'letter_number'   => 'required|string|max:100',
            'letter_date'     => 'required|date',
            'receiver'        => 'required|string|max:255',
            'subject'         => 'required|string|max:255',
            'letter_type'     => 'nullable|string|max:100',
            'signer'          => 'nullable|string|max:200',
            'signer_position' => 'nullable|string|max:200',
            'summary'         => 'nullable|string',
            'status'          => 'nullable|in:draft,menunggu_persetujuan,disetujui,dikirim,diarsipkan',
            'notes'           => 'nullable|string',
            'file'            => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['type']       = 'outgoing';
        $validated['created_by'] = Auth::id();
        $validated['status']     = $validated['status'] ?? 'draft';

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('letters/outgoing', 'public');
        }

        $letter = Letter::create($validated);

        return redirect()->route('admin.letters.outgoing.show', $letter)
            ->with('success', 'Surat keluar berhasil dibuat.');
    }

    public function show(Letter $outgoing_letter)
    {
        $this->authorize('manage_outgoing_letters');
        $letter = $outgoing_letter;
        return view('admin.letters.outgoing.show', compact('letter'));
    }

    public function edit(Letter $outgoing_letter)
    {
        $this->authorize('manage_outgoing_letters');
        $letter = $outgoing_letter;
        return view('admin.letters.outgoing.edit', compact('letter'));
    }

    public function update(Request $request, Letter $outgoing_letter)
    {
        $this->authorize('manage_outgoing_letters');

        $validated = $request->validate([
            'letter_number'   => 'required|string|max:100',
            'letter_date'     => 'required|date',
            'receiver'        => 'required|string|max:255',
            'subject'         => 'required|string|max:255',
            'letter_type'     => 'nullable|string|max:100',
            'signer'          => 'nullable|string|max:200',
            'signer_position' => 'nullable|string|max:200',
            'summary'         => 'nullable|string',
            'status'          => 'required|in:draft,menunggu_persetujuan,disetujui,dikirim,diarsipkan',
            'notes'           => 'nullable|string',
            'file'            => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($outgoing_letter->file_path) {
                Storage::disk('public')->delete($outgoing_letter->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('letters/outgoing', 'public');
        }

        $outgoing_letter->update($validated);

        return redirect()->route('admin.letters.outgoing.show', $outgoing_letter)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(Letter $outgoing_letter)
    {
        $this->authorize('manage_outgoing_letters');

        if ($outgoing_letter->file_path) {
            Storage::disk('public')->delete($outgoing_letter->file_path);
        }
        $outgoing_letter->delete();

        return redirect()->route('admin.letters.outgoing.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}