<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $query = auth()->user()->notifications();
        
        if (request('filter') === 'unread') {
            $query->whereNull('read_at');
        }
        
        $notifications = $query->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function fetchLatest()
    {
        $notifications = auth()->user()->notifications()->take(5)->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();
        
        return response()->json([
            'notifications' => $notifications->map(function($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->data['title'] ?? '',
                    'message' => $notif->data['message'] ?? '',
                    'action_url' => $notif->data['action_url'] ?? null,
                    'read_at' => $notif->read_at,
                    'created_at_diff' => $notif->created_at->diffForHumans(),
                ];
            }),
            'unreadCount' => $unreadCount
        ]);
    }

    public function markAsRead($id)
    {
        // Using auth()->user()->notifications() ensures we only query this user's notifications
        $notification = auth()->user()->notifications()->findOrFail($id);

        $notification->markAsRead();
        
        if ($notification->data['action_url'] ?? false) {
            return redirect($notification->data['action_url']);
        }
        
        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function destroyAll()
    {
        auth()->user()->notifications()->delete();
        
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
