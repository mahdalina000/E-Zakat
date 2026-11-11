@extends('layouts.dashboard')
@section('title','Ajukan Hitung Waris — E-Zakat')
@section('page-title','Ajukan Minta Hitung Waris')
@section('page-sub','Sampaikan harta peninggalan & ahli waris, admin akan memverifikasi lalu menghitung pembagian waris Anda')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4" style="height:100%">

    {{-- FORM PENGAJUAN WARIS --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5" style="height:100%; display:flex; flex-direction:column; min-height:0">
        <h3 class="font-bold text-oliveDark text-sm mb-1 flex items-center gap-2">
            <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-people-roof text-xs"></i></span>
            Pengajuan Hitung Waris
        </h3>
        <p class="text-[11px] text-olive/50 mb-4">Isi data harta peninggalan dan ahli waris. Admin UPZ/BAZNAS akan memverifikasi lalu menghitung pembagian waris sesuai hukum Islam.</p>

        @if(session('success'))
        <div class="mb-4 text-xs bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3"><i class="fa-solid fa-circle-check mr-1"></i>{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="mb-4 text-xs bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Periksa kembali isian Anda.</div>
        @endif

        <form method="POST" action="{{ route('user.zakat-request.store') }}" class="space-y-3" style="display:flex; flex-direction:column; flex:1 1 0%; min-height:0">
            @csrf

            <div style="flex:1 1 0%; min-height:0; overflow-y:auto; overscroll-behavior:contain; padding-right:2px; padding-bottom:24px">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Nama Pewaris / Almarhum *</label>
                <input name="deceased_name" value="{{ old('deceased_name') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                @error('deceased_name')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark">Jenis Kelamin Pewaris *</label>
                <div class="mt-1 grid grid-cols-2 gap-3">
                    <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="L" {{ old('pewaris_jk','L') === 'L' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-white text-oliveDark border border-cream3 rounded-full py-2 text-center text-xs font-bold">Laki-laki</div></label>
                    <label class="cursor-pointer"><input type="radio" name="pewaris_jk" value="P" {{ old('pewaris_jk') === 'P' ? 'checked' : '' }} class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-white text-oliveDark border border-cream3 rounded-full py-2 text-center text-xs font-bold">Perempuan</div></label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Total Harta Warisan (Rp) *</label>
                    <input name="total_harta" type="number" min="0" value="{{ old('total_harta', 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                    @error('total_harta')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Hutang Pewaris (Rp)</label>
                    <input name="hutang" type="number" min="0" value="{{ old('hutang', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Biaya Pemakaman (Rp)</label>
                    <input name="biaya_pemakaman" type="number" min="0" value="{{ old('biaya_pemakaman', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Wasiat (Rp) <span class="font-normal text-olive/50">(maks 1/3)</span></label>
                    <input name="wasiat" type="number" min="0" value="{{ old('wasiat', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                </div>
                </div>

                <div>
                <label class="text-xs font-semibold text-oliveDark">Harta Sengketa (Rp) <span class="font-normal text-olive/50">(opsional)</span></label>
                <input name="harta_sengketa" type="number" min="0" value="{{ old('harta_sengketa', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">
                <p class="text-[10px] text-olive/50 mt-1">Harta yang masih disengketakan (mis. tanah sengketa) <b>tidak ikut dibagi</b>. Jumlah ini otomatis dikeluarkan dari total.</p>
                </div>

                <div class="bg-cream2/60 rounded-2xl p-3 space-y-2">
                <div class="text-xs font-bold text-oliveDark">Ahli Waris</div>

                <div class="grid grid-cols-2 gap-3">
                    <div><label class="text-[11px] text-olive/70">Anak laki-laki</label><input name="jumlah_anak_l" type="number" min="0" max="100" value="{{ old('jumlah_anak_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">Anak perempuan</label><input name="jumlah_anak_p" type="number" min="0" max="100" value="{{ old('jumlah_anak_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">Cucu laki-laki</label><input name="jumlah_cucu_l" type="number" min="0" max="100" value="{{ old('jumlah_cucu_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">Cucu perempuan</label><input name="jumlah_cucu_p" type="number" min="0" max="100" value="{{ old('jumlah_cucu_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">Saudara kandung laki-laki</label><input name="jumlah_saudara_l" type="number" min="0" max="100" value="{{ old('jumlah_saudara_l', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div><label class="text-[11px] text-olive/70">Saudara kandung perempuan</label><input name="jumlah_saudara_p" type="number" min="0" max="100" value="{{ old('jumlah_saudara_p', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
                    <div class="col-span-2"><label class="text-[11px] text-olive/70">Saudara seibu</label><input name="jumlah_saudara_seibu" type="number" min="0" max="100" value="{{ old('jumlah_saudara_seibu', 0) }}" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-olive/30"></div>
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
                    <span class="text-[11px] font-semibold text-oliveDark">Jumlah Istri</span>
                    <input type="number" name="jumlah_istri" value="{{ old('jumlah_istri', 2) }}" min="1" max="4" class="w-16 border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white outline-none text-center">
                    <span class="text-[10px] text-olive/50">(maks 4)</span>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark">Keterangan / Catatan (mis. ada tanah sengketa, dll.)</label>
                <textarea name="description" rows="3" placeholder="Contoh: ada tanah warisan yang masih sengketa, belum bisa dibagi…" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2 text-xs bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/30">{{ old('description') }}</textarea>
                @error('description')<div class="text-[10px] text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            </div>
            <button type="submit" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md" style="flex-shrink:0"><i class="fa-solid fa-paper-plane mr-2"></i>Ajukan Pengajuan</button>
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
        })();
        </script>
    </div>

    {{-- DAFTAR PENGAJUAN SAYA --}}
    <div class="space-y-3" style="height:100%; display:flex; flex-direction:column; min-height:0">
        <div class="bg-white rounded-[20px] border border-cream3 p-5" style="flex:1 1 0%; min-height:0; overflow-y:auto; overscroll-behavior:contain; padding-bottom:72px">
            <h3 class="font-bold text-oliveDark text-sm mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center"><i class="fa-solid fa-list-check text-xs"></i></span>
                Pengajuan Saya
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
                        <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full">⏳ Menunggu Verifikasi</span>
                        @endif
                    </span>
                    <span class="text-[10px] text-olive/50">{{ $rq->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>

                <div class="text-[11px] text-oliveDark mb-2"><i class="fa-solid fa-user-xmark mr-1 text-olive"></i>Pewaris: <b>{{ $rq->deceased_name ?? $rq->full_name }}</b></div>

                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div><span class="text-olive/50">Harta warisan:</span> <b class="text-oliveDark">Rp {{ number_format($rq->waris_data['total_harta'] ?? $rq->total_assets, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50">Hutang:</span> <b class="text-oliveDark">Rp {{ number_format($rq->waris_data['hutang'] ?? $rq->debt_amount, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50">Biaya pemakaman:</span> <b class="text-oliveDark">Rp {{ number_format($rq->waris_data['biaya_pemakaman'] ?? 0, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50">Wasiat:</span> <b class="text-oliveDark">Rp {{ number_format($rq->waris_data['wasiat'] ?? 0, 0, ',', '.') }}</b></div>
                    <div><span class="text-olive/50">Harta sengketa:</span> <b class="text-oliveDark">Rp {{ number_format($rq->waris_data['harta_sengketa'] ?? 0, 0, ',', '.') }}</b></div>
                </div>

                @if($rq->description)
                <div class="mt-2 text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2"><i class="fa-solid fa-note-sticky mr-1 text-olive"></i>{{ $rq->description }}</div>
                @endif

                @if($rq->admin_note)
                <div class="mt-2 text-[11px] text-olive/70 bg-white border border-cream3 rounded-xl px-3 py-2"><i class="fa-solid fa-comment mr-1 text-olive"></i>Catatan admin: {{ $rq->admin_note }}</div>
                @endif

                @if($rq->status === 'done' && !empty($rq->waris_data) && !empty($rq->calculation_detail))
                <div class="mt-3 bg-olive rounded-2xl p-4 text-white">
                    <div class="text-[10px] uppercase tracking-wider text-cream/70">Hasil Pembagian Waris</div>
                    <div class="text-2xl font-black mt-1">Rp {{ number_format($rq->calculated_amount, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-cream/70 mt-0.5">Harta bersih yang dibagikan</div>

                    @php $detail = is_array($rq->calculation_detail) ? $rq->calculation_detail : []; $hasil = is_array($detail['hasil'] ?? null) ? $detail['hasil'] : []; @endphp
                    @if(!empty($detail['potongan']) && is_array($detail['potongan']) && ($detail['potongan']['total'] ?? 0) > 0)
                    <div class="mt-3 space-y-0.5 text-[11px] text-cream/80 border-t border-white/15 pt-2">
                        @if(($detail['hartaSengketa'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Harta sengketa</span><b>Rp {{ number_format($detail['hartaSengketa'], 0, ',', '.') }}</b></div>@endif
                        <div class="flex justify-between gap-2"><span>Harta warisan</span><b>Rp {{ number_format($detail['totalHarta'] ?? 0, 0, ',', '.') }}</b></div>
                        @if(($detail['potongan']['hutang'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Hutang</span><b>Rp {{ number_format($detail['potongan']['hutang'], 0, ',', '.') }}</b></div>@endif
                        @if(($detail['potongan']['biaya_pemakaman'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Biaya pemakaman</span><b>Rp {{ number_format($detail['potongan']['biaya_pemakaman'], 0, ',', '.') }}</b></div>@endif
                        @if(($detail['potongan']['wasiat'] ?? 0) > 0)<div class="flex justify-between gap-2"><span>− Wasiat</span><b>Rp {{ number_format($detail['potongan']['wasiat'], 0, ',', '.') }}</b></div>@endif
                        <div class="flex justify-between gap-2 font-bold"><span>Harta bersih</span><b>Rp {{ number_format($detail['hartaBersih'] ?? $rq->calculated_amount, 0, ',', '.') }}</b></div>
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
                                <div><div class="font-bold text-xs">{{ $mm[1] }} #{{ $i }}</div><div class="text-[10px] text-cream/70">{{ number_format($persen, 2) }}% · porsi {{ number_format($porsi*24, 2) }}/24</div></div>
                                <div class="text-right font-black text-sm">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
                            </div>
                            @endfor
                        @else
                            <div class="flex items-center justify-between gap-2 border-b border-white/10 pb-1.5">
                                <div><div class="font-bold text-xs">{{ $h['ahli'] }}</div><div class="text-[10px] text-cream/70">{{ number_format($h['persen'] ?? 0, 2) }}% · porsi {{ number_format(($h['porsi'] ?? 0)*24, 2) }}/24</div></div>
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

                <form action="{{ route('user.zakat-request.destroy', $rq) }}" method="POST" class="mt-3 text-right" onsubmit="return confirm('Hapus pengajuan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[11px] font-semibold text-red-700 bg-red-100 hover:bg-red-200 border border-red-200 rounded-full px-3 py-1 transition"><i class="fa-solid fa-trash-can mr-1"></i>Hapus</button>
                </form>
            </div>
            @empty
            <div class="text-center text-olive/40 text-xs py-8">
                <i class="fa-solid fa-inbox text-2xl block mb-2 text-olive/30"></i>
                Belum ada pengajuan waris.
            </div>
            @endforelse

            @if($requests->hasPages())
            <div class="mt-2">{{ $requests->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
