@extends('layouts.dashboard')
@section('title','Kalkulator Zakat & Waris — E-Zakat')
@section('page-title','Kalkulator Zakat & Waris')
@section('page-sub','Hitung dan simpan semua jenis perhitungan zakat & waris dalam satu halaman')
@section('content')

@php $csrf = csrf_token(); @endphp

{{-- ============================================================ --}}
{{--  TAB BAR --}}
{{-- ============================================================ --}}
<div class="flex flex-wrap gap-2 mb-5">
    <button data-tab="fitrah" class="calc-tab bg-olive text-white px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow transition active:scale-95"><i class="fa-solid fa-wheat-awn mr-2"></i>Fitrah</button>
    <button data-tab="maal" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-coins mr-2"></i>Maal</button>
    <button data-tab="fidyah" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-utensils mr-2"></i>Fidyah</button>
    <button data-tab="penghasilan" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-money-bill-trend-up mr-2"></i>Penghasilan</button>
    <button data-tab="pertanian" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-seedling mr-2"></i>Pertanian</button>
    <button data-tab="perdagangan" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-store mr-2"></i>Perdagangan</button>
    <button data-tab="wariq" class="calc-tab bg-white border border-cream3 text-olive px-4 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95"><i class="fa-solid fa-scale-balanced mr-2"></i>Waris</button>
</div>

{{-- ============================================================ --}}
{{--  TAB: ZAKAT FITRAH --}}
{{-- ============================================================ --}}
<div id="calc-panel-fitrah" class="calc-panel">
<div class="grid lg:grid-cols-2 gap-5">
    {{-- FORM --}}
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-wheat-awn text-olive"></i> Zakat Fitrah</h2>
        <p class="text-xs text-olive/70 mt-1">Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran: 2,5 kg beras (±3,5 liter) per jiwa.</p>

        <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jumlah Jiwa</label>
        <div class="mt-2 flex items-center gap-3">
            <button type="button" data-adjust="fitrahJiwa" data-dir="-1" class="w-10 h-10 rounded-full bg-cream2 border border-cream3 text-olive font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
            <input id="fitrahJiwa" type="number" min="1" value="1" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-cream2">
            <button type="button" data-adjust="fitrahJiwa" data-dir="1" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
        </div>

        <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jenis Beras</label>
        <div class="mt-2 grid grid-cols-2 gap-2">
            <label class="cursor-pointer">
                <input type="radio" name="beras" value="banjar" checked class="peer sr-only">
                <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream2 border border-cream3 rounded-2xl p-3 text-center transition shadow-sm">
                    <div class="text-xs font-extrabold">Beras Banjar</div>
                    <div class="text-[10px] opacity-80">Premium lokal</div>
                    <div class="text-xs mt-1 font-bold">Rp {{ number_format($beras ?? 16000,0,',','.') }} / kg</div>
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="beras" value="lain" class="peer sr-only">
                <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive bg-cream2 border border-cream3 rounded-2xl p-3 text-center transition shadow-sm">
                    <div class="text-xs font-extrabold">Beras Lain</div>
                    <div class="text-[10px] opacity-80">Atur harga sendiri</div>
                    <div class="text-xs mt-1 font-bold">Custom / kg</div>
                </div>
            </label>
        </div>

        <div id="hargaBanjarBox" class="mt-4">
            <label class="text-xs font-bold text-oliveDark">Harga Beras Banjar (per kg)</label>
            <div class="mt-1 flex items-center gap-2">
                <span class="text-xs font-bold text-olive">Rp</span>
                <input id="hargaBanjar" type="text" data-money value="{{ number_format($beras ?? 16000,0,'','') }}" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
            </div>
        </div>
        <div id="hargaLainBox" class="mt-4 hidden">
            <label class="text-xs font-bold text-oliveDark">Harga Beras Lain (per kg)</label>
            <div class="mt-1 flex items-center gap-2">
                <span class="text-xs font-bold text-olive">Rp</span>
                <input id="hargaLain" type="number" value="14000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
            </div>
            <input id="namaBerasLain" placeholder="Nama beras (opsional)" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
        </div>

        <button type="button" data-save-calc="zakat_fitrah" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    {{-- HASIL --}}
    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
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
                    <div id="fitrahJenisLabel" class="text-[10px] text-cream/80 mt-0.5">Beras Banjar • Rp{{ number_format($beras ?? 16000,0,',','.') }}/kg</div>
                </div>
                <div id="fitrahRincian" class="mt-3 text-[11px] text-olive/70 leading-relaxed font-medium"></div>
            </div>
        </div>
        <p class="text-[11px] text-cream/70 mt-4"><i class="fa-solid fa-clock mr-1"></i> Waktu utama: akhir Ramadhan hingga sebelum shalat Id.</p>
    </div>
</div>
</div>

{{-- ============================================================ --}}
{{--  TAB: ZAKAT MAAL --}}
{{-- ============================================================ --}}
<div id="calc-panel-maal" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-coins text-olive"></i> Zakat Maal (Harta)</h2>
        <p class="text-xs text-olive/70 mt-1">2,5% dari harta yang telah mencapai nisab (85 gr emas) dan haul 1 tahun.</p>

        <label class="block mt-5 text-xs font-bold text-oliveDark">Total Harta (Rp)</label>
        <input id="maalHarta" type="text" data-money value="{{ number_format(100000000,0,'','.') }}" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <label class="block mt-4 text-xs font-bold text-oliveDark">Harga Emas per gram (Rp)</label>
        <input id="maalEmas" type="text" data-money value="{{ number_format(1300000,0,'','.') }}" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <label class="block mt-4 text-xs font-bold text-oliveDark">Sudah haul 1 tahun?</label>
        <div class="mt-2 flex gap-2">
            <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Ya</div></label>
            <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="belum" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Belum</div></label>
        </div>

        <button type="button" data-save-calc="zakat_maal" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
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

{{-- ============================================================ --}}
{{--  TAB: FIDYAH --}}
{{-- ============================================================ --}}
<div id="calc-panel-fidyah" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-utensils text-olive"></i> Fidyah Puasa</h2>
        <p class="text-xs text-olive/70 mt-1">Bagi yang tidak mampu berpuasa (sakit menahun, lansia). 1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan.</p>

        <label class="block mt-5 text-xs font-bold text-oliveDark">Jumlah hari yang ditinggalkan</label>
        <div class="mt-2 flex items-center gap-3">
            <button type="button" data-adjust="fidyahHari" data-dir="-1" class="w-10 h-10 rounded-full bg-cream2 border border-cream3 text-olive font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
            <input id="fidyahHari" type="number" min="1" value="7" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-cream2">
            <button type="button" data-adjust="fidyahHari" data-dir="1" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
        </div>

        <label class="block mt-4 text-xs font-bold text-oliveDark">Harga 1 porsi makan (Rp)</label>
        <input id="fidyahHarga" type="text" data-money value="{{ number_format(45000,0,'','.') }}" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <button type="button" data-save-calc="fidyah" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
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
                    <div id="fidyahBerasOut" class="text-[10px] text-cream/80 mt-0.5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- ============================================================ --}}
{{--  TAB: ZAKAT PENGHASILAN --}}
{{-- ============================================================ --}}
<div id="calc-panel-penghasilan" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-money-bill-trend-up text-olive"></i> Zakat Penghasilan</h2>
        <p class="text-xs text-olive/70 mt-1">2,5% dari penghasilan bulanan (gaji, honor, dll). Nisab: Rp2.500.000/bulan (setara 85 gr emas konversi). Disetorkan setiap bulan.</p>

        <label class="block mt-5 text-xs font-bold text-oliveDark">Penghasilan per Bulan (Rp)</label>
        <input id="penghasilanBulan" type="text" data-money value="" placeholder="cth: 8500000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
        <p class="text-[10px] text-olive/50 mt-1">Ketik angka biasa — akan otomatis dipisah ribuan.</p>

        <button type="button" data-calc-type="zakat_penghasilan" data-save-calc="zakat_penghasilan" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
        <div>
            <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL ZAKAT PENGHASILAN</div>
            <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                <div class="flex justify-between text-xs font-medium"><span class="text-olive/70">Nisab / bulan</span><span class="font-bold">Rp 2.500.000</span></div>
                <div class="flex justify-between text-xs font-medium mt-2"><span class="text-olive/70">Penghasilan Anda</span><span id="penghasilanOut" class="font-bold">Rp 0</span></div>
                <div class="mt-3 bg-cream2 rounded-xl p-3 text-center">
                    <div class="text-[10px] text-olive/70">Status</div>
                    <div id="penghasilanStatus" class="font-extrabold text-amber-600 text-sm">Belum wajib</div>
                    <div id="penghasilanKet" class="text-[10px] text-olive/60 mt-0.5"></div>
                </div>
                <div class="mt-4 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                    <div class="text-[10px] text-cream/80">Zakat / Bulan</div>
                    <div id="penghasilanZakat" class="font-black text-xl">Rp 0</div>
                    <div id="penghasilanTahunan" class="text-[10px] text-cream/80 mt-0.5">/ tahun: Rp 0</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- ============================================================ --}}
{{--  TAB: ZAKAT PERTANIAN --}}
{{-- ============================================================ --}}
<div id="calc-panel-pertanian" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-seedling text-olive"></i> Zakat Pertanian</h2>
        <p class="text-xs text-olive/70 mt-1">Dihitung dari hasil panen. Dengan irigasi: nisab 1.000 kg, zakat 5%. Tanpa irigasi: nisab 653 kg, zakat 10%.</p>

        <label class="block mt-5 text-xs font-bold text-oliveDark">Hasil Panen (kg)</label>
        <input id="pertanianPanen" type="text" data-money value="" placeholder="cth: 1500" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <label class="block mt-4 text-xs font-bold text-oliveDark">Sistem Pengairan</label>
        <div class="mt-2 flex gap-2">
            <label class="flex-1 cursor-pointer"><input type="radio" name="irigasi" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Dengan irigasi (5%)</div></label>
            <label class="flex-1 cursor-pointer"><input type="radio" name="irigasi" value="tidak" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Tanpa irigasi (10%)</div></label>
        </div>

        <button type="button" data-calc-type="zakat_pertanian" data-save-calc="zakat_pertanian" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
        <div>
            <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL ZAKAT PERTANIAN</div>
            <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                <div class="flex justify-between text-xs font-medium"><span class="text-olive/70">Nisab</span><span id="pertanianNisab" class="font-bold">1.000 kg</span></div>
                <div class="flex justify-between text-xs font-medium mt-2"><span class="text-olive/70">Hasil Panen</span><span id="pertanianPanenOut" class="font-bold">0 kg</span></div>
                <div class="mt-3 bg-cream2 rounded-xl p-3 text-center">
                    <div class="text-[10px] text-olive/70">Status</div>
                    <div id="pertanianStatus" class="font-extrabold text-amber-600 text-sm">Belum wajib</div>
                    <div id="pertanianKet" class="text-[10px] text-olive/60 mt-0.5"></div>
                </div>
                <div class="mt-4 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                    <div class="text-[10px] text-cream/80">Zakat (kg beras)</div>
                    <div id="pertanianZakat" class="font-black text-xl">0 kg</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- ============================================================ --}}
{{--  TAB: ZAKAT PERDAGANGAN --}}
{{-- ============================================================ --}}
<div id="calc-panel-perdagangan" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-store text-olive"></i> Zakat Perdagangan</h2>
        <p class="text-xs text-olive/70 mt-1">Untuk pedagang. Total harta = modal + piutang + persediaan − utang. Nisab 85 gr emas, zakat 2,5% bila mencapai nisab & haul 1 tahun.</p>

        <label class="block mt-4 text-xs font-bold text-oliveDark">Modal (Rp)</label>
        <input id="dagModal" type="text" data-money value="" placeholder="cth: 50000000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <div class="grid grid-cols-2 gap-3 mt-3">
            <div>
                <label class="text-xs font-bold text-oliveDark">Piutang (Rp)</label>
                <input id="dagPiutang" type="text" data-money value="0" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
            </div>
            <div>
                <label class="text-xs font-bold text-oliveDark">Persediaan (Rp)</label>
                <input id="dagPersediaan" type="text" data-money value="0" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">
            </div>
        </div>

        <label class="block mt-3 text-xs font-bold text-oliveDark">Utang (Rp)</label>
        <input id="dagUtang" type="text" data-money value="0" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <label class="block mt-3 text-xs font-bold text-oliveDark">Harga Emas / gr (Rp)</label>
        <input id="dagEmas" type="text" data-money value="{{ $hargaEmas ?? 1300000 }}" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 font-bold">

        <label class="flex items-center gap-2 text-xs font-semibold mt-3"><input type="checkbox" id="dagHaul" checked class="accent-olive"> Sudah genap haul 1 tahun</label>

        <button type="button" data-calc-type="zakat_perdagangan" data-save-calc="zakat_perdagangan" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan ke Riwayat</button>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
        <div>
            <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL ZAKAT PERDAGANGAN</div>
            <div class="mt-4 bg-white text-oliveDark rounded-2xl p-4 shadow-inner">
                <div class="flex justify-between text-xs font-medium"><span class="text-olive/70">Nisab (85 gr emas)</span><span id="dagNisab" class="font-bold">Rp 0</span></div>
                <div class="flex justify-between text-xs font-medium mt-2"><span class="text-olive/70">Total Harta</span><span id="dagHarta" class="font-bold">Rp 0</span></div>
                <div class="mt-3 bg-cream2 rounded-xl p-3 text-center">
                    <div class="text-[10px] text-olive/70">Status</div>
                    <div id="dagStatus" class="font-extrabold text-amber-600 text-sm">Belum wajib</div>
                    <div id="dagKet" class="text-[10px] text-olive/60 mt-0.5"></div>
                </div>
                <div class="mt-4 bg-olive text-white rounded-xl p-3.5 text-center shadow-md">
                    <div class="text-[10px] text-cream/80">Zakat (2,5%)</div>
                    <div id="dagZakat" class="font-black text-xl">Rp 0</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- ============================================================ --}}
{{--  TAB: WARIS --}}
{{-- ============================================================ --}}
<div id="calc-panel-wariq" class="calc-panel hidden">
<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white/90 backdrop-blur-md rounded-[24px] border border-cream3 p-5 lg:p-6 shadow-xl">
        <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-scale-balanced text-olive"></i> Waris (Faraidh)</h2>
        <p class="text-xs text-olive/70 mt-1">Pembagian harta warisan berdasarkan hukum Islam.</p>

        <label class="block mt-4 text-xs font-bold text-oliveDark"><span class="text-red-500">*</span> Total Harta Warisan (Rp)</label>
        <div class="relative mt-1.5">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-olive/60">Rp</span>
            <input id="wariqHarta" type="text" inputmode="numeric" data-money value="120.000.000" class="w-full border border-cream3 rounded-full pl-10 pr-4 py-2 text-xs bg-cream2 font-bold">
        </div>

        <div class="mt-3 grid grid-cols-3 gap-2">
            <div>
                <label class="text-[10px] font-bold text-oliveDark">Hutang</label>
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-olive/60">Rp</span>
                    <input id="wariqHutang" type="text" inputmode="numeric" data-money value="0" class="w-full border border-cream3 rounded-full pl-8 pr-2 py-1.5 text-xs bg-cream2">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-oliveDark">Biaya Pemakaman</label>
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-olive/60">Rp</span>
                    <input id="wariqPemakaman" type="text" inputmode="numeric" data-money value="0" class="w-full border border-cream3 rounded-full pl-8 pr-2 py-1.5 text-xs bg-cream2">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-oliveDark">Wasiat (maks 1/3)</label>
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-olive/60">Rp</span>
                    <input id="wariqWasiat" type="text" inputmode="numeric" data-money value="0" class="w-full border border-cream3 rounded-full pl-8 pr-2 py-1.5 text-xs bg-cream2">
                </div>
            </div>
        </div>

        <label class="block mt-4 text-xs font-bold text-oliveDark"><span class="text-red-500">*</span> Jenis Kelamin Pewaris</label>
        <div class="mt-2 flex gap-2">
            <label class="flex-1 cursor-pointer"><input type="radio" name="pewarisJk" value="L" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Laki-laki</div></label>
            <label class="flex-1 cursor-pointer"><input type="radio" name="pewarisJk" value="P" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white bg-cream2 border border-cream3 rounded-full py-2 text-center text-xs font-bold">Perempuan</div></label>
        </div>
        <p class="text-[10px] text-olive/50 mt-1"><span class="text-red-500">*</span> wajib diisi</p>

        {{-- Pasangan --}}
        <div class="mt-4 bg-cream2/70 rounded-2xl p-3 border border-cream3/70">
            <div class="text-[10px] font-extrabold tracking-wider text-olive mb-2">PASANGAN</div>
            <div class="grid grid-cols-2 gap-3">
                <label id="wariqIstriLabel" class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqIstri" class="accent-olive"> Ada Istri</label>
                <label id="wariqSuamiLabel" class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqSuami" class="accent-olive"> Ada Suami</label>
            </div>
        </div>

        {{-- Anak & Cucu --}}
        <div class="mt-3 bg-cream2/70 rounded-2xl p-3 border border-cream3/70">
            <div class="text-[10px] font-extrabold tracking-wider text-olive mb-2">ANAK & CUCU</div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Anak Laki-laki</label>
                    <input id="wariqAnakL" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Anak Perempuan</label>
                    <input id="wariqAnakP" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Cucu Laki-laki</label>
                    <input id="wariqCucuL" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Cucu Perempuan</label>
                    <input id="wariqCucuP" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
            </div>
            <p class="text-[10px] text-olive/50 mt-2">Cucu hanya berhak bila tidak ada anak.</p>
        </div>

        {{-- Orang tua & kakek/nenek --}}
        <div class="mt-3 bg-cream2/70 rounded-2xl p-3 border border-cream3/70">
            <div class="text-[10px] font-extrabold tracking-wider text-olive mb-2">ORANG TUA, KAKEK & NENEK</div>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqAyah" class="accent-olive"> Ada Ayah</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqIbu" class="accent-olive"> Ada Ibu</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqKakek" class="accent-olive"> Ada Kakek</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqNenekIbu" class="accent-olive"> Nenek dari Ibu</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" id="wariqNenekAyah" class="accent-olive"> Nenek dari Ayah</label>
            </div>
            <p class="text-[10px] text-olive/50 mt-2">Kakek hanya berhak bila ayah tidak ada. Nenek hanya bila ibu tidak ada.</p>
        </div>

        {{-- Saudara --}}
        <div class="mt-3 bg-cream2/70 rounded-2xl p-3 border border-cream3/70">
            <div class="text-[10px] font-extrabold tracking-wider text-olive mb-2">SAUDARA</div>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Kandung L</label>
                    <input id="wariqSaudaraL" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Kandung P</label>
                    <input id="wariqSaudaraP" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-oliveDark">Seibu</label>
                    <input id="wariqSaudaraSeibu" type="number" min="0" max="100" value="0" class="mt-1 w-full border border-cream3 rounded-full px-3 py-1.5 text-xs bg-white font-bold">
                </div>
            </div>
            <p class="text-[10px] text-olive/50 mt-2">Saudara terhalang bila ada anak, ayah, atau kakek.</p>
        </div>

        <button type="button" id="wariqHitung" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition text-sm shadow-md"><i class="fa-solid fa-calculator mr-2"></i>Hitung & Simpan Pembagian</button>
        <p class="text-[10px] text-olive/50 mt-2 text-center"><i class="fa-solid fa-lock mr-1"></i> Versi login: hasil langsung tersimpan ke riwayat (pembeda kalkulator publik).</p>
    </div>

    <div class="bg-olive rounded-[24px] p-6 text-white shadow-xl">
        <div class="text-[10px] tracking-[0.18em] font-extrabold text-earth uppercase">HASIL PEMBAGIAN</div>
        <div id="wariqResult" class="mt-3 bg-white text-oliveDark rounded-2xl p-4 shadow-inner text-sm">
            <div class="text-center text-olive/40 py-6">Belum dihitung. Isi form lalu klik "Hitung Pembagian".</div>
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
const CSRF = @json(csrf_token());
const ROUTE_SAVE = @json(route('user.calculators.save', ':type'));

// ===================== TABS =====================
document.querySelectorAll('.calc-tab').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        document.querySelectorAll('.calc-tab').forEach(b=>b.className='calc-tab bg-white border border-cream3 text-olive px-5 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow-sm transition active:scale-95');
        btn.className='calc-tab bg-olive text-white px-5 py-2.5 rounded-full text-xs lg:text-sm font-bold shadow transition active:scale-95';
        document.querySelectorAll('.calc-panel').forEach(p=>p.classList.add('hidden'));
        $('calc-panel-'+btn.dataset.tab).classList.remove('hidden');
    });
});

// Buka tab yang diminta lewat URL (?tab=wariq dari sidebar "Kalkulator Waris")
(function(){
    const wanted = @json($tab ?? 'fitrah');
    const target = document.querySelector('.calc-tab[data-tab="' + wanted + '"]');
    if (target) target.click();
})();

// ===================== ADJUST (+/-) =====================
document.querySelectorAll('[data-adjust]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        const el = $(btn.dataset.adjust);
        el.value = Math.max(1, parseInt(el.value||1) + parseInt(btn.dataset.dir));
        refresh();
    });
});

// ===================== HELPERS =====================
// Format ribuan tanpa koma di dalam (100000000 -> 100.000.000)
function formatRupiah(num){
    const n = Math.round(Number(num)||0);
    return n.toLocaleString('id-ID');
}
// Parser input terformat ribuan (100.000.000 -> 100000000)
function parseRupiah(str){
    return parseInt(String(str||'').replace(/\D/g,''),10)||0;
}
// Auto-format ribuan saat mengetik
function attachThousandSeparator(input){
    input.addEventListener('input', function(){
        const raw = input.value.replace(/\D/g,'');
        input.value = raw ? parseInt(raw,10).toLocaleString('id-ID') : '';
    });
}
document.querySelectorAll('input[data-money]').forEach(attachThousandSeparator);

// ===================== KALKULATOR BARU (server) =====================
// 3 kalkulator baru + waris dihitung di server (endpoint calculate).
const ROUTE_CALC = @json(route('user.calculators.calculate', ':type'));

async function calcServer(type, params) {
    const body = new URLSearchParams();
    body.append('_token', CSRF);
    // Laravel rule 'boolean' hanya menerima 0/1/"0"/"1" — ubah boolean JS jadi angka.
    Object.entries(params).forEach(([k,v]) => {
        if (typeof v === 'boolean') body.append(k, v ? '1' : '0');
        else body.append(k, v);
    });
    const res = await fetch(ROUTE_CALC.replace(':type', type), {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: body.toString()
    });
    if (!res.ok) {
        let msg = 'Gagal menghitung (HTTP ' + res.status + ')';
        try {
            const j = await res.json();
            if (j.message) msg = j.message;
            if (j.errors) msg += ': ' + Object.values(j.errors).flat().join(', ');
        } catch (e) { /* respons bukan JSON */ }
        throw new Error(msg);
    }
    return res.json();
}

// ---- ZAKAT PENGHASILAN ----
function renderPenghasilan(r) {
    $('penghasilanOut').textContent = fmt(parseRupiah($('penghasilanBulan').value));
    $('penghasilanStatus').textContent = r.wajib ? 'Wajib' : 'Belum wajib';
    $('penghasilanStatus').className = 'font-extrabold ' + (r.wajib ? 'text-emerald-600' : 'text-amber-600') + ' text-sm';
    $('penghasilanKet').textContent = r.keterangan;
    $('penghasilanZakat').textContent = fmt(r.zakat_bulanan);
    $('penghasilanTahunan').textContent = '/ tahun: ' + fmt(r.zakat_tahunan);
}
async function calcPenghasilan() {
    const v = parseRupiah($('penghasilanBulan').value);
    try { renderPenghasilan(await calcServer('zakat_penghasilan', { penghasilan_bulan: v })); }
    catch(e){ $('penghasilanStatus').textContent = 'Belum wajib'; }
}

// ---- ZAKAT PERTANIAN ----
function renderPertanian(r) {
    $('pertanianNisab').textContent = r.nisab.toLocaleString('id-ID') + ' kg';
    $('pertanianPanenOut').textContent = parseRupiah($('pertanianPanen').value).toLocaleString('id-ID') + ' kg';
    $('pertanianStatus').textContent = r.wajib ? 'Wajib' : 'Belum wajib';
    $('pertanianStatus').className = 'font-extrabold ' + (r.wajib ? 'text-emerald-600' : 'text-amber-600') + ' text-sm';
    $('pertanianKet').textContent = r.keterangan;
    $('pertanianZakat').textContent = r.zakat.toLocaleString('id-ID') + ' kg';
}
async function calcPertanian() {
    const irigasi = document.querySelector('input[name=irigasi]:checked').value === 'ya';
    try { renderPertanian(await calcServer('zakat_pertanian', { hasil_panen_kg: parseRupiah($('pertanianPanen').value), dengan_irigasi: irigasi })); }
    catch(e){ $('pertanianStatus').textContent = 'Belum wajib'; }
}

// ---- ZAKAT PERDAGANGAN ----
function renderPerdagangan(r) {
    $('dagNisab').textContent = fmt(r.nisab);
    $('dagHarta').textContent = fmt(r.total_harta);
    $('dagStatus').textContent = r.wajib ? 'Wajib' : 'Belum wajib';
    $('dagStatus').className = 'font-extrabold ' + (r.wajib ? 'text-emerald-600' : 'text-amber-600') + ' text-sm';
    $('dagKet').textContent = r.keterangan;
    $('dagZakat').textContent = fmt(r.zakat);
}
async function calcPerdagangan() {
    const params = {
        modal: parseRupiah($('dagModal').value),
        piutang: parseRupiah($('dagPiutang').value),
        persediaan: parseRupiah($('dagPersediaan').value),
        utang: parseRupiah($('dagUtang').value),
        harga_emas: parseRupiah($('dagEmas').value),
        sudah_haul: $('dagHaul').checked
    };
    try { renderPerdagangan(await calcServer('zakat_perdagangan', params)); }
    catch(e){ $('dagStatus').textContent = 'Belum wajib'; }
}

// ---- WARIS (server) — versi login: OTOMATIS TERSIMPAN ----
async function calcWariq() {
    const jk = document.querySelector('input[name=pewarisJk]:checked').value;
    const params = {
        total_harta: parseRupiah($('wariqHarta').value),
        hutang: parseRupiah($('wariqHutang').value),
        biaya_pemakaman: parseRupiah($('wariqPemakaman').value),
        wasiat: parseRupiah($('wariqWasiat').value),
        pewaris_jk: jk,
        jumlah_anak_l: parseInt($('wariqAnakL').value||0),
        jumlah_anak_p: parseInt($('wariqAnakP').value||0),
        jumlah_cucu_l: parseInt($('wariqCucuL').value||0),
        jumlah_cucu_p: parseInt($('wariqCucuP').value||0),
        jumlah_saudara_l: parseInt($('wariqSaudaraL').value||0),
        jumlah_saudara_p: parseInt($('wariqSaudaraP').value||0),
        jumlah_saudara_seibu: parseInt($('wariqSaudaraSeibu').value||0),
        ada_ayah: $('wariqAyah').checked,
        ada_ibu: $('wariqIbu').checked,
        ada_kakek: $('wariqKakek').checked,
        ada_nenek_ibu: $('wariqNenekIbu').checked,
        ada_nenek_ayah: $('wariqNenekAyah').checked,
        ada_istri: $('wariqIstri').checked,
        ada_suami: $('wariqSuami').checked,
        save: 1 // versi login → simpan otomatis ke riwayat
    };
    try {
        const btn = $('wariqHitung');
        const labelAsli = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Menghitung...';
        $('wariqResult').innerHTML = '<div class="text-center text-olive/50 py-6"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Sedang menghitung, mohon tunggu...</div>';

        const r = await calcServer('wariq', params);
        btn.disabled = false;
        btn.innerHTML = labelAsli;
        const potongan = r.potongan && r.potongan.total > 0
            ? '<div class="mb-3 text-[10px] text-olive/70 leading-relaxed border-b border-cream2 pb-2">'
              + '<div class="flex justify-between"><span>Harta warisan</span><span class="font-bold">' + fmt(r.totalHarta) + '</span></div>'
              + (r.potongan.hutang > 0 ? '<div class="flex justify-between"><span>− Hutang</span><span>' + fmt(r.potongan.hutang) + '</span></div>' : '')
              + (r.potongan.biaya_pemakaman > 0 ? '<div class="flex justify-between"><span>− Biaya pemakaman</span><span>' + fmt(r.potongan.biaya_pemakaman) + '</span></div>' : '')
              + (r.potongan.wasiat > 0 ? '<div class="flex justify-between"><span>− Wasiat</span><span>' + fmt(r.potongan.wasiat) + '</span></div>' : '')
              + '<div class="flex justify-between font-bold text-oliveDark"><span>Harta bersih</span><span>' + fmt(r.hartaBersih) + '</span></div>'
              + '</div>'
            : '';
        let rows = (r.hasil||[]).map(h =>
            '<div class="flex items-center justify-between border-b border-cream2 pb-2 mb-2">'
            + '<div class="min-w-0"><div class="font-bold text-sm">' + h.ahli + '</div>'
            + '<div class="text-[10px] text-olive/60">' + h.persen + '% · porsi ' + (h.porsi * 24).toFixed(2) + '/24</div></div>'
            + '<div class="text-right shrink-0 ml-2"><div class="font-black text-olive text-sm">' + fmt(h.nilai) + '</div>'
            + '<div class="text-[9px] text-olive/50">rupiah</div></div></div>'
        ).join('');
        let total = (r.hasil||[]).length
            ? '<div class="mt-2 pt-2 border-t-2 border-olive/20 flex justify-between items-center">'
              + '<span class="font-extrabold text-xs text-oliveDark">TOTAL DIBAGIKAN</span>'
              + '<span class="font-black text-olive">' + fmt(r.hartaBersih) + ' <span class="text-[9px] font-normal text-olive/50">rupiah</span></span></div>'
            : '';
        let ket = (r.keterangan||[]).length
            ? '<div class="mt-3 pt-2 border-t border-cream2 text-[10px] text-olive/70 space-y-1">'
              + r.keterangan.map(k => '<div>• ' + k + '</div>').join('') + '</div>'
            : '';
        let savedBadge = r.saved ? '<div class="mt-3 bg-emerald-600 text-white rounded-lg px-2 py-1 text-[10px] font-bold text-center"><i class="fa-solid fa-check mr-1"></i>Tersimpan ke riwayat</div>' : '';
        $('wariqResult').innerHTML = potongan + rows + total + ket + savedBadge || '<div class="text-center text-olive/40 py-4">Tidak ada ahli waris.</div>';
        window.__wariqResult = r;
    } catch(e){
        const btn = $('wariqHitung');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-calculator mr-2"></i>Hitung Pembagian';
        $('wariqResult').innerHTML = '<div class="text-center text-red-400 py-4">Gagal: ' + e.message + '</div>';
    }
}
$('wariqHitung').addEventListener('click', calcWariq);

// Tampilkan hanya checkbox pasangan yang relevan sesuai jenis kelamin pewaris
function syncPasangan() {
    const jk = document.querySelector('input[name=pewarisJk]:checked').value;
    $('wariqIstriLabel').classList.toggle('hidden', jk !== 'L');
    $('wariqSuamiLabel').classList.toggle('hidden', jk !== 'P');
}
document.querySelectorAll('input[name=pewarisJk]').forEach(r => r.addEventListener('change', syncPasangan));
syncPasangan();

// ---- EVENT KALKULATOR BARU ----
$('penghasilanBulan').addEventListener('input', calcPenghasilan);
$('pertanianPanen').addEventListener('input', calcPertanian);
document.querySelectorAll('input[name=irigasi]').forEach(r => r.addEventListener('change', calcPertanian));
['dagModal','dagPiutang','dagPersediaan','dagUtang','dagEmas'].forEach(id => $(id).addEventListener('input', calcPerdagangan));
$('dagHaul').addEventListener('change', calcPerdagangan);

// ===================== KALKULATOR LAMA (client) =====================
function calcFitrah() {
    const jiwa = Math.max(1, parseInt($('fitrahJiwa').value||1));
    const jenis = document.querySelector('input[name=beras]:checked').value;
    const harga = jenis==='banjar' ? parseRupiah($('hargaBanjar').value) : parseRupiah($('hargaLain').value);
    const nama  = jenis==='banjar' ? 'Beras Banjar' : ($('namaBerasLain').value.trim()||'Beras Lain');
    const kg = 2.5*jiwa, liter = 3.5*jiwa, total = kg*harga;
    $('fitrahBeras').textContent = kg.toLocaleString('id-ID',{minimumFractionDigits:1}) + ' kg';
    $('fitrahLiter').textContent = '≈ ' + liter.toLocaleString('id-ID',{minimumFractionDigits:1}) + ' liter';
    $('fitrahJiwaOut').textContent = jiwa;
    $('fitrahRupiah').textContent = fmt(total);
    $('fitrahJenisLabel').textContent = nama + ' • Rp' + Number(harga).toLocaleString('id-ID') + '/kg';
    $('fitrahRincian').textContent = jiwa + ' jiwa × 2,5 kg × Rp' + Number(harga).toLocaleString('id-ID') + ' = ' + fmt(total);
    $('hargaBanjarBox').classList.toggle('hidden', jenis!=='banjar');
    $('hargaLainBox').classList.toggle('hidden', jenis!=='lain');
}
function calcMaal() {
    const harta = parseRupiah($('maalHarta').value);
    const emas = parseRupiah($('maalEmas').value);
    const nisab = 85*emas;
    const haul = document.querySelector('input[name=haul]:checked').value;
    const wajib = harta>=nisab && haul==='ya';
    const zakat = wajib ? Math.round(harta*0.025) : 0;
    $('maalNisab').textContent = fmt(nisab);
    $('maalHartaOut').textContent = fmt(harta);
    $('maalStatus').textContent = wajib ? 'Wajib zakat' : (haul!=='ya' ? 'Belum haul' : 'Belum mencapai nisab');
    $('maalStatus').className = 'font-extrabold ' + (wajib ? 'text-emerald-600' : 'text-amber-600') + ' text-sm';
    $('maalKet').textContent = wajib ? 'Harta mencapai nisab & haul.' : (haul!=='ya' ? 'Tunggu genap 1 tahun hijriah.' : 'Harta masih di bawah nisab.');
    $('maalZakat').textContent = fmt(zakat);
}
function calcFidyah() {
    const hari = Math.max(1, parseInt($('fidyahHari').value||1));
    const harga = parseRupiah($('fidyahHarga').value);
    const total = hari*harga;
    $('fidyahHariOut').textContent = hari;
    $('fidyahPerHari').textContent = fmt(harga);
    $('fidyahTotal').textContent = fmt(total);
    $('fidyahBerasOut').textContent = 'Setara beras: ' + (0.75*hari).toLocaleString('id-ID',{minimumFractionDigits:1}) + ' kg (' + hari + ' × 0,75 kg)';
}
function refresh(){ calcFitrah(); calcMaal(); calcFidyah(); }
document.querySelectorAll('#calc-panel-fitrah input, #calc-panel-maal input, #calc-panel-fidyah input').forEach(i => i.addEventListener('input', refresh));
document.querySelectorAll('input[name=beras], input[name=haul]').forEach(r => r.addEventListener('change', refresh));

// ===================== SIMPAN KE RIWAYAT =====================
document.querySelectorAll('[data-save-calc]').forEach(btn => {
    btn.addEventListener('click', async () => {
        const type = btn.dataset.saveCalc;
        let inputData = {}, resultData = {}, totalNilai = 0;

        if (type === 'zakat_fitrah') {
            const jiwa = Math.max(1, parseInt($('fitrahJiwa').value||1));
            const jenis = document.querySelector('input[name=beras]:checked').value;
            const harga = jenis==='banjar' ? parseRupiah($('hargaBanjar').value) : parseRupiah($('hargaLain').value);
            totalNilai = 2.5*jiwa*harga;
            inputData = { jiwa, jenis_beras: jenis==='banjar'?'Beras Banjar':($('namaBerasLain').value||'Beras Lain'), harga_per_kg: harga };
            resultData = { total_beras_kg: 2.5*jiwa, total_liter: 3.5*jiwa, total_rupiah: totalNilai };
        }
        else if (type === 'zakat_maal') {
            const harta = parseRupiah($('maalHarta').value), emas = parseRupiah($('maalEmas').value);
            const haul = document.querySelector('input[name=haul]:checked').value;
            const nisab = 85*emas, wajib = harta>=nisab && haul==='ya';
            totalNilai = wajib ? Math.round(harta*0.025) : 0;
            inputData = { harta, emas_per_gram: emas, haul };
            resultData = { nisab, status: wajib?'wajib':'tidak_wajib', zakat: totalNilai };
        }
        else if (type === 'fidyah') {
            const hari = Math.max(1, parseInt($('fidyahHari').value||1)), harga = parseRupiah($('fidyahHarga').value);
            totalNilai = hari*harga;
            inputData = { hari, harga_per_porsi: harga };
            resultData = { total_beras_kg: 0.75*hari, total_rupiah: totalNilai };
        }
        else if (type === 'wariq') {
            if (!window.__wariqResult) { alert('Klik "Hitung Pembagian" terlebih dahulu.'); return; }
            const r = window.__wariqResult;
            totalNilai = r.hartaBersih || r.totalHarta;
            inputData = {
                total_harta: r.totalHarta,
                hutang: r.potongan.hutang, biaya_pemakaman: r.potongan.biaya_pemakaman, wasiat: r.potongan.wasiat,
                pewaris_jk: document.querySelector('input[name=pewarisJk]:checked').value,
                jumlah_anak_l: parseInt($('wariqAnakL').value||0),
                jumlah_anak_p: parseInt($('wariqAnakP').value||0),
                jumlah_cucu_l: parseInt($('wariqCucuL').value||0),
                jumlah_cucu_p: parseInt($('wariqCucuP').value||0),
                jumlah_saudara_l: parseInt($('wariqSaudaraL').value||0),
                jumlah_saudara_p: parseInt($('wariqSaudaraP').value||0),
                jumlah_saudara_seibu: parseInt($('wariqSaudaraSeibu').value||0),
                ada_ayah: $('wariqAyah').checked,
                ada_ibu: $('wariqIbu').checked,
                ada_kakek: $('wariqKakek').checked,
                ada_nenek_ibu: $('wariqNenekIbu').checked,
                ada_nenek_ayah: $('wariqNenekAyah').checked,
                ada_istri: $('wariqIstri').checked,
                ada_suami: $('wariqSuami').checked
            };
            resultData = { hasil: r.hasil, harta_bersih: r.hartaBersih, total: r.hartaBersih };
        }
        else if (type === 'zakat_penghasilan') {
            const v = parseRupiah($('penghasilanBulan').value);
            const r = await calcServer('zakat_penghasilan', { penghasilan_bulan: v });
            totalNilai = r.zakat_bulanan;
            inputData = { penghasilan_bulan: v };
            resultData = { zakat_bulanan: r.zakat_bulanan, zakat_tahunan: r.zakat_tahunan, total: r.zakat_bulanan };
        }
        else if (type === 'zakat_pertanian') {
            const irigasi = document.querySelector('input[name=irigasi]:checked').value === 'ya';
            const v = parseRupiah($('pertanianPanen').value);
            const r = await calcServer('zakat_pertanian', { hasil_panen_kg: v, dengan_irigasi: irigasi });
            totalNilai = r.zakat;
            inputData = { hasil_panen_kg: v, dengan_irigasi: irigasi };
            resultData = { zakat: r.zakat, nisab: r.nisab, total: r.zakat };
        }
        else if (type === 'zakat_perdagangan') {
            const p = {
                modal: parseRupiah($('dagModal').value), piutang: parseRupiah($('dagPiutang').value),
                persediaan: parseRupiah($('dagPersediaan').value), utang: parseRupiah($('dagUtang').value),
                harga_emas: parseRupiah($('dagEmas').value), sudah_haul: $('dagHaul').checked
            };
            const r = await calcServer('zakat_perdagangan', p);
            totalNilai = r.zakat;
            inputData = p;
            resultData = { total_harta: r.total_harta, nisab: r.nisab, zakat: r.zakat, total: r.zakat };
        }

        // kirim ke endpoint simpan
        const body = new URLSearchParams();
        body.append('_token', CSRF);
        Object.entries(inputData).forEach(([k,v]) => body.append('input_data['+k+']', v));
        Object.entries(resultData).forEach(([k,v]) => {
            if (typeof v === 'object') body.append('result_data['+k+']', JSON.stringify(v));
            else body.append('result_data['+k+']', v);
        });
        body.append('total_nilai', totalNilai);

        try {
            const res = await fetch(ROUTE_SAVE.replace(':type', type), {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': CSRF },
                body: body.toString()
            });
            if (res.ok || res.redirected) {
                const old = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Tersimpan';
                btn.classList.add('bg-emerald-600');
                setTimeout(() => { btn.innerHTML = old; btn.classList.remove('bg-emerald-600'); window.location.reload(); }, 1200);
            } else alert('Gagal menyimpan riwayat.');
        } catch(e) { alert('Gagal menyimpan: ' + e.message); }
    });
});

// init: kalkulasi awal
calcFitrah(); calcMaal(); calcFidyah();
calcPenghasilan(); calcPertanian(); calcPerdagangan();
</script>
@endsection
