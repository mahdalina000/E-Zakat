<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerasPriceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('welcome');
Route::get('/beranda', fn () => view('beranda'))->name('beranda.publik');
Route::get('/kalkulator', fn () => view('kalkulator', ['hargaBeras' => \App\Models\BerasPrice::currentPrice()]))->name('kalkulator');
Route::get('/direktori', function () {
    $locations = \App\Models\Location::where('is_active', true)->orderBy('type')->orderBy('name')->get();
    $spots = $locations->map(fn ($l) => [
        'id' => $l->id,
        'cat' => $l->type,
        'name' => $l->name,
        'addr' => $l->address,
        'lat' => (float) $l->latitude,
        'lng' => (float) $l->longitude,
        'tel' => $l->phone ?? '-',
        'jam' => $l->opening_hours ?? '-',
        'ket' => $l->description ?? '',
        'wil' => $l->kelurahan . ', ' . $l->kecamatan,
    ])->values();
    return view('direktori', ['locations' => $locations, 'spots' => $spots]);
})->name('direktori');
Route::get('/panduan', fn () => view('panduan'))->name('panduan');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard (terautentikasi) — redirect otomatis sesuai role
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Super Admin — Pemko Banjarbaru
    Route::middleware('role:super_admin')->prefix('super')->name('super.')->group(function () {
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::get('/locations', [SuperAdminController::class, 'locations'])->name('locations');
        Route::get('/activity', [SuperAdminController::class, 'activity'])->name('activity');
    });

    // Admin UPZ / BAZNAS
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('locations', LocationController::class)->except(['show']);
        Route::get('/beras', [BerasPriceController::class, 'index'])->name('beras.index');
        Route::post('/beras', [BerasPriceController::class, 'update'])->name('beras.update');
    });
});
