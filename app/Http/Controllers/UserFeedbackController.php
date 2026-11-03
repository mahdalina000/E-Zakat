<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFeedbackController extends Controller
{
    /**
     * Tampilkan halaman kritik & saran (kirim + riwayat milik user).
     */
    public function index()
    {
        $u = Auth::user();
        $feedbacks = $u->feedbacks()->latest()->paginate(10);

        return view('dashboard.user-feedback', compact('feedbacks'));
    }

    /**
     * Simpan kritik / saran baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'in:saran,kritik,pertanyaan,lainnya'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data['user_id'] = Auth::id();
        $data['is_read'] = false;

        Feedback::create($data);

        return redirect()->route('user.feedback')
            ->with('success', 'Terima kasih! Kritik/saran Anda sudah terkirim.');
    }

    /**
     * Hapus satu catatan (hanya milik user sendiri).
     */
    public function destroy(Feedback $feedback)
    {
        abort_unless($feedback->user_id === Auth::id(), 403);
        $feedback->delete();

        return redirect()->route('user.feedback')
            ->with('success', 'Kritik/saran dihapus.');
    }
}
