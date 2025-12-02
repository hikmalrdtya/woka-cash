<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // 1. Menampilkan daftar notifikasi lengkap
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // 2. Tandai 1 notif sebagai read
    public function markAsRead($id)
    {
        $notif = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notif->update(['is_read' => true]);

        return back();
    }

    // 3. Tandai semua notif sebagai read
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return back();
    }

    // 4. Hapus 1 notif
    public function destroy($id)
    {
        Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return back();
    }

    // 5. Hapus semua notif
    public function destroyAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return back();
    }

    // 6. Fetch untuk navbar (JSON)
    public function fetch()
    {
        return response()->json([
            'unread_count' => Notification::where('user_id', Auth::id())->where('is_read', false)->count(),
            'notifications' => Notification::where('user_id', Auth::id())->latest()->take(10)->get()
        ]);
    }
}

