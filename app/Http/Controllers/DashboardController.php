<?php

namespace App\Http\Controllers;

use App\Models\BerasPrice;
use App\Models\Location;
use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $u = Auth::user();

        if ($u->isSuperAdmin()) {
            return $this->superAdmin($u);
        }

        if ($u->isAdmin()) {
            return $this->admin($u);
        }

        return $this->user($u);
    }

    private function superAdmin(User $u)
    {
        $totalAdmins = User::whereIn('role', ['admin', 'admin_baznas', 'admin_upz'])->count();
        $totalUpz = User::where('role', 'admin_upz')->count();
        $totalBaznasAdmin = User::where('role', 'admin_baznas')->count();
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('is_active', true)->count();
        $everLoggedIn = User::whereNotNull('last_login_at')->count();
        $totalLocations = Location::count();
        $locationsByType = [
            'baznas' => Location::where('type', 'baznas')->count(),
            'upz' => Location::where('type', 'upz')->count(),
            'warga' => Location::where('type', 'warga')->count(),
        ];

        $loginsToday = LoginActivity::whereDate('logged_in_at', today())->count();
        $loginsWeek = LoginActivity::where('logged_in_at', '>=', now()->subDays(7))->count();

        // Login activity — last 7 days
        $loginSeries = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $loginSeries[] = [
                'label' => $d->translatedFormat('D'),
                'count' => LoginActivity::whereDate('logged_in_at', $d->toDateString())->count(),
            ];
        }

        // User growth — last 6 months
        $userGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $userGrowth[] = [
                'label' => $m->translatedFormat('M'),
                'count' => User::whereYear('created_at', $m->year)
                    ->whereMonth('created_at', $m->month)
                    ->where('role', 'user')->count(),
            ];
        }

        $recentActivity = LoginActivity::with('user')->latest('logged_in_at')->take(8)->get();
        $latestUsers = User::latest()->take(6)->get();
        $beras = BerasPrice::current();

        return view('dashboard.super', compact(
            'u', 'totalAdmins', 'totalUpz', 'totalBaznasAdmin', 'totalUsers',
            'activeUsers', 'everLoggedIn', 'totalLocations', 'locationsByType',
            'loginsToday', 'loginsWeek', 'loginSeries', 'userGrowth', 'recentActivity',
            'latestUsers', 'beras'
        ));
    }

    private function admin(User $u)
    {
        $query = Location::query();
        if ($u->isAdminUpz()) {
            $query->where('created_by', $u->id);
        }
        $myLocations = $query->latest()->get();
        $beras = BerasPrice::current();
        $totalLocations = Location::count();
        $locationsByType = [
            'baznas' => Location::where('type', 'baznas')->count(),
            'upz' => Location::where('type', 'upz')->count(),
            'warga' => Location::where('type', 'warga')->count(),
        ];

        return view('dashboard.admin', compact('u', 'myLocations', 'beras', 'totalLocations', 'locationsByType'));
    }

    private function user(User $u)
    {
        $beras = BerasPrice::currentPrice();
        $totalLocations = Location::where('is_active', true)->count();
        $totalUpz = Location::where('type', 'upz')->count();
        $totalBaznas = Location::where('type', 'baznas')->count();
        $profile = $u->wargaProfile;
        $totalRecords = $u->zakatRecords()->count();

        return view('dashboard.user', compact('u', 'beras', 'totalLocations', 'totalUpz', 'totalBaznas', 'profile', 'totalRecords'));
    }
}
