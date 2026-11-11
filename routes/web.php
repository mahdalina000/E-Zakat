<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminBaznasController;
use App\Http\Controllers\BerasPriceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackAdminController;
use App\Http\Controllers\HolidayBannerAdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserFeedbackController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ZakatRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('welcome');
Route::get('/beranda', function () {
    $holidayBanners = \App\Models\HolidayBanner::where('is_active', true)
        ->orderBy('event_date')->get()
        ->map(fn ($b) => [
            'key' => $b->key,
            'name' => $b->name,
            'year' => (int) $b->event_date->format('Y'),
            'month' => (int) $b->event_date->format('n'),
            'day' => (int) $b->event_date->format('j'),
            'before' => $b->before_days,
            'after' => $b->after_days,
            'icon' => $b->icon,
            'color' => $b->color,
            'title' => $b->title,
            'text' => $b->text,
        ])->values();
    return view('beranda', compact('holidayBanners'));
})->name('beranda');
Route::get('/kalkulator', fn () => view('kalkulator', ['hargaBeras' => \App\Models\BerasPrice::currentPrice()]))->name('kalkulator');
Route::get('/direktori', function () {
    $locations = \App\Models\Location::where('is_active', true)
        ->where('type', '!=', 'warga')
        ->orderBy('type')->orderBy('name')->get();
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

    // Warga terverifikasi admin (kategori disahkan) — otomatis tampil di peta
    $wargaVerified = \App\Models\WargaProfile::with('user')
        ->where('category_approved', true)
        ->whereNotNull('location_id')
        ->with('location')
        ->get()
        ->filter(fn ($w) => $w->location)
        ->map(fn ($w) => [
            'id' => 9000 + $w->id,
            'cat' => 'warga',
            'name' => 'Warga: ' . ($w->user->name ?? 'Penerima'),
            'addr' => $w->location->address,
            'lat' => (float) $w->location->latitude,
            'lng' => (float) $w->location->longitude,
            'tel' => '-',
            'jam' => '-',
            'ket' => ($w->kategoriLabel() ?? ''),
            'wil' => $w->location->kelurahan . ', ' . $w->location->kecamatan,
        ])->values();

    $spots = $spots->concat($wargaVerified);
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
        Route::put('/records/{record}', [UserProfileController::class, 'updateRecord'])->name('records.update');
        Route::delete('/records/{record}', [UserProfileController::class, 'destroyRecord'])->name('records.destroy');
        Route::get('/waris', fn () => redirect('/user/calculators?tab=wariq'))->name('waris');
        Route::get('/histories', [UserProfileController::class, 'histories'])->name('histories');
        Route::delete('/histories/{history}', [UserProfileController::class, 'destroyHistory'])->name('histories.destroy');
        Route::get('/export', [UserProfileController::class, 'export'])->name('export');

        // Kritik & Saran
        Route::get('/feedback', [UserFeedbackController::class, 'index'])->name('feedback');
        Route::post('/feedback', [UserFeedbackController::class, 'store'])->name('feedback.store');
        Route::delete('/feedback/{feedback}', [UserFeedbackController::class, 'destroy'])->name('feedback.destroy');

        // Ajukan hitung zakat (masyarakat → admin)
        Route::get('/zakat-request', [ZakatRequestController::class, 'index'])->name('zakat-request');
        Route::post('/zakat-request', [ZakatRequestController::class, 'store'])->name('zakat-request.store');
        Route::delete('/zakat-request/{zakatRequest}', [ZakatRequestController::class, 'destroy'])->name('zakat-request.destroy');
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
        Route::post('/warga/{user}/verify', [AdminBaznasController::class, 'approveWarga'])->name('warga.verify');
        Route::get('/export', [AdminBaznasController::class, 'export'])->name('export');
        Route::get('/settings', [AdminBaznasController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminBaznasController::class, 'updateSettings'])->name('settings.update');

        // Lokasi (existing)
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
        Route::get('/beras', [BerasPriceController::class, 'index'])->name('beras.index');
        Route::post('/beras', [BerasPriceController::class, 'update'])->name('beras.update');

        // Masukan warga (kritik & saran)
        Route::get('/feedback', [FeedbackAdminController::class, 'index'])->name('feedback');
        Route::post('/feedback/{feedback}/read', [FeedbackAdminController::class, 'markRead'])->name('feedback.read');
        Route::delete('/feedback/{feedback}', [FeedbackAdminController::class, 'destroy'])->name('feedback.destroy');

        // Pengajuan hitung zakat dari masyarakat
        Route::get('/zakat-requests', [ZakatRequestController::class, 'adminIndex'])->name('zakat-requests');
        Route::post('/zakat-requests/{zakatRequest}/verify', [ZakatRequestController::class, 'verify'])->name('zakat-requests.verify');
        Route::post('/zakat-requests/{zakatRequest}/calculate', [ZakatRequestController::class, 'calculate'])->name('zakat-requests.calculate');
        Route::post('/zakat-requests/{zakatRequest}/reject', [ZakatRequestController::class, 'reject'])->name('zakat-requests.reject');

        // Banner hari besar keagamaan — Admin BAZNAS/UPZ
        Route::get('/holidays', [HolidayBannerAdminController::class, 'index'])->name('holidays.index');
        Route::post('/holidays', [HolidayBannerAdminController::class, 'store'])->name('holidays.store');
        Route::put('/holidays/{banner}', [HolidayBannerAdminController::class, 'update'])->name('holidays.update');
        Route::post('/holidays/{banner}/toggle', [HolidayBannerAdminController::class, 'toggle'])->name('holidays.toggle');
        Route::delete('/holidays/{banner}', [HolidayBannerAdminController::class, 'destroy'])->name('holidays.destroy');
    });

    // Super Admin — Pemko Banjarbaru
    Route::middleware('role:super_admin')->prefix('super')->name('super.')->group(function () {
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::post('/users', [SuperAdminController::class, 'store'])->name('users.store');
        Route::get('/locations', [SuperAdminController::class, 'locations'])->name('locations');
        Route::get('/activity', [SuperAdminController::class, 'activity'])->name('activity');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

        // Masukan warga
        Route::get('/feedback', [FeedbackAdminController::class, 'index'])->name('feedback');
        Route::post('/feedback/{feedback}/read', [FeedbackAdminController::class, 'markRead'])->name('feedback.read');
        Route::delete('/feedback/{feedback}', [FeedbackAdminController::class, 'destroy'])->name('feedback.destroy');
    });
});
