@extends('layouts.dashboard')
@section('title',__('Ajukan Hitung Waris — E-Zakat'))
@section('page-title',__('Ajukan Minta Hitung Waris'))
@section('page-sub',__('Ajukan permohonan hitung waris Anda'))

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4" style="height:100%">

    {{-- FORM PENGAJUAN WARIS --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5" style="display:flex; flex-direction:column">
        <h3 class="font-bold text-oliveDark text-sm mb-1 flex items-center gap-2">
            <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-people-roof text-xs"></i></span>
            {{ __('Pengajuan Hitung Waris') }}
        </h3>
        <p class="text-[11px] text-olive/50 mb-4">{{ __('Isi data harta peninggalan dan ahli waris. Admin UPZ/BAZNAS akan memverifikasi lalu menghitung pembagian waris sesuai hukum Islam.') }}</p>

        

        @if($errors->any())
        <div class="mb-4 text-xs bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3"><i class="fa-solid fa-triangle-exclamation mr-1"></i>{{ __('Periksa kembali isian Anda.') }}</div>
        @endif

        <form method="POST" action="{{ route('user.zakat-request.store') }}" class="space-y-3" style="display:flex; flex-direction:column">
            @csrf

            <div style="padding-right:2px; padding-bottom:24px">
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Nama Pewaris / Almarhum *') }}</label>
                <input name="deceased_name" value="{{ old('deceased_name') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                @error('deceased_name')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Jenis Kelamin Pewaris *') }}</label>
                <div class="mt-1 grid grid-cols-2 gap-3">
                    <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="L" {{ old('pewaris_jk','L') === 'L' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white text-oliveDark border border-olive/40 hover:border-olive hover:bg-cream2 rounded-full py-2 text-center text-xs font-bold transition">{{ __('Laki-laki') }}</div></label>
                    <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="P" {{ old('pewaris_jk') === 'P' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white text-oliveDark border border-olive/40 hover:border-olive hover:bg-cream2 rounded-full py-2 text-center text-xs font-bold transition">{{ __('Perempuan') }}</div></label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Total Harta Warisan (Rp) *') }}</label>
                    <input type="hidden" name="total_harta" id="total_harta" value="{{ old('total_harta', 0) }}">
                    <input type="text" inputmode="numeric" data-target="total_harta" data-default="{{ old('total_harta', 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                    @error('total_harta')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Hutang Pewaris (Rp)') }}</label>
                    <input type="hidden" name="hutang" id="hutang" value="{{ old('hutang', 0) }}">
                    <input type="text" inputmode="numeric" data-target="hutang" data-default="{{ old('hutang', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Biaya Pemakaman (Rp)') }}</label>
                    <input type="hidden" name="biaya_pemakaman" id="biaya_pemakaman" value="{{ old('biaya_pemakaman', 0) }}">
                    <input type="text" inputmode="numeric" data-target="biaya_pemakaman" data-default="{{ old('biaya_pemakaman', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Wasiat (Rp)') }} <span class="font-normal text-olive/50">{{ __('(maks 1/3)') }}</span></label>
                    <input type="hidden" name="wasiat" id="wasiat" value="{{ old('wasiat', 0) }}">
                    <input type="text" inputmode="numeric" data-target="wasiat" data-default="{{ old('wasiat', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                </div>
                </div>

                <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Harta Sengketa (Rp)') }} <span class="font-normal text-olive/50">{{ __('(opsional)') }}</span></label>
                <input type="hidden" name="harta_sengketa" id="harta_sengketa" value="{{ old('harta_sengketa', 0) }}">
                <input type="text" inputmode="numeric" data-target="harta_sengketa" data-default="{{ old('harta_sengketa', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30 rupiah-display">
                <p class="text-[10px] text-olive/50 mt-1">{{ __('Harta yang masih disengketakan (mis. tanah sengketa)') }} <b>{{ __('tidak ikut dibagi') }}</b> {{ __('Jumlah ini otomatis dikeluarkan dari total.') }}</p>
                <div id="sengketaReasonWrap" style="display:none" class="mt-2">
                    <label class="text-[11px] font-semibold text-oliveDark">{{ __('Alasan / Penjelasan Harta Sengketa') }}</label>
                    <textarea name="sengketa_reason" rows="2" placeholder="{{ __('Contoh: tanah warisan sedang digugat keluarga lain…') }}" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">{{ old('sengketa_reason') }}</textarea>
                    @error('sengketa_reason')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>
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
                    @php $cek = ['ada_ayah'=>'Ayah','ada_ibu'=>'Ibu','ada_kakek'=>'Kakek','ada_nenek_ibu'=>'Nenek (dari ibu)','ada_istri'=>'Istri','ada_nenek_ayah'=>'Nenek (dari ayah)','ada_suami'=>'Suami']; @endphp
                    @foreach($cek as $key => $label)
                    <div>
                        <label class="flex items-center gap-2 text-oliveDark cursor-pointer">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ old($key) ? 'checked' : '' }} class="accent-olive w-4 h-4">
                            <span>{{ $label }}</span>
                        </label>
                        @if($key === 'ada_istri')
                        <div id="jmlIstriWrap" class="mt-1.5 flex items-center gap-2" style="display:none">
                            <span class="text-[11px] font-semibold text-oliveDark whitespace-nowrap">{{ __('Jumlah Istri') }}</span>
                            <input type="number" name="jumlah_istri" value="{{ old('jumlah_istri', 2) }}" min="1" max="4" class="w-16 border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white outline-none text-center">
                            <span class="text-[10px] text-olive/50 whitespace-nowrap">{{ __('(maks 4)') }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>


            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Keterangan / Catatan (mis. ada tanah sengketa, dll.)') }}</label>
                <textarea name="description" rows="3" placeholder="{{ __('Contoh: ada tanah warisan yang masih sengketa, belum bisa dibagi…') }}" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">{{ old('description') }}</textarea>
                @error('description')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            </div>
            <button type="submit" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md" style="flex-shrink:0"><i class="fa-solid fa-paper-plane mr-2"></i>{{ __('Ajukan Pengajuan') }}</button>
        </form>

        <script>
        (function () {
            var cb = document.querySelector('input[name="ada_istri"]');
            var wrap = document.getElementById('jmlIstriWrap');
            if (cb && wrap) {
                wrap.style.display = cb.checked ? 'flex' : 'none';
                cb.addEventListener('change', function () {
                    wrap.style.display = cb.checked ? 'flex' : 'none';
                });
            }

            // Tampilkan pasangan sesuai jenis kelamin pewaris:
            // istri (bisa berjumlah) untuk L, suami (tunggal) untuk P
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
            document.querySelectorAll('input[name="pewaris_jk"]').forEach(function (r) {
                r.addEventListener('change', updatePasanganForm);
            });
            updatePasanganForm();

            // Format Rupiah utk field nominal
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
                    // seed awal dari data-default bila masih kosong
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
    </div>

    {{-- DAFTAR PENGAJUAN SAYA --}}
    <div class="space-y-3" style="height:100%; display:flex; flex-direction:column; min-height:0">
        <div class="bg-white rounded-[20px] border border-cream3 p-5" style="flex:1 1 0%; min-height:0; overflow-y:auto; overscroll-behavior:contain; padding-bottom:72px">
            <h3 class="font-bold text-oliveDark text-sm mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-list-check text-xs"></i></span>
                {{ __('Pengajuan Saya') }}
            </h3>

            @forelse($requests as $rq)
            <div class="border border-cream3 rounded-2xl p-4 mb-3 bg-cream2/40">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-bold text-oliveDark">
                        @if($rq->status === 'done')
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full">✓ Selesai</span>
                        @elseif($rq->status === 'rejected')
                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full">✕ Ditolak</span>
                        @elseif($rq->status === 'verified')
                        <span class="bg-sky-100 text-sky-700 text-[10px] font-bold px-2.5 py-1 rounded-full">Terverifikasi</span>
                        @else
                        <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ __('⏳ Menunggu Verifikasi') }}</span>
                        @endif
                    </span>
                    <span class="text-[10px] text-olive/50">{{ $rq->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>

                <div class="text-[11px] text-oliveDark mb-2"><i class="fa-solid fa-user-xmark mr-1 text-olive"></i>{{ __('Pewaris:') }} <b>{{ $rq->deceased_name ?? $rq->full_name }}</b></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-2 text-[11px]">
                    <div><span class="text-olive/50 block">{{ __('Harta warisan') }}</span><b class="text-oliveDark block">Rp {{ number_format($rq->waris_data['total_harta'] ?? $rq->total_assets, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50 block">{{ __('Hutang') }}</span><b class="text-oliveDark block">Rp {{ number_format($rq->waris_data['hutang'] ?? $rq->debt_amount, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50 block">{{ __('Biaya pemakaman') }}</span><b class="text-oliveDark block">Rp {{ number_format($rq->waris_data['biaya_pemakaman'] ?? 0, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50 block">{{ __('Wasiat') }}</span><b class="text-oliveDark block">Rp {{ number_format($rq->waris_data['wasiat'] ?? 0, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50 block">{{ __('Harta sengketa') }}</span><b class="text-oliveDark block">Rp {{ number_format($rq->waris_data['harta_sengketa'] ?? 0, 0, ',', '.') }}</b></div>
                </div>

                @if($rq->description)
                <div class="mt-2 text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2"><i class="fa-solid fa-note-sticky mr-1 text-olive"></i>{{ $rq->description }}</div>
                @endif

                @if(!empty($rq->waris_data['sengketa_alasan']))
                <div class="mt-2 text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2"><i class="fa-solid fa-triangle-exclamation mr-1 text-red-500"></i>{{ __('Alasan sengketa:') }} {{ $rq->waris_data['sengketa_alasan'] }}</div>
                @endif

                @if($rq->admin_note)
                <div class="mt-2 text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2"><i class="fa-solid fa-comment mr-1 text-olive"></i>Catatan admin: {{ $rq->admin_note }}</div>
                @endif

                @if($rq->status === 'done' && !empty($rq->waris_data) && !empty($rq->calculation_detail))
                <div class="mt-3 bg-olive rounded-2xl p-4 text-white">
                    <div class="text-[10px] uppercase tracking-wider text-cream/70">{{ __('Hasil Pembagian Waris') }}</div>
                    <div class="text-2xl font-black mt-1">Rp {{ number_format($rq->calculated_amount, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-cream/70 mt-0.5">{{ __('Harta bersih yang dibagikan') }}</div>

                    @php $detail = is_array($rq->calculation_detail) ? $rq->calculation_detail : []; $hasil = is_array($detail['hasil'] ?? null) ? $detail['hasil'] : []; @endphp
                    @if(!empty($detail['potongan']) && is_array($detail['potongan']) && ($detail['potongan']['total'] ?? 0) > 0)
                    <div class="mt-3 space-y-0.5 text-[11px] text-cream/80 border-t border-white/15 pt-2">
                        @if(($detail['hartaSengketa'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Harta sengketa') }}</span><b>Rp {{ number_format($detail['hartaSengketa'], 0, ',', '.') }}</b></div>@endif
                        <div class="flex justify-between gap-2"><span>{{ __('Harta warisan') }}</span><b>Rp {{ number_format($detail['totalHarta'] ?? 0, 0, ',', '.') }}</b></div>
                        @if(($detail['potongan']['hutang'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Hutang') }}</span><b>Rp {{ number_format($detail['potongan']['hutang'], 0, ',', '.') }}</b></div>@endif
                        @if(($detail['potongan']['biaya_pemakaman'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Biaya pemakaman') }}</span><b>Rp {{ number_format($detail['potongan']['biaya_pemakaman'], 0, ',', '.') }}</b></div>@endif
                        @if(($detail['potongan']['wasiat'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>{{ __('− Wasiat') }}</span><b>Rp {{ number_format($detail['potongan']['wasiat'], 0, ',', '.') }}</b></div>@endif
                        <div class="flex justify-between gap-2 font-bold"><span>{{ __('Harta bersih') }}</span><b>Rp {{ number_format($detail['hartaBersih'] ?? $rq->calculated_amount, 0, ',', '.') }}</b></div>
                    </div>
                    @endif

                    @if(!empty($hasil))
                    <div class="mt-3 border-t border-white/15 pt-2 space-y-2">
                        @foreach($hasil as $h)
                        @php $m = preg_match('/^(.+?)\s*\((\d+)\)$/', $h['ahli'] ?? '', $mm); @endphp
                        @if($m)
                            @php $n = (int)$mm[2]; $nilai = ($h['nilai'] ?? 0)/$n; $persen = ($h['persen'] ?? 0)/$n; $porsi = ($h['porsi'] ?? 0)/$n; @endphp
                            @for($i=1; $i<=$n; $i++)
                            <div class="flex items-center justify-between gap-2 border-b border-white/10 pb-1.5">
                                <div><div class="font-bold text-xs">{{ $mm[1] }}@if($n>1) #{{ $i }}@endif</div><div class="text-[10px] text-cream/70">{{ number_format($persen, 2) }}% · {{ __('porsi') }} {{ number_format($porsi*24, 2) }}/24</div></div>
                                <div class="text-right font-black text-sm">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
                            </div>
                            @endfor
                        @else
                            <div class="flex items-center justify-between gap-2 border-b border-white/10 pb-1.5">
                                <div><div class="font-bold text-xs">{{ $h['ahli'] }}</div><div class="text-[10px] text-cream/70">{{ number_format($h['persen'] ?? 0, 2) }}% · {{ __('porsi') }} {{ number_format(($h['porsi'] ?? 0)*24, 2) }}/24</div></div>
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

                <form action="{{ route('user.zakat-request.destroy', $rq) }}" method="POST" class="mt-3 text-right" onsubmit="event.preventDefault()">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-title="{{ __('Hapus') }}" data-message="{{ __('Hapus pengajuan ini?') }}" data-action="{{ route('user.zakat-request.destroy', $rq) }}" class="text-[11px] font-semibold text-red-700 bg-red-100 hover:bg-red-200 border border-red-200 rounded-full px-3 py-1 transition" onclick="event.preventDefault(); confirmDelete({ title: this.dataset.title, message: this.dataset.message, action: this.dataset.action })"><i class="fa-solid fa-trash-can mr-1"></i>{{ __('Hapus') }}</button>
                </form>
            </div>
            @empty
            <div class="text-center text-olive/40 text-xs py-8">
                <i class="fa-solid fa-inbox text-2xl block mb-2 text-olive/30"></i>
                {{ __('Belum ada pengajuan waris.') }}
            </div>
            @endforelse

            @if($requests->hasPages())
            <div class="mt-2">{{ $requests->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
