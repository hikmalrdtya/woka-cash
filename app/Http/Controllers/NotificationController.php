<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    //menandai notif 
    public function markAsRead($id)
    {
        $notif = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notif->update(['is_read' => true]);

        return back();
    }

    //menandai semua notif
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return back();
    }

    public function destroy($id)
    {
        $notif = Notification::findOrFail($id);

        $deletedBy = $notif->deleted_by ? json_decode($notif->deleted_by, true) : [];

        // masukkan user id ke list
        if (!in_array(Auth::id(), $deletedBy)) {
            $deletedBy[] = Auth::id();
        }

        $notif->deleted_by = json_encode($deletedBy);
        $notif->save();

        return back();
    }


    public function destroyAll()
    {
        $userId = auth()->id();

        // Ambil semua notif yang BELUM dihapus user
        $notifs = Notification::where(function ($q) use ($userId) {
            $q->whereNull('deleted_by')
                ->orWhereRaw("JSON_CONTAINS(deleted_by, '\"$userId\"') = 0");
        })->get();

        foreach ($notifs as $notif) {
            $deletedBy = $notif->deleted_by ? json_decode($notif->deleted_by, true) : [];

            if (!in_array($userId, $deletedBy)) {
                $deletedBy[] = $userId;
            }

            $notif->deleted_by = json_encode($deletedBy);
            $notif->save();
        }

        return back();
    }

}

