<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityPhoto;
use App\Models\Division;
use App\Models\Period;
use App\Models\Program;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view_activities');

        $scopedDivisionId = $request->attributes->get('scoped_division_id');

        $activities = Activity::with(['division', 'program'])
            ->when($scopedDivisionId, fn($q) => $q->where('division_id', $scopedDivisionId))
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.activities.index', compact('activities'));
    }

    public function create(Request $request): View
    {
        $this->authorize('manage_activities');

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        $divisions = Division::when($scopedDivisionId, fn($q) => $q->where('id', $scopedDivisionId))->get();
        $programs = Program::with('division')
            ->when($scopedDivisionId, fn($q) => $q->where('division_id', $scopedDivisionId))
            ->get();

        return view('admin.activities.create', compact('divisions', 'programs'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['slug'] = Str::slug($data['title']) . '-' . time();

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        if ($scopedDivisionId) {
            $data['division_id'] = $scopedDivisionId;
        }

        $activePeriod = Period::where('is_active', true)->first();
        if ($activePeriod) {
            $data['period_id'] = $activePeriod->id;
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/activities/thumbnails'), $filename);
                $data['thumbnail'] = 'activities/thumbnails/' . $filename;
            }

            $activity = Activity::create($data);

            // Handle multiple photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $i => $photo) {
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('images/activities/photos'), $filename);
                    $path = 'activities/photos/' . $filename;
                    ActivityPhoto::create([
                        'activity_id' => $activity->id,
                        'path'        => $path,
                        'order'       => $i,
                    ]);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan kegiatan: ' . $e->getMessage());
        }
    }

    public function show(Activity $activity): View
    {
        $this->authorize('view_activities');
        $activity->load(['division', 'program', 'creator', 'photos']);
        return view('admin.activities.show', compact('activity'));
    }

    public function edit(Activity $activity, Request $request): View
    {
        $this->authorize('manage_activities');

        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        if ($scopedDivisionId && $activity->division_id && $activity->division_id != $scopedDivisionId) {
            abort(403);
        }

        $divisions = Division::when($scopedDivisionId, fn($q) => $q->where('id', $scopedDivisionId))->get();
        $programs = Program::with('division')
            ->when($scopedDivisionId, fn($q) => $q->where('division_id', $scopedDivisionId))
            ->get();

        $activity->load('photos');
        return view('admin.activities.edit', compact('activity', 'divisions', 'programs'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $data = $request->validated();
        
        $scopedDivisionId = $request->attributes->get('scoped_division_id');
        if ($scopedDivisionId) {
            $data['division_id'] = $scopedDivisionId;
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                if ($activity->thumbnail) {
                    \Illuminate\Support\Facades\File::delete(public_path('images/' . $activity->thumbnail));
                }
                $file = $request->file('thumbnail');
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/activities/thumbnails'), $filename);
                $data['thumbnail'] = 'activities/thumbnails/' . $filename;
            }

            $activity->update($data);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $i => $photo) {
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('images/activities/photos'), $filename);
                    $path = 'activities/photos/' . $filename;
                    ActivityPhoto::create([
                        'activity_id' => $activity->id,
                        'path'        => $path,
                        'order'       => $activity->photos()->count() + $i,
                    ]);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil diperbarui.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui kegiatan: ' . $e->getMessage());
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $this->authorize('manage_activities');

        if ($activity->thumbnail) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $activity->thumbnail));
        }

        foreach ($activity->photos as $photo) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $photo->path));
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function destroyPhoto(ActivityPhoto $photo): RedirectResponse
    {
        $this->authorize('manage_activities');

        \Illuminate\Support\Facades\File::delete(public_path('images/' . $photo->path));
        $activityId = $photo->activity_id;
        $photo->delete();

        return redirect()->route('admin.activities.edit', $activityId)->with('success', 'Foto berhasil dihapus.');
    }
}
