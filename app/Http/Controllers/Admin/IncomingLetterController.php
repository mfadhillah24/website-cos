<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class IncomingLetterController extends Controller
{
    /** Daftar semua surat masuk (termasuk yang diarsipkan) */
    public function index(Request $request)
    {
        $this->authorize('manage_incoming_letters');

        $query = Letter::where('type', 'incoming')->latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        if ($status = $request->status) { $query->where('status', $status); }
        if ($priority = $request->priority) { $query->where('priority', $priority); }
        if ($from = $request->date_from) { $query->where('received_date', '>=', $from); }
        if ($to = $request->date_to) { $query->where('received_date', '<=', $to); }

        $letters = $query->paginate(15)->withQueryString();

        return view('admin.letters.incoming.index', compact('letters'));
    }

    /** Halaman Arsip Surat Masuk — hanya tampilkan yang berstatus 'diarsipkan' */
    public function archiveList(Request $request)
    {
        $this->authorize('manage_incoming_letters');

        $query = Letter::where('type', 'incoming')
                       ->where('status', 'diarsipkan')
                       ->latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        if ($year = $request->year) {
            $query->whereYear('received_date', $year);
        }
        if ($type = $request->letter_type) {
            $query->where('letter_type', $type);
        }

        $letters    = $query->paginate(15)->withQueryString();
        $years      = Letter::where('type', 'incoming')
                            ->where('status', 'diarsipkan')
                            ->selectRaw("strftime('%Y', received_date) as year")
                            ->distinct()
                            ->orderByDesc('year')
                            ->pluck('year');
        $letterTypes = Letter::where('type', 'incoming')
                             ->where('status', 'diarsipkan')
                             ->whereNotNull('letter_type')
                             ->distinct()
                             ->pluck('letter_type');

        return view('admin.letters.incoming.archive_list', compact('letters', 'years', 'letterTypes'));
    }

    /** Arsipkan surat masuk — ubah status menjadi 'diarsipkan', simpan status lama */
    public function archive(Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');

        // Simpan status saat ini sebelum diarsipkan
        $incoming_letter->update([
            'previous_status' => $incoming_letter->status,
            'status'          => 'diarsipkan',
        ]);

        return redirect()->back()
            ->with('success', "Surat \"{$incoming_letter->subject}\" berhasil diarsipkan.");
    }

    /** Kembalikan surat dari arsip ke status sebelumnya */
    public function unarchive(Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');

        $restoreStatus = $incoming_letter->previous_status ?? 'baru';

        $incoming_letter->update([
            'status'          => $restoreStatus,
            'previous_status' => null,
        ]);

        return redirect()->back()
            ->with('success', "Surat \"{$incoming_letter->subject}\" berhasil dikembalikan dari arsip.");
    }

    public function create()
    {
        $this->authorize('manage_incoming_letters');
        return view('admin.letters.incoming.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage_incoming_letters');

        $validated = $request->validate([
            'letter_number' => 'required|string|max:100',
            'letter_date'   => 'required|date',
            'received_date' => 'required|date',
            'sender'        => 'required|string|max:200',
            'agenda_number' => 'nullable|string|max:100',
            'subject'       => 'required|string|max:255',
            'letter_type'   => 'nullable|string|max:100',
            'priority'      => 'nullable|in:Biasa,Penting,Segera,Rahasia',
            'destination'   => 'nullable|string|max:200',
            'summary'       => 'nullable|string',
            'notes'         => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $validated['type']       = 'incoming';
        $validated['status']     = 'baru';
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('letters/incoming', 'public');
        }

        $letter = Letter::create($validated);

        NotificationService::sendToRole(
            'Sekretaris',
            'Surat Masuk Baru',
            "Terdapat surat masuk baru: {$letter->subject} dari {$letter->sender}.",
            'incoming_letter',
            route('admin.letters.incoming.show', $letter->id)
        );

        NotificationService::sendToRole(
            'Ketua Umum',
            'Surat Masuk Baru',
            "Terdapat surat masuk baru: {$letter->subject} dari {$letter->sender}.",
            'incoming_letter',
            route('admin.letters.incoming.show', $letter->id)
        );

        return redirect()->route('admin.letters.incoming.show', $letter)
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');
        $letter       = $incoming_letter;
        $dispositions = $letter->dispositions()->with('assignedTo')->latest()->get();
        return view('admin.letters.incoming.show', compact('letter', 'dispositions'));
    }

    public function edit(Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');
        $letter = $incoming_letter;
        return view('admin.letters.incoming.edit', compact('letter'));
    }

    public function update(Request $request, Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');

        $validated = $request->validate([
            'letter_number' => 'required|string|max:100',
            'letter_date'   => 'required|date',
            'received_date' => 'required|date',
            'sender'        => 'required|string|max:200',
            'agenda_number' => 'nullable|string|max:100',
            'subject'       => 'required|string|max:255',
            'letter_type'   => 'nullable|string|max:100',
            'priority'      => 'nullable|in:Biasa,Penting,Segera,Rahasia',
            'destination'   => 'nullable|string|max:200',
            'summary'       => 'nullable|string',
            'status'        => 'required|in:baru,diproses,didisposisikan,selesai,diarsipkan',
            'notes'         => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($incoming_letter->file_path) {
                Storage::disk('public')->delete($incoming_letter->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('letters/incoming', 'public');
        }

        $incoming_letter->update($validated);

        return redirect()->route('admin.letters.incoming.show', $incoming_letter)
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /** Hapus surat masuk (Soft Delete — tidak permanen) */
    public function destroy(Letter $incoming_letter)
    {
        $this->authorize('manage_incoming_letters');

        // Soft Delete: data tidak dihapus secara fisik dari database
        $incoming_letter->delete();

        return redirect()->route('admin.letters.incoming.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}
