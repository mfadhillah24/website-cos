<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $divisionId = $request->attributes->get('scoped_division_id');
        
        $achievements = Achievement::when($divisionId, function ($query) use ($divisionId) {
                return $query->where('division_id', $divisionId);
            })
            ->orderByDesc('year')
            ->get();

        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $divisionId = $request->attributes->get('scoped_division_id');
        if (!$divisionId) {
            abort(403, 'Anda tidak memiliki akses divisi.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'event_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['division_id'] = $divisionId;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/achievements'), $filename);
            $validated['photo'] = 'achievements/' . $filename;
        }

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Pencapaian berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement, Request $request)
    {
        $divisionId = $request->attributes->get('scoped_division_id');
        if ($divisionId && $achievement->division_id != $divisionId) {
            abort(403);
        }

        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $divisionId = $request->attributes->get('scoped_division_id');
        if ($divisionId && $achievement->division_id != $divisionId) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'event_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($achievement->photo) {
                \Illuminate\Support\Facades\File::delete(public_path('images/' . $achievement->photo));
            }
            $file = $request->file('photo');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/achievements'), $filename);
            $validated['photo'] = 'achievements/' . $filename;
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Pencapaian berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement, Request $request)
    {
        $divisionId = $request->attributes->get('scoped_division_id');
        if ($divisionId && $achievement->division_id != $divisionId) {
            abort(403);
        }

        if ($achievement->photo) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $achievement->photo));
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Pencapaian berhasil dihapus.');
    }
}
