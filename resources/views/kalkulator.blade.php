@extends('layouts.app')
@section('title','Kalkulator Zakat & Fidyah — E-Zakat')
@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
    <div class="bg-cream rounded-[20px] p-5 lg:p-6 border border-cream3">
        <h1 class="font-extrabold text-oliveDark text-xl lg:text-2xl"><i class="fa-solid fa-calculator text-olive mr-2"></i> Kalkulator Zakat & Fidyah</h1>
        <p class="text-sm text-olive/60 mt-1">Pilih jenis zakat, atur jumlah, dan lihat hasil perhitungan secara otomatis. Harga beras dapat disesuaikan.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button data-tab="fitrah" class="tab-btn bg-olive text-white px-5 py-2 rounded-full text-sm font-semibold">Zakat Fitrah</button>
            <button data-tab="maal" class="tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-sm font-semibold">Zakat Maal</button>
            <button data-tab="fidyah" class="tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-sm font-semibold">Fidyah</button>
        </div>
    </div>

    {{-- FITRAH --}}
    <div id="panel-fitrah" class="tab-panel mt-6">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark"><i class="fa-solid fa-wheat-awn text-olive mr-2"></i> Zakat Fitrah</h2>
                <p class="text-xs text-olive/60 mt-1">Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran: 2,5 kg beras atau 3,5 liter / jiwa (1 sha').</p>

                <label class="block mt-5 text-sm font-semibold text-oliveDark">Jumlah Jiwa</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fitrahMinus" class="w-10 h-10 rounded-full bg-cream border border-cream3 text-olive flex items-center justify-center"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fitrahJiwa" type="number" min="1" value="1" class="flex-1 border border-cream3 rounded-full px-4 py-2.5 text-center font-bold text-oliveDark">
                    <button id="fitrahPlus" class="w-10 h-10 rounded-full bg-olive text-white flex items-center justify-center"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-5 text-sm font-semibold text-oliveDark">Jenis Beras</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="banjar" checked class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream border border-cream3 rounded-2xl p-3 text-center transition">
                            <div class="text-sm font-bold">Beras Banjar</div>
                            <div class="text-xs opacity-70">Premium lokal</div>
                            <div class="text-xs mt-1 font-semibold">Rp <span id="labelBanjar">16.000</span> / kg</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="lain" class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream border border-cream3 rounded-2xl p-3 text-center transition">
                            <div class="text-sm font-bold">Beras Lain</div>
                            <div class="text-xs opacity-70">Atur harga</div>
                            <div class="text-xs mt-1 font-semibold">Custom / kg</div>
                        </div>
                    </label>
                </div>

                <div id="hargaBanjarBox" class="mt-4">
                    <label class="text-xs font-semibold text-oliveDark">Harga Beras Banjar (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-sm text-olive">Rp</span>
                        <input id="hargaBanjar" type="number" value="16000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-sm">
                    </div>
                    <p class="text-xs text-olive/50 mt-1">Ubah jika harga pasar berbeda.</p>
                </div>
                <div id="hargaLainBox" class="mt-4 hidden">
                    <label class="text-xs font-semibold text-oliveDark">Harga Beras Lain (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-sm text-olive">Rp</span>
                        <input id="hargaLain" type="number" value="14000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-sm">
                    </div>
                    <input id="namaBerasLain" placeholder="Nama beras (opsional, mis. Beras Siam)" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2 text-sm">
                </div>

                <div class="mt-5 bg-cream rounded-xl p-3 text-xs text-olive/70">
                    <i class="fa-solid fa-circle-info text-olive mr-1"></i> Jika membayar dengan uang, nilainya setara harga beras 2,5 kg (atau 3,5 liter) per jiwa sesuai harga lokal.
                </div>
            </div>

            <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white">
                <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HASIL PERHITUNGAN</div>
                <h3 class="font-extrabold text-2xl mt-1">Zakat Fitrah</h3>
                <div class="mt-5 bg-white text-oliveDark rounded-2xl p-4">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-cream rounded-xl p-3">
                            <div class="text-xs text-olive/60">Total Beras</div>
                            <div id="fitrahBeras" class="font-extrabold text-olive text-lg">2,5 kg</div>
                            <div id="fitrahLiter" class="text-xs text-olive/60">≈ 3,5 liter</div>
                        </div>
                        <div class="bg-cream rounded-xl p-3">
                            <div class="text-xs text-olive/60">Jiwa</div>
                            <div id="fitrahJiwaOut" class="font-extrabold text-olive text-lg">1</div>
                            <div class="text-xs text-olive/60">orang</div>
                        </div>
                    </div>
                    <div class="mt-4 bg-olive text-white rounded-xl p-4 text-center">
                        <div class="text-xs text-cream/80">Setara Uang</div>
                        <div id="fitrahRupiah" class="font-black text-xl">Rp 40.000</div>
                        <div id="fitrahJenisLabel" class="text-xs text-cream/70 mt-1">Beras Banjar • Rp16.000/kg</div>
                    </div>
                    <div id="fitrahRincian" class="mt-3 text-xs text-olive/60 leading-relaxed"></div>
                </div>
                <p class="text-xs text-cream/60 mt-4"><i class="fa-solid fa-clock mr-1"></i> Waktu utama: akhir Ramadhan hingga sebelum shalat Id.</p>
            </div>
        </div>
    </div>

    {{-- MAAL --}}
    <div id="panel-maal" class="tab-panel mt-6 hidden">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark"><i class="fa-solid fa-coins text-olive mr-2"></i> Zakat Maal (Harta)</h2>
                <p class="text-xs text-olive/60 mt-1">2,5% dari harta yang telah mencapai nisab (85 gr emas) dan haul 1 tahun.</p>

                <label class="block mt-5 text-sm font-semibold text-oliveDark">Total Harta (Rp)</label>
                <input id="maalHarta" type="number" value="100000000" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm">

                <label class="block mt-4 text-sm font-semibold text-oliveDark">Harga Emas per gram (Rp)</label>
                <input id="maalEmas" type="number" value="1300000" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm">
                <p class="text-xs text-olive/50 mt-1">Nisab = 85 × harga emas. Default mengikuti estimasi pasar.</p>

                <label class="block mt-4 text-sm font-semibold text-oliveDark">Sudah haul 1 tahun?</label>
                <div class="mt-2 flex gap-2">
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream border border-cream3 rounded-full py-2 text-center text-sm font-semibold">Ya</div></label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="belum" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream border border-cream3 rounded-full py-2 text-center text-sm font-semibold">Belum</div></label>
                </div>
            </div>
            <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white">
                <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HASIL ZAKAT MAAL</div>
                <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4">
                    <div class="flex justify-between text-sm"><span class="text-olive/60">Nisab (85 gr)</span><span id="maalNisab" class="font-bold">Rp 110.500.000</span></div>
                    <div class="flex justify-between text-sm mt-2"><span class="text-olive/60">Harta Anda</span><span id="maalHartaOut" class="font-bold">Rp 100.000.000</span></div>
                    <div class="mt-3 bg-cream rounded-xl p-3 text-center">
                        <div class="text-xs text-olive/60">Status</div>
                        <div id="maalStatus" class="font-bold text-olive">Belum wajib zakat</div>
                        <div id="maalKet" class="text-xs text-olive/60 mt-1"></div>
                    </div>
                    <div class="mt-4 bg-olive text-white rounded-xl p-4 text-center">
                        <div class="text-xs text-cream/80">Zakat yang harus dibayar (2,5%)</div>
                        <div id="maalZakat" class="font-black text-xl">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FIDYAH --}}
    <div id="panel-fidyah" class="tab-panel mt-6 hidden">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark"><i class="fa-solid fa-utensils text-olive mr-2"></i> Fidyah Puasa</h2>
                <p class="text-xs text-olive/60 mt-1">Bagi yang tidak mampu berpuasa (sakit menahun, lansia). 1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan.</p>

                <label class="block mt-5 text-sm font-semibold text-oliveDark">Jumlah hari yang ditinggalkan</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fidyahMinus" class="w-10 h-10 rounded-full bg-cream border border-cream3 text-olive flex items-center justify-center"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fidyahHari" type="number" min="1" value="7" class="flex-1 border border-cream3 rounded-full px-4 py-2.5 text-center font-bold text-oliveDark">
                    <button id="fidyahPlus" class="w-10 h-10 rounded-full bg-olive text-white flex items-center justify-center"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-5 text-sm font-semibold text-oliveDark">Harga 1 porsi makan (Rp)</label>
                <input id="fidyahHarga" type="number" value="45000" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm">
                <p class="text-xs text-olive/50 mt-1">Termasuk lauk. Estimasi Banjarbaru Rp35.000–Rp55.000. Atau gunakan opsi beras (0,75 kg/hari).</p>

                <div class="mt-4 flex items-center gap-2 bg-cream rounded-xl p-3">
                    <input id="fidyahModeBeras" type="checkbox" class="accent-olive">
                    <label for="fidyahModeBeras" class="text-sm text-oliveDark">Hitung juga dalam beras (0,75 kg × hari)</label>
                </div>
            </div>
            <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white">
                <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HASIL FIDYAH</div>
                <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4">
                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="bg-cream rounded-xl p-3"><div class="text-xs text-olive/60">Hari</div><div id="fidyahHariOut" class="font-extrabold text-olive text-lg">7</div><div class="text-xs text-olive/60">hari</div></div>
                        <div class="bg-cream rounded-xl p-3"><div class="text-xs text-olive/60">Per hari</div><div id="fidyahPerHari" class="font-bold text-olive text-sm">Rp 45.000</div><div class="text-xs text-olive/60">1 porsi</div></div>
                    </div>
                    <div class="mt-4 bg-olive text-white rounded-xl p-4 text-center">
                        <div class="text-xs text-cream/80">Total Fidyah</div>
                        <div id="fidyahTotal" class="font-black text-xl">Rp 315.000</div>
                        <div id="fidyahBerasOut" class="text-xs text-cream/70 mt-1 hidden"></div>
                    </div>
                    <div class="mt-3 text-xs text-olive/60">Diberikan kepada fakir miskin, boleh sekaligus atau dicicil. Lebih utama memberi makan langsung.</div>
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
        document.querySelectorAll('.tab-btn').forEach(b=>{b.className='tab-btn bg-white border border-cream3 text-olive px-5 py-2 rounded-full text-sm font-semibold';});
        btn.className='tab-btn bg-olive text-white px-5 py-2 rounded-full text-sm font-semibold';
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
    $('maalStatus').className = wajib ? 'font-bold text-emerald-600' : 'font-bold text-amber-600';
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
