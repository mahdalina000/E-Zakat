@extends('layouts.dashboard')
@section('title', __('Kalkulator Waris Admin — E-Zakat'))
@section('page-title', __('Kalkulator Waris (Admin)'))
@section('page-sub', __('Petugas dapat menginput data harta & ahli waris lalu menghitung sendiri, agar bisa menjelaskan pembagian & bagian sengketa kepada masyarakat.'))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4" style="height:100%">

    {{-- FORM --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5" style="height:100%; display:flex; flex-direction:column; min-height:0">
        <h3 class="font-bold text-oliveDark text-sm mb-1 flex items-center gap-2">
            <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-calculator text-xs"></i></span>
            {{ __('Input Data Waris') }}
        </h3>
        <p class="text-[11px] text-olive/50 mb-4">{{ __('Isi nominal dengan titik ribuan (cth. 100.000.000).') }}</p>

        <form method="POST" action="{{ route('admin.waris-calculator') }}" class="space-y-3" style="display:flex; flex-direction:column; flex:1 1 0%; min-height:0">
            @csrf
            <div style="flex:1 1 0%; min-height:0; overflow-y:auto; overscroll-behavior:contain; padding-right:2px; padding-bottom:24px">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Total Harta (Rp)') }} *</label>
                    <input type="hidden" name="total_harta" id="total_harta" value="{{ old('total_harta', 0) }}">
                    <input type="text" inputmode="numeric" data-target="total_harta" data-default="{{ old('total_harta', 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                    @error('total_harta')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Jenis Kelamin Pewaris') }} *</label>
                    <div class="mt-1 grid grid-cols-2 gap-2">
                        <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="L" {{ old('pewaris_jk','L') === 'L' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-white text-oliveDark border border-cream3 rounded-full py-2 text-center text-xs font-bold">{{ __('Laki-laki') }}</div></label>
                        <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="P" {{ old('pewaris_jk') === 'P' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-white text-oliveDark border border-cream3 rounded-full py-2 text-center text-xs font-bold">{{ __('Perempuan') }}</div></label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Hutang Pewaris (Rp)') }}</label>
                    <input type="hidden" name="hutang" id="hutang" value="{{ old('hutang', 0) }}">
                    <input type="text" inputmode="numeric" data-target="hutang" data-default="{{ old('hutang', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Biaya Pemakaman (Rp)') }}</label>
                    <input type="hidden" name="biaya_pemakaman" id="biaya_pemakaman" value="{{ old('biaya_pemakaman', 0) }}">
                    <input type="text" inputmode="numeric" data-target="biaya_pemakaman" data-default="{{ old('biaya_pemakaman', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Harta Sengketa (Rp)') }} <span class="font-normal text-olive/50">{{ __('(opsional)') }}</span></label>
                    <input type="hidden" name="harta_sengketa" id="harta_sengketa" value="{{ old('harta_sengketa', 0) }}">
                    <input type="text" inputmode="numeric" data-target="harta_sengketa" data-default="{{ old('harta_sengketa', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
            </div>

            <div id="sengketaReasonWrap" style="display:none" class="mt-2">
                <label class="text-[11px] font-semibold text-oliveDark">{{ __('Alasan / Penjelasan Harta Sengketa') }}</label>
                <textarea name="sengketa_reason" rows="2" placeholder="{{ __('Contoh: tanah warisan sedang digugat keluarga lain…') }}" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">{{ old('sengketa_reason') }}</textarea>
            </div>

            <div class="bg-cream2/60 rounded-2xl p-3 space-y-2">
                <div class="text-xs font-bold text-oliveDark">{{ __('Ahli Waris') }}</div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="text-[11px] text-olive/70">{{ __('Anak laki-laki') }}</label><input name="jumlah_anak_l" type="number" min="0" max="100" value="{{ old('jumlah_anak_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">{{ __('Anak perempuan') }}</label><input name="jumlah_anak_p" type="number" min="0" max="100" value="{{ old('jumlah_anak_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">{{ __('Cucu laki-laki') }}</label><input name="jumlah_cucu_l" type="number" min="0" max="100" value="{{ old('jumlah_cucu_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">{{ __('Cucu perempuan') }}</label><input name="jumlah_cucu_p" type="number" min="0" max="100" value="{{ old('jumlah_cucu_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">{{ __('Saudara kandung laki-laki') }}</label><input name="jumlah_saudara_l" type="number" min="0" max="100" value="{{ old('jumlah_saudara_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">{{ __('Saudara kandung perempuan') }}</label><input name="jumlah_saudara_p" type="number" min="0" max="100" value="{{ old('jumlah_saudara_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div class="col-span-2"><label class="text-[11px] text-olive/70">{{ __('Saudara seibu') }}</label><input name="jumlah_saudara_seibu" type="number" min="0" max="100" value="{{ old('jumlah_saudara_seibu', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                </div>
                <div class="grid grid-cols-2 gap-x-3 gap-y-1.5 pt-1 text-[11px]">
                    @php $cek = ['ada_ayah'=>'Ayah','ada_ibu'=>'Ibu','ada_kakek'=>'Kakek','ada_nenek_ibu'=>'Nenek (dari ibu)','ada_nenek_ayah'=>'Nenek (dari ayah)','ada_istri'=>'Istri','ada_suami'=>'Suami']; @endphp
                    @foreach($cek as $key => $label)
                    <label class="flex items-center gap-2 text-oliveDark cursor-pointer">
                        <input type="checkbox" name="{{ $key }}" value="1" {{ old($key) ? 'checked' : '' }} class="accent-olive w-4 h-4">
                        <span>{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div id="jmlIstriWrap" class="mt-2 flex items-center gap-2" style="display:none">
                    <span class="text-[11px] font-semibold text-oliveDark">{{ __('Jumlah Istri') }}</span>
                    <input type="number" name="jumlah_istri" value="{{ old('jumlah_istri', 2) }}" min="1" max="4" class="w-16 border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white outline-none text-center">
                    <span class="text-[10px] text-olive/50">{{ __('(maks 4)') }}</span>
                </div>
            </div>

            </div>
            <button type="submit" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md" style="flex-shrink:0"><i class="fa-solid fa-calculator mr-2"></i>{{ __('Hitung Waris') }}</button>
        </form>
    </div>

    {{-- HASIL --}}
    <div class="space-y-3" style="height:100%; display:flex; flex-direction:column; min-height:0">
        <div class="bg-white rounded-[20px] border border-cream3 p-5" style="flex:1 1 0%; min-height:0; overflow-y:auto; overscroll-behavior:contain; padding-bottom:72px">
            <h3 class="font-bold text-oliveDark text-sm mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-list-check text-xs"></i></span>
                {{ __('Hasil Perhitungan') }}
            </h3>

            @if(!$result)
            <div class="text-center text-olive/40 text-xs py-8">
                <i class="fa-solid fa-calculator text-2xl block mb-2 text-olive/30"></i>
                {{ __('Belum ada perhitungan. Isi data di kolom kiri lalu tekan "Hitung Waris".') }}
            </div>
            @else
                @php $detail = $result; $hasil = is_array($detail['hasil'] ?? null) ? $detail['hasil'] : []; @endphp

                @if($summary['harta_sengketa'] > 0)
                <div class="mb-3 text-[11px] text-red-600 bg-red-50 border border-red-200 rounded-xl px-3 py-2">
                    <b>{{ __('Harta sengketa:') }}</b> Rp {{ number_format($summary['harta_sengketa'], 0, ',', '.') }} — <b>{{ __('tidak dibagikan') }}</b>.
                    @if(!empty($summary['sengketa_alasan']))<div class="mt-1 text-red-500">{{ $summary['sengketa_alasan'] }}</div>@endif
                </div>
                @endif

                <div class="bg-olive rounded-2xl p-4 text-white">
                    <div class="text-[10px] uppercase tracking-wider text-cream/70">{{ __('Hasil Pembagian Waris') }}</div>
                    <div class="text-2xl font-black mt-1">Rp {{ number_format($detail['hartaBersih'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-cream/70 mt-0.5">{{ __('Harta bersih yang dibagikan') }}</div>

                    <div class="mt-3 space-y-0.5 text-[11px] text-cream/80 border-t border-white/15 pt-2">
                        <div class="flex justify-between gap-2"><span>{{ __('Harta warisan') }}</span><b>Rp {{ number_format($detail['totalHartaAsli'] ?? 0, 0, ',', '.') }}</b></div>
                        @if(($summary['harta_sengketa'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Harta sengketa') }}</span><b>Rp {{ number_format($summary['harta_sengketa'], 0, ',', '.') }}</b></div>@endif
                        @if(($summary['hutang'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Hutang') }}</span><b>Rp {{ number_format($summary['hutang'], 0, ',', '.') }}</b></div>@endif
                        @if(($summary['biaya_pemakaman'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Biaya pemakaman') }}</span><b>Rp {{ number_format($summary['biaya_pemakaman'], 0, ',', '.') }}</b></div>@endif
                        <div class="flex justify-between gap-2 font-bold"><span>{{ __('Harta bersih') }}</span><b>Rp {{ number_format($detail['hartaBersih'] ?? 0, 0, ',', '.') }}</b></div>
                    </div>
                </div>

                @if(!empty($hasil))
                <div class="mt-3 border border-cream3 rounded-2xl divide-y divide-cream3 overflow-hidden">
                    @foreach($hasil as $h)
                    @php $m = preg_match('/^(.+?)\s*\((\d+)\)$/', $h['ahli'] ?? '', $mm); @endphp
                    @if($m)
                        @php $n = (int)$mm[2]; $nilai = ($h['nilai'] ?? 0)/$n; $persen = ($h['persen'] ?? 0)/$n; $porsi = ($h['porsi'] ?? 0)/$n; @endphp
                        @for($i=1; $i<=$n; $i++)
                        <div class="px-4 py-3 flex items-center justify-between gap-2">
                            <div><div class="font-bold text-oliveDark text-xs">{{ $mm[1] }}@if($n>1) #{{ $i }}@endif</div><div class="text-[10px] text-olive/50">{{ number_format($persen, 2) }}% {{ __('· porsi') }} {{ number_format($porsi*24, 2) }}/24</div></div>
                            <div class="text-right font-black text-oliveDark text-sm">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
                        </div>
                        @endfor
                    @else
                        <div class="px-4 py-3 flex items-center justify-between gap-2">
                            <div><div class="font-bold text-oliveDark text-xs">{{ $h['ahli'] }}</div><div class="text-[10px] text-olive/50">{{ number_format($h['persen'] ?? 0, 2) }}% {{ __('· porsi') }} {{ number_format(($h['porsi'] ?? 0)*24, 2) }}/24</div></div>
                            <div class="text-right font-black text-oliveDark text-sm">Rp {{ number_format($h['nilai'] ?? 0, 0, ',', '.') }}</div>
                        </div>
                    @endif
                    @endforeach
                </div>
                @endif

                @if(!empty($detail['keterangan']) && is_array($detail['keterangan']))
                <div class="mt-3 border border-cream3 rounded-2xl bg-cream2/40 px-4 py-3 text-[10px] text-olive/70 space-y-1">
                    @foreach($detail['keterangan'] as $k)<div>• {{ $k }}</div>@endforeach
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var cb = document.querySelector('input[name="ada_istri"]');
    var wrap = document.getElementById('jmlIstriWrap');
    if (cb && wrap) {
        wrap.style.display = cb.checked ? 'flex' : 'none';
        cb.addEventListener('change', function () { wrap.style.display = cb.checked ? 'flex' : 'none'; });
    }
    function updatePasanganForm() {
        var jk = document.querySelector('input[name="pewaris_jk"]:checked');
        if (!jk) return;
        var L = jk.value === 'L';
        var istri = document.querySelector('input[name="ada_istri"]');
        var suami = document.querySelector('input[name="ada_suami"]');
        if (istri) istri.closest('label').style.display = L ? '' : 'none';
        if (suami) suami.closest('label').style.display = L ? 'none' : '';
        if (wrap && !L) wrap.style.display = 'none';
    }
    document.querySelectorAll('input[name="pewaris_jk"]').forEach(function (r) { r.addEventListener('change', updatePasanganForm); });
    updatePasanganForm();

    document.querySelectorAll('.rupiah-display').forEach(function (d) {
        var target = document.getElementById(d.dataset.target);
        function clean() { return String(d.value || '').replace(/[^0-9]/g, ''); }
        function syncReason() {
            var wr = document.getElementById('sengketaReasonWrap');
            var hs = document.getElementById('harta_sengketa');
            if (wr && hs && parseInt(hs.value || '0', 10) > 0) wr.style.display = 'block';
            else if (wr) wr.style.display = 'none';
        }
        function render() {
            if (!d.dataset.seeded && d.dataset.default !== undefined) {
                d.dataset.seeded = '1';
                var def = String(d.dataset.default || '0').replace(/[^0-9]/g, '');
                if (def) {
                    d.value = new Intl.NumberFormat('id-ID').format(parseInt(def, 10));
                    if (target) target.value = def;
                }
            }
            var v = clean();
            d.value = v ? new Intl.NumberFormat('id-ID').format(parseInt(v, 10)) : '';
            if (target) target.value = v;
            syncReason();
        }
        d.addEventListener('input', render);
        render();
    });
})();
</script>
@endsection
