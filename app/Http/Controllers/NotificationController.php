<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');

        $q = Notification::where('user_id', auth()->id())
            ->orderByDesc('created_at')->limit(50);

        if ($filter === 'unread') {
            $q->whereNull('read_at');
        } elseif ($filter === 'read') {
            $q->whereNotNull('read_at');
        }

        $notifications = $q->get();

        $unread = Notification::where('user_id', auth()->id())->unread()->count();

        return view('notifications.index', compact('notifications', 'unread', 'filter'));
    }

    public function readAll()
    {
        Notification::where('user_id', auth()->id())->unread()->update(['read_at' => now()]);

        return back()->with('success', __('Semua notifikasi ditandai sudah dibaca.'));
    }
}
