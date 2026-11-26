<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateLocale(Request $request)
    {
        $data = $request->validate([
            'locale' => ['required', 'in:id,en,ar,ms'],
        ]);

        $user = auth()->user();
        $user->preferred_locale = $data['locale'];
        $user->save();

        session(['locale' => $data['locale']]);
        app()->setLocale($data['locale']);

        return back()->with('success', __('Bahasa antarmuka diperbarui.'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $user = auth()->user();
        $user->name = $data['name'];
        $user->save();

        return back()->with('success', __('Profil diperbarui.'));
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[^A-Za-z0-9]/'],
        ]);

        auth()->user()->update(['password' => bcrypt($data['password'])]);

        return back()->with('success', __('Kata sandi berhasil diubah.'));
    }

    public function updateAvatar(Request $request)
    {
        $data = $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:8192'],
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        $file = $request->file('avatar');
        $name = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        \Illuminate\Support\Facades\File::ensureDirectoryExists(storage_path('app/public/avatars'));
        $file->storeAs('avatars', $name, 'public');

        $user->avatar = $name;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'url' => $user->avatarUrl(),
                'message' => __('Foto profil berhasil diperbarui.'),
            ]);
        }

        return back()->with('success', __('Foto profil berhasil diperbarui.'));
    }

    public function removeAvatar(Request $request)
    {
        $user = auth()->user();

        if ($user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('avatars/' . $user->avatar);
            $user->avatar = null;
            $user->save();
        }

        return back()->with('success', __('Foto profil dihapus.'));
    }

    public function updateNotifications(Request $request)
    {
        $data = $request->validate([
            'notif_waris' => ['nullable', 'boolean'],
            'notif_zakat' => ['nullable', 'boolean'],
            'notif_berita' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $cur = is_array($user->notification_prefs) ? $user->notification_prefs : [];
        $user->notification_prefs = [
            'waris' => (bool) ($data['notif_waris'] ?? ($cur['waris'] ?? true)),
            'zakat' => (bool) ($data['notif_zakat'] ?? ($cur['zakat'] ?? true)),
            'berita' => (bool) ($data['notif_berita'] ?? ($cur['berita'] ?? true)),
        ];
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => __('Preferensi notifikasi berhasil diperbarui.'),
            ]);
        }

        return back()->with('success', __('Preferensi notifikasi berhasil diperbarui.'));
    }
}

