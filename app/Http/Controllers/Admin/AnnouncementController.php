<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_announcements');
        $announcements = Announcement::with('creator')->orderBy('created_at', 'desc')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        $this->authorize('manage_announcements');
        return view('admin.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        $announcement = Announcement::create($data);

        if ($announcement->is_active) {
            if ($announcement->target === 'public') {
                // Kirim notifikasi ke semua user dengan role Humas
                $humasUsers = \App\Models\User::role('Humas')->get();
                if ($humasUsers->isNotEmpty()) {
                    \Illuminate\Support\Facades\Notification::send($humasUsers, new \App\Notifications\SystemNotification(
                        'Pengumuman Publik Baru',
                        $announcement->title,
                        'info',
                        route('admin.announcements.index')
                    ));
                }
            } elseif ($announcement->target === 'pengurus') {
                // Kirim notifikasi ke semua user pengurus
                $allUsers = \App\Models\User::all();
                \Illuminate\Support\Facades\Notification::send($allUsers, new \App\Notifications\SystemNotification(
                    'Pengumuman Pengurus Baru',
                    $announcement->title,
                    'info',
                    route('admin.announcements.index')
                ));
            }
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement): View
    {
        $this->authorize('manage_announcements');
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');
        
        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->authorize('manage_announcements');
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
