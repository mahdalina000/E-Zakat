<?php

use App\Http\Controllers\ApiAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Endpoint API memakai token (Sanctum). Semua route di sini otomatis
| ber-prefiks "/api".
|
*/

// Terbitkan token (login API) — dibatasi rate limit
Route::post('/token', [ApiAuthController::class, 'token'])
    ->middleware('throttle:login');

// Route yang menuntut token valid (Bearer)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});
