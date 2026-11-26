@extends('layouts.dashboard')
@section('title', __('Pengajuan Hitung Waris — E-Zakat'))
@section('page-title', __('Pengajuan Hitung Waris'))
@section('page-sub', __('Verifikasi & hitung pembagian waris yang diajukan masyarakat'))

@section('content')

{{-- FILTER STATUS --}}
<div class="flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.zakat-requests') }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ !$q ? 'bg-olive text-white border-olive' : 'bg-white border-cream3 text-olive hover:bg-cream2' }}">{{ __('Semua') }}</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'pending']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white border-cream3 text-amber-600 hover:bg-cream2' }}">{{ __('Menunggu') }}</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'verified']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'verified' ? 'bg-sky-500 text-white border-sky-500' : 'bg-white border-cream3 text-sky-600 hover:bg-cream2' }}">{{ __('Terverifikasi') }}</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'done']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'done' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white border-cream3 text-emerald-600 hover:bg-cream2' }}">{{ __('Selesai') }}</a>
    <a href="{{ route('admin.zakat-requests', ['status' => 'rejected']) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ $q === 'rejected' ? 'bg-red-500 text-white border-red-500' : 'bg-white border-cream3 text-red-500 hover:bg-cream2' }}">{{ __('Ditolak') }}</a>
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
                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ __('⏳ Menunggu Verifikasi') }}</span>
                @elseif($rq->status === 'verified')
                <span class="bg-sky-100 text-sky-700 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ __('Terverifikasi') }}</span>
                @elseif($rq->status === 'done')
                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ __('✓ Selesai') }}</span>
                @else
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ __('✕ Ditolak') }}</span>
                @endif
            </div>
        </div>

        {{-- DATA PENGAJUAN WARIS --}}
        <div class="bg-cream2/60 rounded-2xl p-3 text-[11px] mb-3">
            <div class="font-bold text-oliveDark mb-1.5"><i class="fa-solid fa-user-xmark mr-1 text-olive"></i>{{ __('Pewaris:') }} {{ $rq->deceased_name ?? $rq->full_name }} ({{ ($w['pewaris_jk'] ?? 'L') === 'P' ? __('Perempuan') : __('Laki-laki') }})</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <div><span class="text-olive/50">{{ __('Harta warisan:') }}</span> <b class="text-oliveDark">Rp {{ number_format($w['total_harta'] ?? $rq->total_assets, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">{{ __('Hutang:') }}</span> <b class="text-oliveDark">Rp {{ number_format($w['hutang'] ?? $rq->debt_amount, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">{{ __('Biaya pemakaman:') }}</span> <b class="text-oliveDark">Rp {{ number_format($w['biaya_pemakaman'] ?? 0, 0, ',', '.') }}</b></div>
                <div><span class="text-olive/50">{{ __('Harta sengketa:') }}</span> <b class="text-oliveDark">Rp {{ number_format($w['harta_sengketa'] ?? 0, 0, ',', '.') }}</b></div>
            </div>
            <div class="mt-2 text-[10px] text-olive/70 border-t border-cream2 pt-1.5">
                {{ __('Ahli waris:') }} {{ __('anak laki-laki') }} {{ (int)($w['jumlah_anak_l'] ?? 0) }} {{ __('· anak perempuan') }} {{ (int)($w['jumlah_anak_p'] ?? 0) }} {{ __('· cucu L') }} {{ (int)($w['jumlah_cucu_l'] ?? 0) }} {{ __('· cucu P') }} {{ (int)($w['jumlah_cucu_p'] ?? 0) }} {{ __('· saudara L') }} {{ (int)($w['jumlah_saudara_l'] ?? 0) }} {{ __('· saudara P') }} {{ (int)($w['jumlah_saudara_p'] ?? 0) }} {{ __('· seibu') }} {{ (int)($w['jumlah_saudara_seibu'] ?? 0) }} · @php $ada = []; if($w['ada_ayah']??false)$ada[]='Ayah'; if($w['ada_ibu']??false)$ada[]='Ibu'; if($w['ada_kakek']??false)$ada[]='Kakek'; if($w['ada_nenek_ibu']??false)$ada[]='Nenek (ibu)'; if($w['ada_nenek_ayah']??false)$ada[]='Nenek (ayah)'; if($w['ada_istri']??false)$ada[]='Istri (' . ((int)($w['jumlah_istri'] ?? 1)) . ')'; if($w['ada_suami']??false)$ada[]='Suami'; @endphp {{ $ada ? implode(', ', $ada) : __('tidak ada') }}
            </div>
        </div>

        @if($rq->description)
        <div class="text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2 mb-3"><i class="fa-solid fa-note-sticky mr-1 text-olive"></i>{{ $rq->description }}</div>
        @endif

        {{-- HASIL --}}
        @if($rq->status === 'done' && !empty($rq->waris_data) && !empty($rq->calculation_detail))
        <div class="mb-3 bg-olive rounded-2xl p-4 text-white">
            <div class="text-[10px] uppercase tracking-wider text-cream/70">{{ __('Hasil Pembagian Waris') }}</div>
            <div class="text-2xl font-black mt-1">Rp {{ number_format($rq->calculated_amount, 0, ',', '.') }}</div>
            <div class="text-[10px] text-cream/70 mt-0.5">{{ __('Harta bersih yang dibagikan') }}</div>
            @php $detail = is_array($rq->calculation_detail) ? $rq->calculation_detail : []; $hasil = is_array($detail['hasil'] ?? null) ? $detail['hasil'] : []; @endphp
            @if(!empty($detail['potongan']) && is_array($detail['potongan']) && ($detail['potongan']['total'] ?? 0) > 0)
            <div class="mt-3 space-y-0.5 text-[11px] text-cream/80 border-t border-white/15 pt-2">
                @if(($detail['hartaSengketa'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Harta sengketa') }}</span><b>Rp {{ number_format($detail['hartaSengketa'], 0, ',', '.') }}</b></div>@endif
                @if(($detail['potongan']['hutang'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Hutang') }}</span><b>Rp {{ number_format($detail['potongan']['hutang'], 0, ',', '.') }}</b></div>@endif
                @if(($detail['potongan']['biaya_pemakaman'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Biaya pemakaman') }}</span><b>Rp {{ number_format($detail['potongan']['biaya_pemakaman'], 0, ',', '.') }}</b></div>@endif
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
        <div class="text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2 mb-3"><i class="fa-solid fa-comment mr-1 text-olive"></i>{{ __('Catatan admin:') }} {{ $rq->admin_note }}</div>
        @endif

        {{-- AKSI ADMIN --}}
        @if($rq->status === 'pending')
        <div class="flex flex-wrap gap-2 pt-1 border-t border-cream2">
            <form action="{{ route('admin.zakat-requests.verify', $rq) }}" method="POST">
                @csrf
                <button type="submit" class="bg-olive text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-olive2"><i class="fa-solid fa-check mr-1"></i>{{ __('Verifikasi') }}</button>
            </form>
            <button onclick="document.getElementById('reject{{ $rq->id }}').classList.toggle('hidden')" class="bg-red-50 text-red-500 text-xs font-semibold px-4 py-2 rounded-full border border-red-200 hover:bg-red-100"><i class="fa-solid fa-xmark mr-1"></i>{{ __('Tolak') }}</button>
        </div>
        <div id="reject{{ $rq->id }}" class="hidden mt-3">
            <form action="{{ route('admin.zakat-requests.reject', $rq) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input name="admin_note" placeholder="{{ __('Alasan penolakan (opsional)') }}" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                <button type="submit" class="bg-red-500 text-white text-xs font-semibold px-4 py-2 rounded-full">{{ __('Konfirmasi Tolak') }}</button>
            </form>
        </div>
        @elseif($rq->status === 'verified')
        <div class="border-t border-cream2 pt-3">
            <div class="mb-2 flex items-center gap-2 text-xs font-bold text-oliveDark"><i class="fa-solid fa-calculator text-olive"></i> {{ __('Kalkulator Waris — sesuaikan lalu hitung & kirim') }}</div>
            <form action="{{ route('admin.zakat-requests.calculate', $rq) }}" method="POST" class="space-y-3">
                @csrf
                <div class="bg-cream2/60 rounded-xl p-3 grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="col-span-2 sm:col-span-3 flex items-center gap-3">
                        <span class="text-[10px] font-semibold text-oliveDark">{{ __('Jenis Kelamin Pewaris:') }}</span>
                        <label class="flex items-center gap-1 text-[11px] text-oliveDark"><input type="radio" name="pewaris_jk" value="L" {{ ($w['pewaris_jk'] ?? 'L') === 'L' ? 'checked' : '' }} class="accent-olive"> {{ __('Laki-laki') }}</label>
                        <label class="flex items-center gap-1 text-[11px] text-oliveDark"><input type="radio" name="pewaris_jk" value="P" {{ ($w['pewaris_jk'] ?? '') === 'P' ? 'checked' : '' }} class="accent-olive"> {{ __('Perempuan') }}</label>
                    </div>
                    <div>
                        <label class="text-[10px] font-semibold text-oliveDark">{{ __('Total Harta (Rp)') }}</label>
                        <input type="hidden" name="total_harta" value="{{ $w['total_harta'] ?? 0 }}">
                        <input type="text" inputmode="numeric" data-name="total_harta" data-default="{{ $w['total_harta'] ?? 0 }}" required class="rupiah-display w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-semibold text-oliveDark">{{ __('Hutang (Rp)') }}</label>
                        <input type="hidden" name="hutang" value="{{ $w['hutang'] ?? 0 }}">
                        <input type="text" inputmode="numeric" data-name="hutang" data-default="{{ $w['hutang'] ?? 0 }}" class="rupiah-display w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-semibold text-oliveDark">{{ __('Biaya Pemakaman (Rp)') }}</label>
                        <input type="hidden" name="biaya_pemakaman" value="{{ $w['biaya_pemakaman'] ?? 0 }}">
                        <input type="text" inputmode="numeric" data-name="biaya_pemakaman" data-default="{{ $w['biaya_pemakaman'] ?? 0 }}" class="rupiah-display w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-semibold text-oliveDark">{{ __('Harta Sengketa (Rp)') }}</label>
                        <input type="hidden" name="harta_sengketa" value="{{ $w['harta_sengketa'] ?? 0 }}">
                        <input type="text" inputmode="numeric" data-name="harta_sengketa" data-default="{{ $w['harta_sengketa'] ?? 0 }}" class="rupiah-display w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white">
                    </div>
                    <div class="col-span-2 sm:col-span-3">
                        <label class="text-[10px] font-semibold text-oliveDark">{{ __('Alasan Harta Sengketa') }}</label>
                        <textarea name="sengketa_reason" rows="2" placeholder="{{ __('cth. tanah sedang digugat…') }}" class="w-full border border-cream3 rounded-xl px-3 py-1.5 text-xs bg-white">{{ $w['sengketa_alasan'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="bg-cream2/60 rounded-xl p-3 space-y-2">
                    <div class="text-xs font-bold text-oliveDark">{{ __('Ahli Waris') }}</div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[11px]">
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Anak L') }}</label><input name="jumlah_anak_l" type="number" min="0" value="{{ $w['jumlah_anak_l'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Anak P') }}</label><input name="jumlah_anak_p" type="number" min="0" value="{{ $w['jumlah_anak_p'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Cucu L') }}</label><input name="jumlah_cucu_l" type="number" min="0" value="{{ $w['jumlah_cucu_l'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Cucu P') }}</label><input name="jumlah_cucu_p" type="number" min="0" value="{{ $w['jumlah_cucu_p'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Saudara L') }}</label><input name="jumlah_saudara_l" type="number" min="0" value="{{ $w['jumlah_saudara_l'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Saudara P') }}</label><input name="jumlah_saudara_p" type="number" min="0" value="{{ $w['jumlah_saudara_p'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Saudara Seibu') }}</label><input name="jumlah_saudara_seibu" type="number" min="0" value="{{ $w['jumlah_saudara_seibu'] ?? 0 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                        <div><label class="text-[10px] text-olive/70 block">{{ __('Jumlah Istri') }}</label><input name="jumlah_istri" type="number" min="1" max="4" value="{{ $w['jumlah_istri'] ?? 1 }}" class="w-full border border-cream3 rounded-full px-2 py-1 text-xs bg-white"></div>
                    </div>
                    <div class="pt-1 border-t border-cream2 grid grid-cols-2 sm:grid-cols-4 gap-x-3 gap-y-1.5 text-[11px]">
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_ayah" value="1" {{ ($w['ada_ayah'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Ayah') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_ibu" value="1" {{ ($w['ada_ibu'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Ibu') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_kakek" value="1" {{ ($w['ada_kakek'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Kakek') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_nenek_ibu" value="1" {{ ($w['ada_nenek_ibu'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Nenek (ibu)') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_nenek_ayah" value="1" {{ ($w['ada_nenek_ayah'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Nenek (ayah)') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_istri" value="1" {{ ($w['ada_istri'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Istri') }}</label>
                        <label class="flex items-center gap-1.5 text-oliveDark"><input type="checkbox" name="ada_suami" value="1" {{ ($w['ada_suami'] ?? false) ? 'checked' : '' }} class="accent-olive"> {{ __('Suami') }}</label>
                    </div>
                </div>
                <input name="admin_note" placeholder="{{ __('Catatan untuk warga (opsional)') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                <button type="submit" class="w-full bg-olive text-white text-xs font-semibold px-4 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>{{ __('Hitung & Kirim Hasil') }}</button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-[20px] border border-cream3 p-10 text-center text-olive/40 text-sm">
        <i class="fa-solid fa-inbox text-3xl block mb-2 text-olive/30"></i>
        {{ __('Tidak ada pengajuan pada filter ini.') }}
    </div>
    @endforelse
</div>

@if($requests->hasPages())
<div class="mt-4">{{ $requests->links() }}</div>
@endif

<script>
document.querySelectorAll('.rupiah-display').forEach(function (d) {
    var form = d.closest('form');
    function target() { return form ? form.querySelector('input[name="' + d.dataset.name + '"]') : null; }
    function clean() { return String(d.value || '').replace(/[^0-9]/g, ''); }
    function render() {
        if (!d.dataset.seeded && d.dataset.default !== undefined) {
            d.dataset.seeded = '1';
            var def = String(d.dataset.default || '0').replace(/[^0-9]/g, '');
            if (def) {
                d.value = new Intl.NumberFormat('id-ID').format(parseInt(def, 10));
                var t = target(); if (t) t.value = def;
            }
        }
        var v = clean();
        d.value = v ? new Intl.NumberFormat('id-ID').format(parseInt(v, 10)) : '';
        var t = target(); if (t) t.value = v;
    }
    d.addEventListener('input', render);
    render();
});
</script>

@endsection
