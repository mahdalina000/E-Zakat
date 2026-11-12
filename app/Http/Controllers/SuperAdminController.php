<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function users()
    {
        $q = request('q');
        $role = request('role');

        $users = User::query()
            ->when($q, fn ($x) => $x->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%")))
            ->when($role, fn ($x) => $x->where('role', $role))
            ->orderByRaw("FIELD(role, 'super_admin','admin_baznas','admin_upz','admin','user')")
            ->orderBy('name')
            ->paginate(50)
            ->withQueryString();

        $counts = [
            'all' => User::count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
            'admin_baznas' => User::where('role', 'admin_baznas')->count(),
            'admin_upz' => User::where('role', 'admin_upz')->count(),
            'user' => User::where('role', 'user')->count(),
        ];

        return view('dashboard.super-users', compact('users', 'counts', 'q', 'role'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin_upz,admin_baznas,super_admin'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $adminType = match ($data['role']) {
            'admin_baznas' => 'baznas',
            'admin_upz' => 'upz',
            default => null,
        };

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'admin_type' => $adminType,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Jika admin UPZ/BAZNAS & alamat diisi → otomatis masuk peta
        if (in_array($data['role'], ['admin_upz', 'admin_baznas'], true) && !empty($data['address'])) {
            \App\Models\Location::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'kelurahan' => 'Banjarbaru',
                'kecamatan' => '',
                'latitude' => -3.4420,
                'longitude' => 114.8310,
                'type' => $adminType,
                'phone' => null,
                'is_active' => true,
                'created_by' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Akun admin berhasil dibuat.');
    }

    public function locations()
    {
        $type = request('type');
        $locations = Location::with('creator')
            ->when($type, fn ($x) => $x->where('type', $type))
            ->latest()->paginate(50)->withQueryString();

        $counts = [
            'all' => Location::count(),
            'baznas' => Location::where('type', 'baznas')->count(),
            'upz' => Location::where('type', 'upz')->count(),
            'warga' => Location::where('type', 'warga')->count(),
        ];

        return view('dashboard.super-locations', compact('locations', 'counts', 'type'));
    }

    public function activity()
    {
        $activities = LoginActivity::with('user')->latest('logged_in_at')->paginate(50);
        $total = LoginActivity::count();

        return view('dashboard.super-activity', compact('activities', 'total'));
    }
}
