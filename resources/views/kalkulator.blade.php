@extends('layouts.app')
@section('title','Kalkulator Zakat & Fidyah — E-Zakat Banjarbaru')

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 w-full">
    <!-- HEADER TAB TIPE ZAKAT -->
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] p-5 lg:p-6 border border-cream3 shadow-xl anim-smooth delay-1 hover-smooth">
        <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
            <i class="fa-solid fa-calculator text-olive"></i> Kalkulator Zakat & Fidyah
        </h1>
        <p class="text-xs lg:text-sm text-olive/70 mt-1 font-medium">Pilih jenis zakat, atur jumlah, dan lihat hasil perhitungan secara otomatis. Harga beras dapat disesuaikan.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button data-tab="fitrah" class="tab-btn bg-olive text-white px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow transition active:scale-95">Zakat Fitrah</button>
            <button data-tab="maal" class="tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95">Zakat Maal</button>
            <button data-tab="fidyah" class="tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95">Fidyah</button>
        </div>
    </div>

    {{-- FITRAH --}}
    <div id="panel-fitrah" class="tab-panel mt-6 anim-smooth delay-2">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl hover-smooth">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-wheat-awn text-olive"></i> Zakat Fitrah</h2>
                <p class="text-xs text-olive/70 mt-1">Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran: 2,5 kg beras atau 3,5 liter / jiwa (1 sha').</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jumlah Jiwa</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fitrahMinus" class="w-10 h-10 rounded-full bg-cream2 border border-cream3 text-olive font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fitrahJiwa" type="number" min="1" value="1" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-cream2">
                    <button id="fitrahPlus" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jenis Beras</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="banjar" checked class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream2 border border-cream3 rounded-2xl p-3 text-center transition shadow-sm">
                            <div class="text-xs font-extrabold">Beras Banjar</div>
                            <div class="text-[10px] opacity-80">Premium lokal</div>
                            <div class="text-xs mt-1 font-bold">Rp <span id="labelBanjar">{{ number_format($hargaBeras ?? 16000,0,',','.') }}</span> / kg</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="lain" class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream2 border border-cream3 rounded-2xl p-3 text-center transition shadow-sm">
                            <div class="text-xs font-extrabold">Beras Lain</div>
                            <div class="text-[10px] opacity-80">Atur harga</div>
                            <div class="text-xs mt-1 font-bold">Custom / kg</div>
                        </div>
                    </label>
                </div>

                <div id="hargaBanjarBox" class="mt-4">
                    <label class="text-xs font-bold text-oliveDark">Harga Beras Banjar (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-olive">Rp</span>
                        <input id="hargaBanjar" type="number" value="{{ $hargaBeras ?? 16000 }}" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
                    </div>
                </div>
                <div id="hargaLainBox" class="mt-4 hidden">
                    <label class="text-xs font-bold text-oliveDark">Harga Beras Lain (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-olive">Rp</span>
                        <input id="hargaLain" type="number" value="14000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
                    </div>
                    <input id="namaBerasLain" placeholder="Nama beras (opsional, mis. Beras Siam)" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>

            <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl hover-smooth flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL PERHITUNGAN</div>
                    <h3 class="font-black text-2xl mt-1">Zakat Fitrah</h3>
                    <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="bg-cream2 rounded-xl p-3">
                                <div class="text-[10px] text-olive/70 font-semibold">Total Beras</div>
                                <div id="fitrahBeras" class="font-black text-olive text-lg">2,5 kg</div>
                                <div id="fitrahLiter" class="text-[10px] text-olive/60">≈ 3,5 liter</div>
                            </div>
                            <div class="bg-cream2 rounded-xl p-3">
                                <div class="text-[10px] text-olive/70 font-semibold">Jiwa</div>
                                <div id="fitrahJiwaOut" class="font-black text-olive text-lg">1</div>
                                <div class="text-[10px] text-olive/60">orang</div>
                            </div>
                        </div>
                        <div class="mt-3 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                            <div class="text-[10px] text-cream/80 font-medium">Setara Uang</div>
                            <div id="fitrahRupiah" class="font-black text-xl">Rp 40.000</div>
                            <div id="fitrahJenisLabel" class="text-[10px] text-cream/80 mt-0.5">Beras Banjar • Rp16.000/kg</div>
                        </div>
                        <div id="fitrahRincian" class="mt-3 text-[11px] text-olive/70 leading-relaxed font-medium"></div>
                    </div>
                </div>
                <p class="text-[11px] text-cream/70 mt-4"><i class="fa-solid fa-clock mr-1"></i> Waktu utama: akhir Ramadhan hingga sebelum shalat Id.</p>
            </div>
        </div>
    </div>

    {{-- MAAL --}}
    <div id="panel-maal" class="tab-panel mt-6 hidden anim-smooth delay-2">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl hover-smooth">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-coins text-olive"></i> Zakat Maal (Harta)</h2>
                <p class="text-xs text-olive/70 mt-1">2,5% dari harta yang telah mencapai nisab (85 gr emas) dan haul 1 tahun.</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">Total Harta (Rp)</label>
                <input id="maalHarta" type="number" value="100000000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

                <label class="block mt-4 text-xs font-bold text-oliveDark">Harga Emas per gram (Rp)</label>
                <input id="maalEmas" type="number" value="1300000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

                <label class="block mt-4 text-xs font-bold text-oliveDark">Sudah haul 1 tahun?</label>
                <div class="mt-2 flex gap-2">
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Ya</div></label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="belum" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Belum</div></label>
                </div>
            </div>

            <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl hover-smooth flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL ZAKAT MAAL</div>
                    <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                        <div class="flex justify-between text-xs font-medium"><span class="text-olive/70">Nisab (85 gr)</span><span id="maalNisab" class="font-bold">Rp 110.500.000</span></div>
                        <div class="flex justify-between text-xs font-medium mt-2"><span class="text-olive/70">Harta Anda</span><span id="maalHartaOut" class="font-bold">Rp 100.000.000</span></div>
                        <div class="mt-3 bg-cream2 rounded-xl p-3 text-center">
                            <div class="text-[10px] text-olive/70">Status</div>
                            <div id="maalStatus" class="font-extrabold text-olive text-sm">Belum wajib zakat</div>
                            <div id="maalKet" class="text-[10px] text-olive/60 mt-0.5"></div>
                        </div>
                        <div class="mt-4 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                            <div class="text-[10px] text-cream/80">Zakat yang harus dibayar (2,5%)</div>
                            <div id="maalZakat" class="font-black text-xl">Rp 0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FIDYAH --}}
    <div id="panel-fidyah" class="tab-panel mt-6 hidden anim-smooth delay-2">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl hover-smooth">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-utensils text-olive"></i> Fidyah Puasa</h2>
                <p class="text-xs text-olive/70 mt-1">Bagi yang tidak mampu berpuasa (sakit menahun, lansia). 1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan.</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">Jumlah hari yang ditinggalkan</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fidyahMinus" class="w-10 h-10 rounded-full bg-cream2 border border-cream3 text-olive font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fidyahHari" type="number" min="1" value="7" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-cream2">
                    <button id="fidyahPlus" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">Harga 1 porsi makan (Rp)</label>
                <input id="fidyahHarga" type="number" value="45000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

                <div class="mt-4 flex items-center gap-2 bg-cream2 rounded-xl p-3 border border-cream3/60">
                    <input id="fidyahModeBeras" type="checkbox" class="accent-olive rounded">
                    <label for="fidyahModeBeras" class="text-xs font-semibold text-oliveDark">Hitung juga dalam beras (0,75 kg × hari)</label>
                </div>
            </div>

            <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl hover-smooth flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL FIDYAH</div>
                    <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="bg-cream2 rounded-xl p-3"><div class="text-[10px] text-olive/70">Hari</div><div id="fidyahHariOut" class="font-black text-olive text-lg">7</div><div class="text-[10px] text-olive/60">hari</div></div>
                            <div class="bg-cream2 rounded-xl p-3"><div class="text-[10px] text-olive/70">Per hari</div><div id="fidyahPerHari" class="font-bold text-olive text-xs">Rp 45.000</div><div class="text-[10px] text-olive/60">1 porsi</div></div>
                        </div>
                        <div class="mt-4 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                            <div class="text-[10px] text-cream/80">Total Fidyah</div>
                            <div id="fidyahTotal" class="font-black text-xl">Rp 315.000</div>
                            <div id="fidyahBerasOut" class="text-[10px] text-cream/80 mt-0.5 hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const $ = id => document.getElementById(id);
const fmt = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fmtKg = n => n.toLocaleString('id-ID', {minimumFractionDigits:1, maximumFractionDigits:1});

// Tabs
document.querySelectorAll('.tab-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        document.querySelectorAll('.tab-btn').forEach(b=>{b.className='tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow-sm transition';});
        btn.className='tab-btn bg-olive text-white px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow transition';
        document.querySelectorAll('.tab-panel').forEach(p=>p.classList.add('hidden'));
        document.getElementById('panel-'+btn.dataset.tab).classList.remove('hidden');
    });
});

// Fitrah
function calcFitrah(){
    const jiwa = Math.max(1, parseInt($('fitrahJiwa').value||1));
    const beras = document.querySelector('input[name="beras"]:checked').value;
    const harga = beras==='banjar' ? parseInt($('hargaBanjar').value||0) : parseInt($('hargaLain').value||0);
    const nama = beras==='banjar' ? 'Beras Banjar' : ($('namaBerasLain').value.trim()||'Beras Lain');
    const kg = 2.5 * jiwa;
    const liter = 3.5 * jiwa;
    const total = kg * harga;
    $('fitrahBeras').textContent = fmtKg(kg) + ' kg';
    $('fitrahLiter').textContent = '≈ ' + fmtKg(liter) + ' liter';
    $('fitrahJiwaOut').textContent = jiwa;
    $('fitrahRupiah').textContent = fmt(total);
    $('fitrahJenisLabel').textContent = nama + ' • Rp' + Number(harga).toLocaleString('id-ID') + '/kg';
    $('fitrahRincian').textContent = jiwa + ' jiwa × 2,5 kg × Rp' + Number(harga).toLocaleString('id-ID') + ' = ' + fmt(total) + ' (' + nama + ')';
    $('hargaBanjarBox').classList.toggle('hidden', beras!=='banjar');
    $('hargaLainBox').classList.toggle('hidden', beras!=='lain');
    document.getElementById('labelBanjar').textContent = Number($('hargaBanjar').value||0).toLocaleString('id-ID');
}
['fitrahJiwa','hargaBanjar','hargaLain','namaBerasLain'].forEach(id=> $(id).addEventListener('input', calcFitrah));
document.querySelectorAll('input[name="beras"]').forEach(r=> r.addEventListener('change', calcFitrah));
$('fitrahMinus').addEventListener('click', ()=>{ $('fitrahJiwa').value = Math.max(1, parseInt($('fitrahJiwa').value)-1); calcFitrah(); });
$('fitrahPlus').addEventListener('click', ()=>{ $('fitrahJiwa').value = parseInt($('fitrahJiwa').value)+1; calcFitrah(); });
calcFitrah();

// Maal
function calcMaal(){
    const harta = parseInt($('maalHarta').value||0);
    const emas = parseInt($('maalEmas').value||0);
    const nisab = 85 * emas;
    const haul = document.querySelector('input[name="haul"]:checked').value;
    const wajib = harta >= nisab && haul==='ya';
    const zakat = wajib ? Math.round(harta*0.025) : 0;
    $('maalNisab').textContent = fmt(nisab);
    $('maalHartaOut').textContent = fmt(harta);
    $('maalStatus').textContent = wajib ? 'Wajib zakat' : (haul!=='ya' ? 'Belum haul' : 'Belum mencapai nisab');
    $('maalStatus').className = wajib ? 'font-extrabold text-emerald-600' : 'font-extrabold text-amber-600';
    $('maalKet').textContent = wajib ? 'Harta telah mencapai nisab dan haul.' : (haul!=='ya' ? 'Tunggu genap 1 tahun hijriah.' : 'Harta masih di bawah nisab.');
    $('maalZakat').textContent = fmt(zakat);
}
['maalHarta','maalEmas'].forEach(id=> $(id).addEventListener('input', calcMaal));
document.querySelectorAll('input[name="haul"]').forEach(r=> r.addEventListener('change', calcMaal));
calcMaal();

// Fidyah
function calcFidyah(){
    const hari = Math.max(1, parseInt($('fidyahHari').value||1));
    const harga = parseInt($('fidyahHarga').value||0);
    const total = hari * harga;
    const berasKg = (0.75 * hari);
    $('fidyahHariOut').textContent = hari;
    $('fidyahPerHari').textContent = fmt(harga);
    $('fidyahTotal').textContent = fmt(total);
    const box = $('fidyahBerasOut');
    if($('fidyahModeBeras').checked){
        box.textContent = 'Setara beras: ' + fmtKg(berasKg) + ' kg (' + hari + ' × 0,75 kg)';
        box.classList.remove('hidden');
    } else box.classList.add('hidden');
}
['fidyahHari','fidyahHarga'].forEach(id=> $(id).addEventListener('input', calcFidyah));
$('fidyahModeBeras').addEventListener('change', calcFidyah);
$('fidyahMinus').addEventListener('click', ()=>{ $('fidyahHari').value=Math.max(1, parseInt($('fidyahHari').value)-1); calcFidyah(); });
$('fidyahPlus').addEventListener('click', ()=>{ $('fidyahHari').value=parseInt($('fidyahHari').value)+1; calcFidyah(); });
calcFidyah();
</script>
@endsection