@extends('layouts.dashboard')
@section('title','Dashboard User — E-Zakat')
@section('page-title')Assalamualaikum, {{ auth()->user()->name }}@endsection
@section('page-sub','Selamat datang di E-Zakat Banjarbaru')
@section('content')

<div class="bg-cream rounded-[20px] border border-cream3 p-5 lg:p-6">
    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 justify-between">
        <div>
            <div class="font-extrabold text-oliveDark text-lg">Tunaikan Zakat Anda</div>
            <p class="text-sm text-olive/60 mt-1 max-w-lg">Hitung zakat fitrah, maal, atau fidyah; temukan lokasi penyaluran terdekat; dan pelajari panduan zakat lengkap — semua tersedia untuk Anda.</p>
        </div>
        <a href="{{ url('/kalkulator') }}" class="bg-olive text-white font-semibold px-6 py-3 rounded-full hover:bg-olive2 whitespace-nowrap"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-building-columns"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalBaznas }}</div>
        <div class="text-xs font-semibold text-oliveDark">Titik BAZNAS</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-mosque"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalUpz }}</div>
        <div class="text-xs font-semibold text-oliveDark">UPZ / Masjid</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="w-10 h-10 bg-olive/10 text-olive rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalLocations }}</div>
        <div class="text-xs font-semibold text-oliveDark">Total Lokasi</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="text-2xl font-black mt-3">Rp {{ number_format($beras,0,',','.') }}</div>
        <div class="text-xs text-cream/80">Beras Banjar /kg</div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    <a href="{{ url('/kalkulator') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-calculator"></i></div>
        <div class="font-bold text-oliveDark mt-4">Kalkulator Zakat</div>
        <div class="text-sm text-olive/60 mt-1">Hitung zakat fitrah, maal, dan fidyah otomatis.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Buka <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ url('/direktori') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-earth text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="font-bold text-oliveDark mt-4">Lokasi Penyaluran UPZ/BAZNAS</div>
        <div class="text-sm text-olive/60 mt-1">Lihat lokasi penyaluran zakat di Banjarbaru.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Lihat Peta <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ url('/panduan') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive2 text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-book-open"></i></div>
        <div class="font-bold text-oliveDark mt-4">Panduan Zakat</div>
        <div class="text-sm text-olive/60 mt-1">Niat, syarat, besaran, 8 asnaf, dan FAQ.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Baca <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
</div>
@endsection
