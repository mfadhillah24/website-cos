<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage_positions');

        $positions = Position::orderBy('order')->orderBy('name')->get();

        return view('admin.positions.index', compact('positions'));
    }

    public function create(): View
    {
        $this->authorize('manage_positions');

        return view('admin.positions.create');
    }

    public function store(StorePositionRequest $request): RedirectResponse
    {
        $this->authorize('manage_positions');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug']);
        $data['order'] = $data['order'] ?? 0;

        Position::create($data);

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Position $position): View
    {
        $this->authorize('manage_positions');

        return view('admin.positions.edit', compact('position'));
    }

    public function update(UpdatePositionRequest $request, Position $position): RedirectResponse
    {
        $this->authorize('manage_positions');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug']);
        $data['order'] = $data['order'] ?? 0;

        $position->update($data);

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position): RedirectResponse
    {
        $this->authorize('manage_positions');

        $position->delete();

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
