@extends('layouts.dashboard')
@section('title','Dashboard Admin — E-Zakat')
@section('page-title')Dashboard Admin {{ auth()->user()->isAdminBaznas() ? 'BAZNAS' : 'UPZ' }}@endsection
@section('page-sub','Kelola lokasi penyaluran & harga beras')
@section('content')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="stat-card sc-sky">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <span class="sc-label">LOKASI</span>
        </div>
        <div class="sc-num">{{ $myLocations->count() }}</div>
        <div class="sc-sub">Lokasi Saya Kelola</div>
    </div>
    <div class="stat-card sc-olive">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-building-columns"></i></div>
            <span class="sc-label">BAZNAS</span>
        </div>
        <div class="sc-num">{{ $locationsByType['baznas'] }}</div>
        <div class="sc-sub">Total BAZNAS</div>
    </div>
    <div class="stat-card sc-gold">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-mosque"></i></div>
            <span class="sc-label">UPZ</span>
        </div>
        <div class="sc-num">{{ $locationsByType['upz'] }}</div>
        <div class="sc-sub">Total UPZ/Masjid</div>
    </div>
    <div class="stat-solid">
        <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white/10"></div>
        <div class="absolute right-6 bottom-2 text-white/10 text-3xl"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="flex items-center justify-between">
            <div class="sc-icon bg-white/15"><i class="fa-solid fa-wheat-awn"></i></div>
            <span class="sc-label">HARGA</span>
        </div>
        <div class="sc-num text-gold">Rp {{ number_format($beras->price ?? 16000,0,',','.') }}</div>
        <div class="sc-sub">Beras Banjar /kg</div>
    </div>
</div>


{{-- QUICK LINKS --}}
<div class="grid sm:grid-cols-3 gap-3 mt-4">
    <a href="{{ route('admin.baznas') }}" class="group bg-gradient-to-br from-gold/15 via-white to-cream2 border border-gold/30 rounded-2xl p-4 text-center hover:-translate-y-0.5 hover:shadow-md transition shadow-sm">
        <div class="w-11 h-11 mx-auto bg-gradient-to-br from-gold to-earth text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-users"></i></div>
        <div class="text-xs font-bold text-oliveDark mt-2">Kelola Warga Zakat</div>
    </a>
    <a href="{{ route('admin.export') }}" class="group bg-gradient-to-br from-white to-cream2 border border-emerald-500/30 rounded-2xl p-4 text-center hover:-translate-y-0.5 hover:shadow-md transition shadow-sm">
        <div class="w-11 h-11 mx-auto bg-emerald-500 text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-file-excel"></i></div>
        <div class="text-xs font-bold text-oliveDark mt-2">Export Catatan</div>
    </a>
    <a href="{{ route('admin.locations.create') }}" class="group bg-gradient-to-br from-olive/10 via-white to-cream2 border border-olive/15 rounded-2xl p-4 text-center hover:-translate-y-0.5 hover:shadow-md transition shadow-sm">
        <div class="w-11 h-11 mx-auto bg-gradient-to-br from-olive to-olive2 text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-xs font-bold text-oliveDark mt-2">Tambah Lokasi</div>
    </a>
</div>

<div class="grid lg:grid-cols-2 gap-4 mt-4">
    <div class="rounded-[20px] border border-cream3/30 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="font-bold text-oliveDark text-sm"><i class="fa-solid fa-map-location-dot text-olive mr-2"></i> Lokasi Saya</div>
            <a href="{{ route('admin.locations.create') }}" class="bg-olive text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-plus mr-1"></i> Tambah</a>
        </div>
        <div class="space-y-2 max-h-[300px] overflow-auto">
            @forelse($myLocations as $l)
            <div class="flex items-center gap-3 bg-cream rounded-xl p-3">
                <span class="w-3 h-3 rounded-full flex-shrink-0" style="background: #{{ ltrim($l->typeColor(),'#') }}"></span>
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-semibold truncate">{{ $l->name }}</div>
                    <div class="text-[11px] text-olive/50 truncate">{{ $l->kelurahan }}, {{ $l->kecamatan }}</div>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full border border-cream3 text-olive">{{ $l->typeLabel() }}</span>
            </div>
            @empty
            <div class="text-center py-8 text-olive/40 text-xs">Belum ada lokasi. <a href="{{ route('admin.locations.create') }}" class="text-olive underline">Tambah sekarang</a></div>
            @endforelse
        </div>
    </div>

    <div class="space-y-4">
        <div class="rounded-[20px] border border-cream3/30 p-5">
            <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-wheat-awn text-olive mr-2"></i> Harga Beras Banjar</div>
            <div class="flex items-end justify-between bg-cream rounded-xl p-4">
                <div>
                    <div class="text-xs text-olive/60">Harga saat ini</div>
                    <div class="text-3xl font-black text-olive">Rp {{ number_format($beras->price ?? 16000,0,',','.') }}<span class="text-sm">/kg</span></div>
                    <div class="text-[11px] text-olive/50 mt-1">Diperbarui {{ $beras?->updated_at?->diffForHumans() ?? '-' }}</div>
                </div>
                <a href="{{ route('admin.beras.index') }}" class="bg-olive text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-olive2">Kelola</a>
            </div>
        </div>

        <div class="bg-olive rounded-[20px] p-5 text-white">
            <div class="font-bold text-sm"><i class="fa-solid fa-circle-info mr-2"></i> Kewenangan Role Anda</div>
            <ul class="text-xs text-cream/80 mt-3 space-y-1.5 list-disc list-inside">
                @if(auth()->user()->isAdminBaznas())
                    <li>Kelola seluruh lokasi penyaluran</li>
                    <li>Perbarui harga Beras Banjar</li>
                    <li>Memantau data UPZ</li>
                @else
                    <li>Menambah & mengelola lokasi UPZ milik Anda</li>
                    <li>Melihat data lokasi yang Anda kelola</li>
                    <li>Tidak dapat mengubah data BAZNAS</li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
