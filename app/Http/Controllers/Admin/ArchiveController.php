<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Period;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArchiveController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Archive::class);

        $query = Archive::with(['uploader', 'period', 'activity'])->latest();

        // Role based filtering
        $user = Auth::user();
        if (!$user->hasRole(['Super Admin', 'Ketua Umum']) && !$user->hasPermissionTo('manage_archives')) {
            $query->whereIn('visibility', ['public', 'internal']);
        }

        // Trashed filter
        if ($request->has('trashed') && $user->hasPermissionTo('manage_archives')) {
            $query->onlyTrashed();
        }

        if ($search = $request->search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
        }
        if ($cat = $request->category) { $query->where('category', $cat); }
        if ($year = $request->year) { $query->whereYear('document_date', $year); }
        if ($periodId = $request->period_id) { $query->where('period_id', $periodId); }
        if ($status = $request->status) { $query->where('status', $status); }

        $archives  = $query->paginate(15)->withQueryString();
        
        // Base query for filters to not be affected by current search
        $baseQuery = Archive::query();
        if (!$user->hasRole(['Super Admin', 'Ketua Umum']) && !$user->hasPermissionTo('manage_archives')) {
            $baseQuery->whereIn('visibility', ['public', 'internal']);
        }
        
        $categories = (clone $baseQuery)->distinct()->pluck('category')->filter()->sort()->values();
        $years      = (clone $baseQuery)->selectRaw('strftime("%Y", document_date) as y')->distinct()->pluck('y')->filter()->sortDesc()->values();
        $periods    = Period::orderByDesc('start_date')->get();

        return view('admin.archives.index', compact('archives', 'categories', 'years', 'periods'));
    }

    public function create()
    {
        $this->authorize('create', Archive::class);
        $periods = Period::orderByDesc('start_date')->get();
        $activities = Activity::orderByDesc('start_date')->get();
        $activePeriod = Period::where('is_active', true)->first();

        return view('admin.archives.create', compact('periods', 'activities', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Archive::class);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'document_number' => 'nullable|string|max:100',
            'document_date'   => 'nullable|date',
            'description'     => 'nullable|string',
            'period_id'       => 'nullable|exists:periods,id',
            'activity_id'     => 'nullable|exists:activities,id',
            'visibility'      => 'required|in:public,internal,restricted',
            'file'            => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        $validated['file_path']   = $request->file('file')->store('archives', 'local');
        $validated['status']      = 'active';
        $validated['uploaded_by'] = Auth::id();

        unset($validated['file']);
        Archive::create($validated);

        return redirect()->route('admin.archives.index')
            ->with('success', 'Arsip berhasil diunggah.');
    }

    public function show($id)
    {
        $archive = Archive::withTrashed()->findOrFail($id);
        $this->authorize('view', $archive);
        return view('admin.archives.show', compact('archive'));
    }

    public function edit(Archive $archive)
    {
        $this->authorize('update', $archive);
        $periods = Period::orderByDesc('start_date')->get();
        $activities = Activity::orderByDesc('start_date')->get();
        return view('admin.archives.edit', compact('archive', 'periods', 'activities'));
    }

    public function update(Request $request, Archive $archive)
    {
        $this->authorize('update', $archive);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'document_number' => 'nullable|string|max:100',
            'document_date'   => 'nullable|date',
            'description'     => 'nullable|string',
            'period_id'       => 'nullable|exists:periods,id',
            'activity_id'     => 'nullable|exists:activities,id',
            'visibility'      => 'required|in:public,internal,restricted',
            'status'          => 'required|in:active,archived',
            'file'            => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if (Storage::disk('local')->exists($archive->file_path)) {
                Storage::disk('local')->delete($archive->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('archives', 'local');
        }

        unset($validated['file']);
        $archive->update($validated);

        return redirect()->route('admin.archives.show', $archive)
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function download($id)
    {
        $archive = Archive::withTrashed()->findOrFail($id);
        $this->authorize('view', $archive);

        if (!Storage::disk('local')->exists($archive->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $extension = pathinfo($archive->file_path, PATHINFO_EXTENSION);
        $downloadName = \Str::slug($archive->name) . '.' . $extension;

        return Storage::disk('local')->download($archive->file_path, $downloadName);
    }

    public function destroy(Archive $archive)
    {
        $this->authorize('delete', $archive);
        $archive->delete(); // Soft delete

        return redirect()->route('admin.archives.index')
            ->with('success', 'Arsip berhasil dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $archive = Archive::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $archive);
        $archive->restore();

        return redirect()->route('admin.archives.index', ['trashed' => 1])
            ->with('success', 'Arsip berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $archive = Archive::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $archive);

        if (Storage::disk('local')->exists($archive->file_path)) {
            Storage::disk('local')->delete($archive->file_path);
        }
        $archive->forceDelete();

        return redirect()->route('admin.archives.index', ['trashed' => 1])
            ->with('success', 'Arsip berhasil dihapus permanen.');
    }
}