<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('beranda');
});

Route::get('/kalkulator', function () {
    return view('kalkulator');
});

Route::get('/direktori', function () {
    return view('direktori');
});

Route::get('/panduan', function () {
    return view('panduan');
});
