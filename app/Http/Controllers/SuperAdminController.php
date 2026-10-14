<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LoginActivity;
use App\Models\User;
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
            ->paginate(12)
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

    public function locations()
    {
        $type = request('type');
        $locations = Location::with('creator')
            ->when($type, fn ($x) => $x->where('type', $type))
            ->latest()->paginate(15)->withQueryString();

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
        $activities = LoginActivity::with('user')->latest('logged_in_at')->paginate(20);
        $total = LoginActivity::count();

        return view('dashboard.super-activity', compact('activities', 'total'));
    }
}
