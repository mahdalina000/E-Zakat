@extends('layouts.dashboard')
@section('title','Dashboard User — E-Zakat')
@section('page-title')Assalamualaikum, {{ auth()->user()->name }}@endsection
@section('page-sub','Selamat datang di E-Zakat Banjarbaru')
@section('content')

{{-- STATUS PROFIL --}}
@if($profile?->zakat_category)
<div class="bg-olive/10 border border-olive/20 rounded-[20px] p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-id-card"></i></div>
        <div>
            <div class="text-xs text-olive/60 font-semibold">Status Zakat Anda</div>
            <div class="font-black text-oliveDark">{{ $profile->kategoriLabel() }}</div>
        </div>
    </div>
    <a href="{{ route('user.profile') }}" class="text-xs font-semibold text-olive underline">Lihat Profil →</a>
</div>
@endif

<div class="rounded-[20px] border border-cream3/40 p-5 lg:p-6">
    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 justify-between">
        <div>
            <div class="font-extrabold text-oliveDark text-lg">Tunaikan Zakat Anda</div>
            <p class="text-sm text-olive/60 mt-1 max-w-lg">Hitung zakat fitrah, maal, fidyah, dan waris dalam satu tempat; hasil perhitungan tersimpan otomatis di riwayat Anda.</p>
        </div>
        <a href="{{ route('user.calculators') }}" class="bg-olive text-white font-semibold px-6 py-3 rounded-full hover:bg-olive2 whitespace-nowrap"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-building-columns"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalBaznas }}</div>
        <div class="text-xs font-semibold text-oliveDark">Titik BAZNAS</div>
    </div>
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-mosque"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalUpz }}</div>
        <div class="text-xs font-semibold text-oliveDark">UPZ / Masjid</div>
    </div>
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-olive/10 text-olive rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalRecords }}</div>
        <div class="text-xs font-semibold text-oliveDark">Catatan Zakat</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white shadow-md">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="text-2xl font-black mt-3">Rp {{ number_format($beras,0,',','.') }}</div>
        <div class="text-xs text-cream/80">Beras Banjar /kg</div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    <a href="{{ route('user.calculators') }}" class="bg-olive rounded-[20px] p-5 hover:shadow-md transition text-white">
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-calculator"></i></div>
        <div class="font-bold text-oliveDark mt-4">Pusat Kalkulator</div>
        <div class="text-sm text-cream/80 mt-1">Fitrah, Maal, Fidyah, Penghasilan, Pertanian, Perdagangan & Waris — dengan riwayat.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-cream">Buka <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ route('user.profile') }}" class="rounded-[20px] border border-cream3/30 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive/10 text-olive rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-id-card"></i></div>
        <div class="font-bold text-oliveDark mt-4">Profil & Data Diri</div>
        <div class="text-sm text-olive/60 mt-1">Lengkapi data diri untuk kategori zakat otomatis.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Lihat <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ route('user.histories') }}" class="rounded-[20px] border border-cream3/30 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive/10 text-olive rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <div class="font-bold text-oliveDark mt-4">Riwayat Perhitungan</div>
        <div class="text-sm text-olive/60 mt-1">Lihat semua perhitungan yang pernah dilakukan.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Lihat <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    </a>
</div>

@endsection
