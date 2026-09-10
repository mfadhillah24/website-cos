<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\Rab;
use App\Models\RabItem;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RabController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_rab');

        $query = Rab::with(['period', 'creator'])->latest('date');

        if ($search = $request->search) {
            $query->where('activity_name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%");
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $rabs = $query->paginate(15)->withQueryString();

        return view('admin.rabs.index', compact('rabs'));
    }

    public function create()
    {
        $this->authorize('manage_rab');
        $periods = Period::orderBy('start_year', 'desc')->get();
        return view('admin.rabs.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage_rab');

        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'period_id'     => 'required|exists:periods,id',
            'date'          => 'required|date',
            'pic_name'      => 'required|string|max:255',
            'pic_position'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            
            // Items validation
            'items'              => 'required|array|min:1',
            'items.*.description'=> 'required|string|max:255',
            'items.*.quantity'   => 'required|numeric|min:1',
            'items.*.unit'       => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Create RAB
        $rab = Rab::create([
            'code'          => 'RAB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
            'activity_name' => $validated['activity_name'],
            'period_id'     => $validated['period_id'],
            'date'          => $validated['date'],
            'pic_name'      => $validated['pic_name'],
            'pic_position'  => $validated['pic_position'],
            'description'   => $validated['description'] ?? null,
            'status'        => 'draft',
            'created_by'    => Auth::id(),
        ]);

        // Create Items
        foreach ($validated['items'] as $item) {
            RabItem::create([
                'rab_id'      => $rab->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit'        => $item['unit'],
                'unit_price'  => $item['unit_price'],
                'subtotal'    => $item['quantity'] * $item['unit_price'],
            ]);
        }

        NotificationService::sendToRole(
            ['Ketua Umum', 'Sekretaris'],
            'RAB Baru Dibuat',
            "RAB untuk kegiatan '{$rab->activity_name}' telah dibuat oleh Bendahara.",
            'rab_created',
            route('admin.rabs.show', $rab->id)
        );

        return redirect()->route('admin.rabs.show', $rab)->with('success', 'RAB berhasil dibuat.');
    }

    public function show(Rab $rab)
    {
        $this->authorize('view_rab');
        $rab->load(['period', 'items', 'creator']);
        return view('admin.rabs.show', compact('rab'));
    }

    public function edit(Rab $rab)
    {
        $this->authorize('manage_rab');
        
        $rab->load('items');
        $periods = Period::orderBy('start_year', 'desc')->get();
        return view('admin.rabs.edit', compact('rab', 'periods'));
    }

    public function update(Request $request, Rab $rab)
    {
        $this->authorize('manage_rab');

        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'period_id'     => 'required|exists:periods,id',
            'date'          => 'required|date',
            'pic_name'      => 'required|string|max:255',
            'pic_position'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            
            // Items validation
            'items'              => 'required|array|min:1',
            'items.*.description'=> 'required|string|max:255',
            'items.*.quantity'   => 'required|numeric|min:1',
            'items.*.unit'       => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $rab->update([
            'activity_name' => $validated['activity_name'],
            'period_id'     => $validated['period_id'],
            'date'          => $validated['date'],
            'pic_name'      => $validated['pic_name'],
            'pic_position'  => $validated['pic_position'],
            'description'   => $validated['description'] ?? null,
        ]);

        // Sync items by deleting old and creating new
        $rab->items()->delete();
        foreach ($validated['items'] as $item) {
            RabItem::create([
                'rab_id'      => $rab->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit'        => $item['unit'],
                'unit_price'  => $item['unit_price'],
                'subtotal'    => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('admin.rabs.show', $rab)->with('success', 'RAB berhasil diperbarui.');
    }

    public function finalize(Rab $rab)
    {
        $this->authorize('manage_rab');
        if ($rab->status === 'final') {
            return redirect()->route('admin.rabs.show', $rab)->with('error', 'RAB sudah final.');
        }

        $rab->update(['status' => 'final']);

        NotificationService::sendToRole(
            ['Ketua Umum', 'Sekretaris'],
            'RAB Difinalisasi',
            "RAB untuk kegiatan '{$rab->activity_name}' telah difinalisasi.",
            'rab_finalized',
            route('admin.rabs.show', $rab->id)
        );

        return redirect()->route('admin.rabs.show', $rab)->with('success', 'RAB berhasil difinalisasi.');
    }

    public function destroy(Rab $rab)
    {
        $this->authorize('manage_rab');

        $rab->delete();
        return redirect()->route('admin.rabs.index')->with('success', 'RAB berhasil dihapus.');
    }

    public function exportPdf(Rab $rab)
    {
        $this->authorize('view_rab');
        $rab->load(['period', 'items', 'creator']);

        $pdf = Pdf::loadView('admin.rabs.pdf', compact('rab'));
        return $pdf->download('RAB_' . str_replace(' ', '_', $rab->activity_name) . '.pdf');
    }
}
