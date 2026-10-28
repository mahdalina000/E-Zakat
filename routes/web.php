<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminBaznasController;
use App\Http\Controllers\BerasPriceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserProfileController;
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

    // User — Profil & Kelola Zakat
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::post('/records', [UserProfileController::class, 'storeRecord'])->name('records.store');
        Route::delete('/records/{record}', [UserProfileController::class, 'destroyRecord'])->name('records.destroy');
        Route::get('/waris', fn () => redirect()->route('user.calculators', ['tab' => 'wariq']))->name('waris');
        Route::get('/histories', [UserProfileController::class, 'histories'])->name('histories');
        Route::get('/export', [UserProfileController::class, 'export'])->name('export');

        // Hub kalkulator (semua kalkulator dalam satu halaman, hasil disimpan ke riwayat)
        Route::get('/calculators', [UserProfileController::class, 'calculators'])->name('calculators');
        Route::post('/calculators/{type}', [UserProfileController::class, 'saveCalculation'])->name('calculators.save');
        Route::post('/calculators/{type}/calculate', [UserProfileController::class, 'calculate'])->name('calculators.calculate');
    });

    // Admin UPZ / BAZNAS — Kelola warga & penerima zakat
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/baznas', [AdminBaznasController::class, 'index'])->name('baznas');
        Route::post('/warga', [AdminBaznasController::class, 'storeWarga'])->name('warga.store');
        Route::get('/warga/{user}', [AdminBaznasController::class, 'showWarga'])->name('warga.show');
        Route::get('/warga/{user}/edit', [AdminBaznasController::class, 'editWarga'])->name('warga.edit');
        Route::put('/warga/{user}', [AdminBaznasController::class, 'updateWarga'])->name('warga.update');
        Route::post('/warga/{user}/records', [AdminBaznasController::class, 'storeRecord'])->name('records.store');
        Route::delete('/records/{record}', [AdminBaznasController::class, 'destroyRecord'])->name('records.destroy');
        Route::get('/export', [AdminBaznasController::class, 'export'])->name('export');

        // Lokasi (existing)
        Route::resource('locations', LocationController::class)->except(['show']);
        Route::get('/beras', [BerasPriceController::class, 'index'])->name('beras.index');
        Route::post('/beras', [BerasPriceController::class, 'update'])->name('beras.update');
    });

    // Super Admin — Pemko Banjarbaru
    Route::middleware('role:super_admin')->prefix('super')->name('super.')->group(function () {
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::get('/locations', [SuperAdminController::class, 'locations'])->name('locations');
        Route::get('/activity', [SuperAdminController::class, 'activity'])->name('activity');
    });
});
