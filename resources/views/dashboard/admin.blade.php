@extends('layouts.dashboard')
@section('title','Dashboard Admin — E-Zakat')
@section('page-title')Dashboard Admin {{ auth()->user()->isAdminBaznas() ? 'BAZNAS' : 'UPZ' }}@endsection
@section('page-sub','Kelola lokasi penyaluran & harga beras')
@section('content')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-olive/10 text-olive rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $myLocations->count() }}</div>
        <div class="text-xs font-semibold text-oliveDark">Lokasi Saya Kelola</div>
    </div>
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-building-columns"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $locationsByType['baznas'] }}</div>
        <div class="text-xs font-semibold text-oliveDark">Total BAZNAS</div>
    </div>
    <div class="rounded-[20px] border border-cream3/30 p-4">
        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-mosque"></i></div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $locationsByType['upz'] }}</div>
        <div class="text-xs font-semibold text-oliveDark">Total UPZ/Masjid</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="text-2xl font-black mt-3">Rp {{ number_format($beras->price ?? 16000,0,',','.') }}</div>
        <div class="text-xs text-cream/80">Harga Beras Banjar /kg</div>
    </div>
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
