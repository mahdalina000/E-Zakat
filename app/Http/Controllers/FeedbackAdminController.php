<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackAdminController extends Controller
{
    /**
     * Panel masukan warga (dipakai admin & super admin).
     * Masukan belum dibaca tampil lebih dulu.
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')
            ->orderByRaw('is_read ASC, created_at DESC')
            ->paginate(15);

        $unread = Feedback::where('is_read', false)->count();

        return view('dashboard.admin-feedbacks', compact('feedbacks', 'unread'));
    }

    /**
     * Tandai satu masukan sebagai sudah dibaca.
     */
    public function markRead(Feedback $feedback)
    {
        $feedback->update(['is_read' => true]);

        return back()->with('success', 'Masukan ditandai sebagai sudah dibaca.');
    }

    /**
     * Hapus satu masukan (admin/super admin).
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return back()->with('success', 'Masukan dihapus.');
    }
}
