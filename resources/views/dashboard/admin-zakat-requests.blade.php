@extends('layouts.dashboard')
@section('title','Pengajuan Hitung Waris — E-Zakat')
@section('page-title','Pengajuan Hitung Waris')
@section('page-sub','Verifikasi & hitung pembagian waris yang diajukan masyarakat')

@section('content')

{{-- FILTER STATUS --}}
<div class="flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.zakat-requests') }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ !$q ? 'bg-olive text-white border-olive' : 'bg-white border-cream3 text-olive hover:bg-cream2' }}">Semua</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'pending']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white border-cream3 text-amber-600 hover:bg-cream2' }}">Menunggu</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'verified']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'verified' ? 'bg-sky-500 text-white border-sky-500' : 'bg-white border-cream3 text-sky-600 hover:bg-cream2' }}">Terverifikasi</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'done']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'done' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white border-cream3 text-emerald-600 hover:bg-cream2' }}">Selesai</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'rejected']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'rejected' ? 'bg-red-500 text-white border-red-500' : 'bg-white border-cream3 text-red-500 hover:bg-cream2' }}">Ditolak</a>
</div>

<div class="space-y-3">
    @forelse($requests as $rq)
    @php $w = $rq->waris_data ?? []; @endphp
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-10 h-10 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-sm shrink-0">{{ strtoupper(substr($rq->user->name ?? $rq->full_name, 0, 1)) }}</span>
                <div class="min-w-0">
                    <div class="font-bold text-oliveDark text-sm truncate">{{ $rq->user->name ?? $rq->full_name }}</div>
                    <div class="text-[11px] text-olive/50">{{ $rq->user->email ?? '-' }} · {{ $rq->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($rq->status === 'pending')
                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full">⏳ Menunggu Verifikasi</span>
                @elseif($rq->status === 'verified')
                <span class="bg-sky-100 text-sky-700 text-[10px] font-bold px-2.5 py-1 rounded-full">Terverifikasi</span>
                @elseif($rq->status === 'done')
                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full">✓ Selesai</span>
                @else
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full">✕ Ditolak</span>
                @endif
            </div>
        </div>

        {{-- DATA PENGAJUAN WARIS --}}
        <div class="bg-cream2/60 rounded-2xl p-3 text-[11px] mb-3">
            <div class="font-bold text-oliveDark mb-1.5"><i class="fa-solid fa-user-xmark mr-1 text-olive"></i>Pewaris: {{ $rq->deceased_name ?? $rq->full_name }} ({{ ($w['pewaris_jk'] ?? 'L') === 'P' ? 'Perempuan' : 'Laki-laki' }})</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <div><span class="text-olive/50">Harta warisan:</span> <b class="text-oliveDark">Rp {{ number_format($w['total_harta'] ?? $rq->total_assets, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">Hutang:</span> <b class="text-oliveDark">Rp {{ number_format($w['hutang'] ?? $rq->debt_amount, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">Biaya pemakaman:</span> <b class="text-oliveDark">Rp {{ number_format($w['biaya_pemakaman'] ?? 0, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">Wasiat:</span> <b class="text-oliveDark">Rp {{ number_format($w['wasiat'] ?? 0, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">Harta sengketa:</span> <b class="text-oliveDark">Rp {{ number_format($w['harta_sengketa'] ?? 0, 0, ',', '.') }}</b></div>
            </div>
            <div class="mt-2 text-[10px] text-olive/70 border-t border-cream2 pt-1.5">
                Ahli waris:  anak laki-laki {{ (int)($w['jumlah_anak_l'] ?? 0) }} · anak perempuan {{ (int)($w['jumlah_anak_p'] ?? 0) }} · cucu L {{ (int)($w['jumlah_cucu_l'] ?? 0) }} · cucu P {{ (int)($w['jumlah_cucu_p'] ?? 0) }} · saudara L {{ (int)($w['jumlah_saudara_l'] ?? 0) }} · saudara P {{ (int)($w['jumlah_saudara_p'] ?? 0) }} · seibu {{ (int)($w['jumlah_saudara_seibu'] ?? 0) }} · @php $ada = []; if($w['ada_ayah']??false)$ada[]='Ayah'; if($w['ada_ibu']??false)$ada[]='Ibu'; if($w['ada_kakek']??false)$ada[]='Kakek'; if($w['ada_nenek_ibu']??false)$ada[]='Nenek (ibu)'; if($w['ada_nenek_ayah']??false)$ada[]='Nenek (ayah)'; if($w['ada_istri']??false)$ada[]='Istri (' . ((int)($w['jumlah_istri'] ?? 1)) . ')'; if($w['ada_suami']??false)$ada[]='Suami'; @endphp {{ $ada ? implode(', ', $ada) : 'tidak ada' }}
            </div>
        </div>

        @if($rq->description)
        <div class="text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2 mb-3"><i class="fa-solid fa-note-sticky mr-1 text-olive"></i>{{ $rq->description }}</div>
        @endif

        {{-- HASIL --}}
        @if($rq->status === 'done' && !empty($rq->waris_data) && !empty($rq->calculation_detail))
        <div class="mb-3 bg-olive rounded-2xl p-4 text-white">
            <div class="text-[10px] uppercase tracking-wider text-cream/70">Hasil Pembagian Waris</div>
            <div class="text-2xl font-black mt-1">Rp {{ number_format($rq->calculated_amount, 0, ',', '.') }}</div>
            <div class="text-[10px] text-cream/70 mt-0.5">Harta bersih yang dibagikan</div>
            @php $detail = is_array($rq->calculation_detail) ? $rq->calculation_detail : []; $hasil = is_array($detail['hasil'] ?? null) ? $detail['hasil'] : []; @endphp
            @if(!empty($detail['potongan']) && is_array($detail['potongan']) && ($detail['potongan']['total'] ?? 0) > 0)
            <div class="mt-3 space-y-0.5 text-[11px] text-cream/80 border-t border-white/15 pt-2">
                @if(($detail['hartaSengketa'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Harta sengketa</span><b>Rp {{ number_format($detail['hartaSengketa'], 0, ',', '.') }}</b></div>@endif
                @if(($detail['potongan']['hutang'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Hutang</span><b>Rp {{ number_format($detail['potongan']['hutang'], 0, ',', '.') }}</b></div>@endif
                @if(($detail['potongan']['biaya_pemakaman'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Biaya pemakaman</span><b>Rp {{ number_format($detail['potongan']['biaya_pemakaman'], 0, ',', '.') }}</b></div>@endif
                @if(($detail['potongan']['wasiat'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Wasiat</span><b>Rp {{ number_format($detail['potongan']['wasiat'], 0, ',', '.') }}</b></div>@endif
            </div>
            @endif
            @if(!empty($hasil))
            <div class="mt-3 border-t border-white/15 pt-2 space-y-1.5">
                @foreach($hasil as $h)
                @php $m = preg_match('/^(.+?)\s*\((\d+)\)$/', $h['ahli'] ?? '', $mm); @endphp
                @if($m)
                    @php $n = (int)$mm[2]; $nilai = ($h['nilai'] ?? 0)/$n; $persen = ($h['persen'] ?? 0)/$n; @endphp
                    @for($i=1; $i<=$n; $i++)
                    <div class="flex items-center justify-between gap-2 border-b border-white/10 pb-1">
                        <div><div class="font-bold text-xs">{{ $mm[1] }} #{{ $i }}</div><div class="text-[10px] text-cream/70">{{ number_format($persen, 2) }}%</div></div>
                        <div class="text-right font-black text-sm">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
                    </div>
                    @endfor
                @else
                    <div class="flex items-center justify-between gap-2 border-b border-white/10 pb-1">
                        <div><div class="font-bold text-xs">{{ $h['ahli'] }}</div><div class="text-[10px] text-cream/70">{{ number_format($h['persen'] ?? 0, 2) }}%</div></div>
                        <div class="text-right font-black text-sm">Rp {{ number_format($h['nilai'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                @endif
                @endforeach
            </div>
            @endif
            @if(!empty($detail['keterangan']) && is_array($detail['keterangan']))
            <div class="mt-3 border-t border-white/15 pt-2 text-[10px] text-cream/80 space-y-1">
                @foreach($detail['keterangan'] as $k)<div>• {{ $k }}</div>@endforeach
            </div>
            @endif
        </div>
        @endif

        @if($rq->admin_note)
        <div class="text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2 mb-3"><i class="fa-solid fa-comment mr-1 text-olive"></i>Catatan admin: {{ $rq->admin_note }}</div>
        @endif

        {{-- AKSI ADMIN --}}
        @if($rq->status === 'pending')
        <div class="flex flex-wrap gap-2 pt-1 border-t border-cream2">
            <form action="{{ route('admin.zakat-requests.verify', $rq) }}" method="POST">
                @csrf
                <button type="submit" class="bg-olive text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-olive2"><i class="fa-solid fa-check mr-1"></i>Verifikasi</button>
            </form>
            <button onclick="document.getElementById('reject{{ $rq->id }}').classList.toggle('hidden')" class="bg-red-50 text-red-500 text-xs font-semibold px-4 py-2 rounded-full border border-red-200 hover:bg-red-100"><i class="fa-solid fa-xmark mr-1"></i>Tolak</button>
        </div>
        <div id="reject{{ $rq->id }}" class="hidden mt-3">
            <form action="{{ route('admin.zakat-requests.reject', $rq) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input name="admin_note" placeholder="Alasan penolakan (opsional)" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                <button type="submit" class="bg-red-500 text-white text-xs font-semibold px-4 py-2 rounded-full">Konfirmasi Tolak</button>
            </form>
        </div>
        @elseif($rq->status === 'verified')
        <div class="border-t border-cream2 pt-3">
            <form action="{{ route('admin.zakat-requests.calculate', $rq) }}" method="POST" class="space-y-2">
                @csrf
                <div class="bg-cream2/60 rounded-xl p-3">
                    <div class="text-xs font-bold text-oliveDark mb-1"><i class="fa-solid fa-calculator mr-1"></i>Perhitungan otomatis: Pembagian Waris (faraidz)</div>
                    <div class="text-[11px] text-olive/60">Sistem akan menghitung secara otomatis berdasarkan data ahli waris yang diajukan warga (urutan: biaya jenazah → hutang → wasiat → pembagian).</div>
                </div>
                <input name="admin_note" placeholder="Catatan untuk warga (opsional)" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                <button type="submit" class="w-full bg-olive text-white text-xs font-semibold px-4 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>Hitung & Kirim Hasil</button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-[20px] border border-cream3 p-10 text-center text-olive/40 text-sm">
        <i class="fa-solid fa-inbox text-3xl block mb-2 text-olive/30"></i>
        Tidak ada pengajuan pada filter ini.
    </div>
    @endforelse
</div>

@if($requests->hasPages())
<div class="mt-4">{{ $requests->links() }}</div>
@endif

@endsection
