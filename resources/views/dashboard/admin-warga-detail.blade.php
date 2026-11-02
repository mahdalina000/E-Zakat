@extends('layouts.dashboard')
@section('title','Detail Warga — E-Zakat')
@section('page-title','Detail Warga — ' . $user->name)
@section('page-sub','Data lengkap dan catatan zakat warga')
@section('content')

<div class="grid lg:grid-cols-2 gap-4">
    {{-- PROFIL --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="flex items-center gap-3 mb-4">
            <span class="w-12 h-12 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-lg">{{ strtoupper(substr($user->name,0,1)) }}</span>
            <div>
                <div class="font-bold text-oliveDark">{{ $user->name }}</div>
                <div class="text-xs text-olive/50">{{ $user->email }}</div>
            </div>
            @if($profile?->zakat_category)
            <span class="ml-auto text-[11px] px-3 py-1 rounded-full {{ $profile->zakat_category === 'penerima_fakir' ? 'bg-red-100 text-red-700' : ($profile->zakat_category === 'penerima_miskin' ? 'bg-amber-100 text-amber-700' : ($profile->zakat_category === 'penerima_gharimin' ? 'bg-sky-100 text-sky-700' : 'bg-olive/10 text-olive')) }}">{{ $profile->kategoriLabel() }}</span>
            @endif
        </div>

        @if($profile)
        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">NIK</div><div class="font-bold text-oliveDark">{{ $profile->nik ?? '-' }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Jenis Kelamin</div><div class="font-bold text-oliveDark">{{ $profile->genderLabel() }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Tanggal Lahir</div><div class="font-bold text-oliveDark">{{ $profile->birth_date?->translatedFormat('d M Y') ?? '-' }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Status</div><div class="font-bold text-oliveDark">{{ $profile->statusPernikahanLabel() }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Pekerjaan</div><div class="font-bold text-oliveDark">{{ $profile->occupation ?? '-' }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Tanggungan</div><div class="font-bold text-oliveDark">{{ $profile->dependents_count ?? 0 }} jiwa</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Penghasilan/Bulan</div><div class="font-bold text-oliveDark">Rp {{ number_format($profile->monthly_income ?? 0, 0, ',', '.') }}</div></div>
            <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Hutang</div><div class="font-bold text-oliveDark">Rp {{ number_format($profile->debt_amount ?? 0, 0, ',', '.') }}</div></div>
            <div class="bg-cream2 rounded-xl p-3 col-span-full"><div class="text-olive/60">Alamat</div><div class="font-bold text-oliveDark">{{ $profile->address_line1 ?: '-' }}</div></div>
        </div>
        @if($profile->zakat_category_reason)
        <div class="mt-3 bg-cream2 rounded-xl p-3 text-xs"><div class="font-bold text-olive/60 mb-1">Kategori & Alasan</div>{{ $profile->kategoriLabel() }} — {{ $profile->zakat_category_reason }}</div>
        @endif
        @else
        <div class="text-center py-6 text-olive/40 text-sm">Profil belum dibuat.</div>
        @endif
    </div>

    {{-- CATATAN ZAKAT --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="font-bold text-oliveDark text-sm"><i class="fa-solid fa-clipboard-list text-olive mr-2"></i> Catatan Zakat</div>
            <a href="{{ route('admin.export') }}" class="bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full"><i class="fa-solid fa-file-excel mr-1"></i> Export Excel</a>
        </div>

        <div class="space-y-2 max-h-[400px] overflow-auto">
            @forelse($records as $r)
            <div class="bg-cream2 rounded-xl p-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-olive">{{ $r->zakatTypeLabel() }}</span>
                    <span class="text-olive/50">{{ $r->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="mt-1 text-olive/70">{{ Str::limit($r->notes ?? 'Tanpa keterangan', 60) }}</div>
                @if($r->total_amount)
                <div class="mt-1 font-bold text-oliveDark">Rp {{ number_format($r->total_amount, 0, ',', '.') }}</div>
                @endif
                @if($r->beras_kg)
                <div class="mt-1 text-[10px] text-olive/50">Beras: {{ $r->beras_kg }} kg</div>
                @endif
                <div class="flex items-center justify-between mt-2">
                    <span class="text-[10px] text-olive/50">Metode: {{ $r->paymentMethodLabel() }}</span>
                    <span class="text-[10px] text-olive/40">Baca saja</span>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-olive/40 text-xs">Belum ada catatan zakat untuk warga ini.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.baznas') }}" class="text-xs text-olive font-semibold">← Kembali ke Kelola Penerima Zakat</a>
</div>
@endsection
