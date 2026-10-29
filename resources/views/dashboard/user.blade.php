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

<div class="rounded-[20px] bg-gradient-to-br from-olive via-olive to-olive2 text-white p-5 lg:p-6 shadow-md relative overflow-hidden">
    <div class="absolute -right-8 -top-10 w-44 h-44 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-12 -left-6 w-36 h-36 rounded-full border-4 border-white/10"></div>
    <div class="relative flex flex-col lg:flex-row items-start lg:items-center gap-4 justify-between">
        <div>
            <div class="font-extrabold text-lg">Tunaikan Zakat Anda</div>
            <p class="text-sm text-cream/85 mt-1 max-w-lg">Hitung zakat fitrah, maal, fidyah, dan waris dalam satu tempat; hasil perhitungan tersimpan otomatis di riwayat Anda.</p>
        </div>
        <a href="{{ route('user.calculators') }}" class="bg-gold text-oliveDark font-bold px-6 py-3 rounded-full hover:brightness-105 whitespace-nowrap shadow-lg"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
    <div class="group rounded-[20px] bg-gradient-to-br from-olive/10 via-white to-cream2 border border-olive/15 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-start justify-between">
            <div class="w-11 h-11 bg-gradient-to-br from-olive to-olive2 text-white rounded-xl flex items-center justify-center shadow-sm"><i class="fa-solid fa-building-columns"></i></div>
            <span class="text-[9px] tracking-widest uppercase font-bold text-olive/50">BAZNAS</span>
        </div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalBaznas }}</div>
        <div class="text-xs font-semibold text-oliveDark mt-0.5">Titik BAZNAS</div>
    </div>
    <div class="group rounded-[20px] bg-gradient-to-br from-gold/15 via-white to-cream2 border border-gold/30 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-start justify-between">
            <div class="w-11 h-11 bg-gradient-to-br from-gold to-earth text-white rounded-xl flex items-center justify-center shadow-sm"><i class="fa-solid fa-mosque"></i></div>
            <span class="text-[9px] tracking-widest uppercase font-bold text-gold/60">UPZ</span>
        </div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalUpz }}</div>
        <div class="text-xs font-semibold text-oliveDark mt-0.5">UPZ / Masjid</div>
    </div>
    <div class="group rounded-[20px] bg-gradient-to-br from-white to-cream2 border border-emerald-500/30 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-start justify-between">
            <div class="w-11 h-11 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-sm"><i class="fa-solid fa-map-location-dot"></i></div>
            <span class="text-[9px] tracking-widest uppercase font-bold text-emerald-600/60">CATATAN</span>
        </div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $totalRecords }}</div>
        <div class="text-xs font-semibold text-oliveDark mt-0.5">Catatan Zakat</div>
    </div>
    <div class="rounded-[20px] bg-gradient-to-br from-olive to-olive2 p-4 text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white/10"></div>
        <div class="absolute right-6 bottom-2 text-white/10 text-3xl"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="flex items-center justify-between">
            <div class="w-11 h-11 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
            <span class="text-[9px] tracking-widest uppercase font-bold text-gold">HARGA</span>
        </div>
        <div class="text-2xl font-black mt-3 text-gold">Rp {{ number_format($beras,0,',','.') }}</div>
        <div class="text-xs text-cream/80">Beras Banjar /kg</div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    <a href="{{ route('user.calculators') }}" class="group bg-gradient-to-br from-olive to-olive2 rounded-[20px] p-5 hover:shadow-lg transition text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-calculator"></i></div>
        <div class="font-bold text-white mt-4">Pusat Kalkulator</div>
        <div class="text-sm text-cream/85 mt-1">Fitrah, Maal, Fidyah, Penghasilan, Pertanian, Perdagangan & Waris — dengan riwayat.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">Buka <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
    <a href="{{ route('user.profile') }}" class="group bg-gradient-to-br from-gold/15 via-white to-cream2 rounded-[20px] border border-gold/30 p-5 hover:shadow-md transition shadow-sm">
        <div class="w-12 h-12 bg-gradient-to-br from-gold to-earth text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-id-card"></i></div>
        <div class="font-bold text-oliveDark mt-4">Profil & Data Diri</div>
        <div class="text-sm text-olive/60 mt-1">Lengkapi data diri untuk kategori zakat otomatis.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">Lihat <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
    <a href="{{ route('user.histories') }}" class="group bg-gradient-to-br from-white to-cream2 rounded-[20px] border border-emerald-500/30 p-5 hover:shadow-md transition shadow-sm">
        <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <div class="font-bold text-oliveDark mt-4">Riwayat Perhitungan</div>
        <div class="text-sm text-olive/60 mt-1">Lihat semua perhitungan yang pernah dilakukan.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">Lihat <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
</div>

<div class="rounded-[20px] bg-gradient-to-r from-olive to-olive2 text-white p-4 flex flex-col sm:flex-row items-start sm:items-center gap-3 justify-between mt-4 shadow-md">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gold/25 text-gold rounded-xl flex items-center justify-center"><i class="fa-solid fa-book-open-reader"></i></div>
        <div>
            <div class="font-bold">Butuh bantuan?</div>
            <div class="text-xs text-cream/80">Pelajari nisab, cara hitung, dan panduan zakat &amp; waris.</div>
        </div>
    </div>
    <a href="{{ route('panduan') }}" class="bg-gold text-oliveDark font-bold px-5 py-2.5 rounded-full text-sm whitespace-nowrap shadow">Buka Panduan →</a>
</div>

@endsection
