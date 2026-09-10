<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_agendas');

        $query = Agenda::latest('agenda_date');

        if ($search = $request->search) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($from = $request->date_from) { $query->where('agenda_date', '>=', $from); }
        if ($to = $request->date_to) { $query->where('agenda_date', '<=', $to); }
        if ($type = $request->type) { $query->where('type', $type); }

        $agendas = $query->paginate(15)->withQueryString();
        $upcomingCount = Agenda::where('agenda_date', '>=', now()->toDateString())->count();

        return view('admin.agendas.index', compact('agendas', 'upcomingCount'));
    }

    public function create()
    {
        $this->authorize('manage_agendas');
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage_agendas');

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'agenda_date' => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:agenda_date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
            'pic'         => 'nullable|string|max:255',
            'participants'=> 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:terjadwal,berlangsung,selesai,dibatalkan',
        ]);

        // Jika multi-hari, hapus waktu (tidak relevan)
        $isMultiDay = !empty($validated['end_date']) && $validated['end_date'] !== $validated['agenda_date'];
        if ($isMultiDay) {
            $validated['start_time'] = null;
            $validated['end_time']   = null;
        }

        $validated['created_by'] = Auth::id();
        $validated['status']     = $validated['status'] ?? 'terjadwal';

        $agenda = Agenda::create($validated);

        return redirect()->route('admin.agendas.show', $agenda)
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function show(Agenda $agenda)
    {
        $this->authorize('manage_agendas');
        return view('admin.agendas.show', compact('agenda'));
    }

    public function edit(Agenda $agenda)
    {
        $this->authorize('manage_agendas');
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $this->authorize('manage_agendas');

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'agenda_date' => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:agenda_date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
            'pic'         => 'nullable|string|max:255',
            'participants'=> 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'required|in:terjadwal,berlangsung,selesai,dibatalkan',
        ]);

        // Jika multi-hari, hapus waktu
        $isMultiDay = !empty($validated['end_date']) && $validated['end_date'] !== $validated['agenda_date'];
        if ($isMultiDay) {
            $validated['start_time'] = null;
            $validated['end_time']   = null;
        }

        $agenda->update($validated);

        return redirect()->route('admin.agendas.show', $agenda)
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $this->authorize('manage_agendas');
        $agenda->delete();

        return redirect()->route('admin.agendas.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}