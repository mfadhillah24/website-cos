<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use App\Models\Activity;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        // Semua user yang login bisa melihat galeri

        $scopedDivisionId = $request->attributes->get('scoped_division_id');

        $photos = GalleryPhoto::with(['activity', 'division', 'uploader'])
            ->when($scopedDivisionId, fn($q) => $q->where('division_id', $scopedDivisionId))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gallery.index', compact('photos'));
    }

    public function create(Request $request): View
    {
        // Semua user yang login bisa upload foto

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        $divisions = Division::when($scopedDivisionId, fn($q) => $q->where('id', $scopedDivisionId))->get();
        $activities = Activity::when($scopedDivisionId, fn($q) => $q->where('division_id', $scopedDivisionId))->orderBy('start_date', 'desc')->get();

        return view('admin.gallery.create', compact('divisions', 'activities'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Semua user yang login bisa menyimpan foto

        $request->validate([
            'photos.*'    => ['required', 'image', 'max:3072'],
            'activity_id' => ['nullable', 'exists:activities,id'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'caption'     => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/gallery'), $filename);
                $path = 'gallery/' . $filename;
                GalleryPhoto::create([
                    'activity_id'  => $request->activity_id,
                    'division_id'  => $request->division_id,
                    'path'         => $path,
                    'caption'      => $request->caption,
                    'is_published' => true,
                    'uploaded_by'  => Auth::id(),
                ]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diunggah ke galeri.');
    }

    public function destroy(GalleryPhoto $gallery): RedirectResponse
    {
        // Hanya pengunggah atau user dengan manage_gallery yang bisa hapus
        if (Auth::id() !== $gallery->uploaded_by) {
            $this->authorize('manage_gallery');
        }
        \Illuminate\Support\Facades\File::delete(public_path('images/' . $gallery->path));
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}
