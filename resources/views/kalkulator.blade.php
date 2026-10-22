@extends('layouts.app')
@section('title','Kalkulator Zakat & Fidyah — E-Zakat Banjarbaru')

@section('head')
<style>
    /* HIJAU TRANSPARAN KHUSUS LIGHT MODE PADA BLOK INPUT KIRI */
    .bg-panel {
        background-color: rgba(75, 139, 59, 0.12) !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(75, 139, 59, 0.25) !important;
    }
    .bg-panel-2,
    .bg-panel-2\/70 {
        background-color: rgba(255, 255, 255, 0.6) !important;
        border-color: rgba(75, 139, 59, 0.2) !important;
    }

    /* Custom Rules Dark Mode — teks gelap jadi terang, aksen emas tetap terbaca */
    body.dark-mode .text-black,
    body.dark-mode .text-oliveDark { color: #f8fafc !important; }
    body.dark-mode .text-black\/80,
    body.dark-mode .text-black\/70,
    body.dark-mode .text-black\/60,
    body.dark-mode .text-black\/50 { color: #e2e8f0 !important; }
    body.dark-mode .text-oliveDark\/80,
    body.dark-mode .text-oliveDark\/70,
    body.dark-mode .text-oliveDark\/60 { color: #cbd5e1 !important; }
    /* Aksen emas di dark mode tetap terlihat (tidak jadi abu) */
    body.dark-mode .text-gold,
    body.dark-mode .text-gold2 { color: #D4AF37 !important; }
    body.dark-mode .text-earth { color: #F2C94C !important; }

    body.dark-mode .bg-panel,
    body.dark-mode .bg-panel-2\/70,
    body.dark-mode .bg-panel-2 { 
        background-color: rgba(255, 255, 255, 0.12) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(255, 255, 255, 0.2) !important; 
    }

    body.dark-mode input[type="number"],
    body.dark-mode input[type="text"] {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        color: #FFFFFF !important;
    }

    body.dark-mode #fitrahMinus,
    body.dark-mode #fidyahMinus {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
        color: #FFFFFF !important;
    }

    body.dark-mode .peer-checked\:bg-olive ~ div {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
        color: #E5E7EB !important;
    }

    body.dark-mode .peer:checked + div {
        background-color: #4b8b3b !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
        color: #FFFFFF !important;
    }

    /* HILANGKAN SEMUA ELEMEN GLOW ORANYE DI BACKGROUND */
    body > div > div[class*="amber"],
    body > div > div[class*="yellow"],
    body > div > div[class*="earth"],
    [class*="bg-amber"],
    [class*="bg-yellow-500"],
    [class*="bg-gold/"],
    [class*="from-amber"],
    [class*="from-yellow"] {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        background: none !important;
    }

    /* KARTU HASIL PERHITUNGAN (HIJAU OLIVE WITH AMBER ACCENT) */
    .result-card-olive {
        background-color: #4b8b3b !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-left: 4px solid #F59E0B !important;
    }
    body.dark-mode .result-card-olive {
        background-color: rgba(75, 139, 59, 0.4) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-left: 4px solid #F59E0B !important;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 w-full space-y-4">
    <!-- HEADER TAB TIPE ZAKAT DALAM BLOK TRANSPARAN DENGAN ORNAMEN SVG -->
    <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm relative overflow-hidden">
        <svg class="absolute right-4 top-2 w-20 h-20 opacity-15 pointer-events-none text-gold2" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L15 8L21 9L17 14L18 20L12 17L6 20L7 14L3 9L9 8L12 2Z"/>
        </svg>

        <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
            <i class="fa-solid fa-calculator text-black"></i> Kalkulator Zakat & Fidyah
        </h1>
        <p class="text-xs lg:text-sm text-black/70 mt-1 font-medium">Pilih jenis zakat, atur jumlah, dan lihat hasil perhitungan secara otomatis. Harga beras dapat disesuaikan.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button data-tab="fitrah" class="tab-btn bg-olive text-white px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow transition active:scale-95">Zakat Fitrah</button>
            <button data-tab="maal" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">Zakat Maal</button>
            <button data-tab="fidyah" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">Fidyah</button>
        </div>
    </div>

    {{-- FITRAH --}}
    <div id="panel-fitrah" class="tab-panel">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-wheat-awn text-black"></i> Zakat Fitrah</h2>
                <p class="text-xs text-black/70 mt-1">Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran: 2,5 kg beras atau 3,5 liter / jiwa (1 sha').</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jumlah Jiwa</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fitrahMinus" type="button" class="w-10 h-10 rounded-full bg-panel-2 border border-cream3/70 text-black font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fitrahJiwa" type="number" min="1" value="1" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-panel-2 border border-cream3/70">
                    <button id="fitrahPlus" type="button" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">Jenis Beras</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="banjar" checked class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive border border-cream3/40 rounded-2xl p-3 text-center transition shadow-sm">
                            <div class="text-xs font-extrabold">Beras Banjar</div>
                            <div class="text-[10px] opacity-80">Premium lokal</div>
                            <div class="text-xs mt-1 font-bold">Rp <span id="labelBanjar">{{ number_format($hargaBeras ?? 16500,0,',','.') }}</span> / kg</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="beras" value="lain" class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive border border-cream3/40 rounded-2xl p-3 text-center transition shadow-sm">
                            <div class="text-xs font-extrabold">Beras Lain</div>
                            <div class="text-[10px] opacity-80">Atur harga</div>
                            <div class="text-xs mt-1 font-bold">Custom / kg</div>
                        </div>
                    </label>
                </div>

                <div id="hargaBanjarBox" class="mt-4">
                    <label class="text-xs font-bold text-oliveDark">Harga Beras Banjar (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-black">Rp</span>
                        <input id="hargaBanjarFormatted" type="text" value="{{ number_format($hargaBeras ?? 16500,0,',','.') }}" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="hargaBanjar" type="hidden" value="{{ $hargaBeras ?? 16500 }}">
                    </div>
                </div>

                <div id="hargaLainBox" class="mt-4 hidden">
                    <label class="text-xs font-bold text-oliveDark">Harga Beras Lain (per kg)</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-black">Rp</span>
                        <input id="hargaLainFormatted" type="text" value="14.000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="hargaLain" type="hidden" value="14000">
                    </div>
                    <input id="namaBerasLain" placeholder="Nama beras (opsional, mis. Beras Siam)" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2">
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN FITRAH DENGAN AKSEN WARTA EMAS -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">HASIL PERHITUNGAN</div>
                    <h3 class="font-black text-2xl mt-1 text-white">Zakat Fitrah</h3>

                    <div class="mt-5 space-y-3">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 shadow-sm">
                                <div class="text-[10px] text-white/80 font-semibold uppercase tracking-wider">Total Beras</div>
                                <div id="fitrahBeras" class="font-black text-white text-xl mt-0.5">2,5 kg</div>
                                <div id="fitrahLiter" class="text-[10px] text-white/70 mt-0.5">≈ 3,5 liter</div>
                            </div>
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 shadow-sm">
                                <div class="text-[10px] text-white/80 font-semibold uppercase tracking-wider">Jiwa</div>
                                <div id="fitrahJiwaOut" class="font-black text-white text-xl mt-0.5">1</div>
                                <div class="text-[10px] text-white/70 mt-0.5">orang</div>
                            </div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">Setara Uang</div>
                            <div id="fitrahRupiah" class="font-black text-2xl text-gold2 mt-0.5">Rp 41.250</div>
                            <div id="fitrahJenisLabel" class="text-[11px] text-white/90 mt-1 font-medium">Beras Banjar • Rp16.500/kg</div>
                        </div>

                        <div id="fitrahRincian" class="bg-black/15 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-[11px] text-white leading-relaxed">
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-gold2 mb-1"><i class="fa-solid fa-thumbtack mr-1"></i> Rincian Satuan:</div>
                                <div>• <b>Per orang</b>: Rp 41.250 / orang (2,5 kg × Rp16.500/kg)</div>
                                <div>• <b>Total 1 orang</b>: 1 × Rp 41.250 = <b class="text-white">Rp 41.250</b></div>
                                <div>• Total beras: <b>2,5 kg</b> (2,5 kg/orang × 1 orang)</div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-[11px] text-white/80 mt-5 flex items-center gap-1.5 font-medium"><i class="fa-solid fa-clock text-xs text-gold2"></i> Waktu utama: akhir Ramadhan hingga sebelum shalat Id.</p>
            </div>
        </div>
    </div>

    {{-- MAAL --}}
    <div id="panel-maal" class="tab-panel hidden">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-coins text-black"></i> Zakat Maal (Harta)</h2>
                <p class="text-xs text-black/70 mt-1">2,5% dari harta yang telah mencapai nisab (85 gr emas) dan haul 1 tahun.</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">Total Harta (Rp)</label>
                <input id="maalHartaFormatted" type="text" value="100.000.000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                <input id="maalHarta" type="hidden" value="100000000">

                <div class="mt-3 p-3 rounded-2xl border border-gold/30 bg-gold/5">
                    <label class="block text-xs font-bold text-gold2 dark:text-gold2 mb-1">
                        <i class="fa-solid fa-scale-balanced mr-1"></i> Hitung Dari Gram Emas
                    </label>
                    <div class="flex items-center gap-2">
                        <input id="gramEmasInput" type="number" placeholder="Jumlah Gram (mis. 85)" class="w-1/2 border border-cream3 rounded-full px-3 py-1.5 text-xs font-semibold">
                        <button type="button" id="btnKonversiEmas" class="bg-gold hover:bg-gold text-white text-xs font-bold px-4 py-1.5 rounded-full transition shadow-sm active:scale-95">
                            Konversi ke Rp
                        </button>
                    </div>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">Harga Emas per gram (Rp)</label>
                <div class="mt-1.5 flex items-center gap-2">
                    <span class="text-xs font-bold text-black">Rp</span>
                    <input id="maalEmasFormatted" type="text" value="1.300.000" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                    <span class="text-[10px] text-black/60">/gram</span>
                </div>
                <input id="maalEmas" type="hidden" value="1300000">
                
                <div id="emasKonsiBox" class="mt-3 hidden bg-olive/5 border border-olive/30 rounded-2xl p-3">
                    <div class="text-xs font-bold text-black flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-check-double"></i> Hasil Konversi Gram Emas
                    </div>
                    <div class="text-sm font-black text-oliveDark" id="emasKonsiTotal">Rp 0</div>
                    <div class="text-[10px] text-black/70 mt-0.5">Tersimpan ke kolom "Total Harta" di atas — silakan cek status wajib zakat di panel samping.</div>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">Sudah haul 1 tahun?</label>
                <div class="mt-2 flex gap-2">
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold">Ya</div></label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="haul" value="belum" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold">Belum</div></label>
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN MAAL -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">HASIL ZAKAT MAAL</div>
                    <h3 class="font-black text-2xl mt-1 text-white">Zakat Harta</h3>

                    <div class="mt-5 space-y-3">
                        <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 border border-white/20 space-y-2">
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">Nisab (85 gr emas)</span><span id="maalNisab" class="font-bold text-gold2">Rp 110.500.000</span></div>
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">Harta Anda</span><span id="maalHartaOut" class="font-bold text-white">Rp 100.000.000</span></div>
                        </div>

                        <div class="bg-black/15 backdrop-blur-md rounded-2xl p-3.5 text-center border border-white/15">
                            <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Status Kewajiban</div>
                            <div id="maalStatus" class="font-extrabold text-white text-base mt-0.5">Belum wajib zakat</div>
                            <div id="maalKet" class="text-[10px] text-white/80 mt-0.5">Harta masih di bawah nisab.</div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">Zakat Yang Harus Dibayar (2,5%)</div>
                            <div id="maalZakat" class="font-black text-2xl text-gold2 mt-0.5">Rp 0</div>
                            <div id="maalZakatGram" class="text-[10px] text-white/80 mt-1">Setara 0,0 gram emas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FIDYAH --}}
    <div id="panel-fidyah" class="tab-panel hidden">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-utensils text-black"></i> Fidyah Puasa</h2>
                <p class="text-xs text-black/70 mt-1">Bagi yang tidak mampu berpuasa (sakit menahun, lansia). 1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan.</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">Jumlah hari yang ditinggalkan</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fidyahMinus" type="button" class="w-10 h-10 rounded-full bg-panel-2 border border-cream3/70 text-black font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fidyahHari" type="number" min="1" value="7" class="flex-1 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-panel-2 border border-cream3/70">
                    <button id="fidyahPlus" type="button" class="w-10 h-10 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">Harga 1 porsi makan (Rp)</label>
                <input id="fidyahHarga" type="number" value="45000" class="mt-1.5 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">

                <div class="mt-4 flex items-center gap-2 bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                    <input id="fidyahModeBeras" type="checkbox" class="accent-olive rounded">
                    <label for="fidyahModeBeras" class="text-xs font-semibold text-oliveDark">Hitung juga dalam beras (0,75 kg × hari)</label>
                </div>

                <div class="mt-4 bg-panel-2/70 rounded-2xl p-3.5 border border-panel-border text-xs text-oliveDark leading-relaxed">
                    <div class="font-bold flex items-center gap-1.5 text-black">
                        <i class="fa-solid fa-circle-info"></i> Catatan Bentuk Penyaluran Fidyah:
                    </div>
                    <p class="mt-1 text-[11px] text-oliveDark/80">
                        Fidyah tidak hanya dapat disalurkan dalam bentuk <b>uang tunai</b> atau <b>beras (0,75 kg/hari)</b>, melainkan juga sangat dianjurkan berupa <b>porsi makanan siap saji lengkap beserta lauk-pauknya</b> yang dibagikan langsung kepada fakir dan miskin.
                    </p>
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN FIDYAH -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">HASIL FIDYAH</div>
                    <h3 class="font-black text-2xl mt-1 text-white">Fidyah Puasa</h3>

                    <div class="mt-5 space-y-3">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 shadow-sm">
                                <div class="text-[10px] text-white/80 font-semibold uppercase tracking-wider">Hari</div>
                                <div id="fidyahHariOut" class="font-black text-white text-xl mt-0.5">7</div>
                                <div class="text-[10px] text-white/70 mt-0.5">hari</div>
                            </div>
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 shadow-sm">
                                <div class="text-[10px] text-white/80 font-semibold uppercase tracking-wider">Per Hari</div>
                                <div id="fidyahPerHari" class="font-black text-white text-base mt-0.5">Rp 45.000</div>
                                <div class="text-[10px] text-white/70 mt-0.5">1 porsi</div>
                            </div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">Total Fidyah</div>
                            <div id="fidyahTotal" class="font-black text-2xl text-gold2 mt-0.5">Rp 315.000</div>
                            <div id="fidyahBerasOut" class="text-[11px] text-white/90 mt-1 hidden"></div>
                        </div>

                        <div class="bg-black/15 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-[11px] text-white leading-relaxed space-y-1">
                            <div class="font-bold text-gold2 text-xs"><i class="fa-solid fa-utensils mr-1"></i> Fidyah bisa disalurkan dalam 3 bentuk:</div>
                            <ul class="list-disc list-inside space-y-0.5 ml-1 text-white/90">
                                <li><b>Uang</b>: Sesuai harga 1 porsi makan.</li>
                                <li><b>Beras</b>: ±0,75 kg per hari puasa.</li>
                                <li><b>Makanan siap saji</b>: 1 porsi lengkap dibagikan langsung.</li>
                            </ul>
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
document.addEventListener("DOMContentLoaded", function () {
    const fmt = n => 'Rp ' + Number(n).toLocaleString('id-ID');
    const fmtKg = n => Number(n).toLocaleString('id-ID', {minimumFractionDigits:1, maximumFractionDigits:1});

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.className = 'tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition';
            });
            btn.className = 'tab-btn bg-olive text-white px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow transition';
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            document.getElementById('panel-' + btn.dataset.tab).classList.remove('hidden');
        });
    });

    function formatCurrencyInput(formattedId, hiddenId) {
        const formattedEl = document.getElementById(formattedId);
        const hiddenEl = document.getElementById(hiddenId);
        if(!formattedEl || !hiddenEl) return;

        formattedEl.addEventListener('input', e => {
            let raw = e.target.value.replace(/\D/g, '');
            hiddenEl.value = raw || 0;
            e.target.value = raw ? Number(raw).toLocaleString('id-ID') : '';
            
            if(hiddenId === 'hargaBanjar' || hiddenId === 'hargaLain') {
                calcFitrah();
            } else if(hiddenId === 'maalHarta' || hiddenId === 'maalEmas') {
                calcMaal();
            }
        });
    }

    formatCurrencyInput('hargaBanjarFormatted', 'hargaBanjar');
    formatCurrencyInput('hargaLainFormatted', 'hargaLain');
    formatCurrencyInput('maalHartaFormatted', 'maalHarta');
    formatCurrencyInput('maalEmasFormatted', 'maalEmas');

    function calcFitrah() {
        const jiwaInput = document.getElementById('fitrahJiwa');
        if(!jiwaInput) return;

        const jiwa = Math.max(1, parseInt(jiwaInput.value || 1));
        const berasChecked = document.querySelector('input[name="beras"]:checked');
        const beras = berasChecked ? berasChecked.value : 'banjar';
        
        const hargaBanjarInput = document.getElementById('hargaBanjar');
        const hargaLainInput = document.getElementById('hargaLain');
        const harga = beras === 'banjar' 
            ? parseInt(hargaBanjarInput ? hargaBanjarInput.value : 16500) 
            : parseInt(hargaLainInput ? hargaLainInput.value : 14000);
            
        const namaLainInput = document.getElementById('namaBerasLain');
        const nama = beras === 'banjar' ? 'Beras Banjar' : ((namaLainInput && namaLainInput.value.trim()) || 'Beras Lain');

        const kgPerJiwa = 2.5;
        const totalKg = kgPerJiwa * jiwa;
        const totalRupiah = totalKg * harga;
        const rupiahPerJiwa = kgPerJiwa * harga;

        document.getElementById('fitrahBeras').textContent = fmtKg(totalKg) + ' kg';
        document.getElementById('fitrahLiter').textContent = '≈ ' + fmtKg(3.5 * jiwa) + ' liter';
        document.getElementById('fitrahJiwaOut').textContent = jiwa;
        document.getElementById('fitrahRupiah').textContent = fmt(totalRupiah);
        document.getElementById('fitrahJenisLabel').textContent = nama + ' • Rp' + Number(harga).toLocaleString('id-ID') + '/kg';

        document.getElementById('fitrahRincian').innerHTML = `
            <div class="space-y-1">
                <div class="text-xs font-bold text-gold2 mb-1"><i class="fa-solid fa-thumbtack mr-1"></i> Rincian Satuan:</div>
                <div>• <b>Per orang</b>: ${fmt(rupiahPerJiwa)} / orang (2,5 kg × Rp${Number(harga).toLocaleString('id-ID')}/kg)</div>
                <div>• <b>Total ${jiwa} orang</b>: ${jiwa} × ${fmt(rupiahPerJiwa)} = <b class="text-white">${fmt(totalRupiah)}</b></div>
                <div>• Total beras: <b>${fmtKg(totalKg)} kg</b> (${kgPerJiwa} kg/orang × ${jiwa} orang)</div>
            </div>
        `;

        document.getElementById('hargaBanjarBox').classList.toggle('hidden', beras !== 'banjar');
        document.getElementById('hargaLainBox').classList.toggle('hidden', beras !== 'lain');
    }

    ['fitrahJiwa','hargaBanjar','hargaLain','namaBerasLain'].forEach(id => {
        const el = document.getElementById(id);
        if(el) el.addEventListener('input', calcFitrah);
    });
    document.querySelectorAll('input[name="beras"]').forEach(r => r.addEventListener('change', calcFitrah));
    
    document.getElementById('fitrahMinus')?.addEventListener('click', () => {
        const input = document.getElementById('fitrahJiwa');
        input.value = Math.max(1, parseInt(input.value || 1) - 1);
        calcFitrah();
    });
    document.getElementById('fitrahPlus')?.addEventListener('click', () => {
        const input = document.getElementById('fitrahJiwa');
        input.value = parseInt(input.value || 1) + 1;
        calcFitrah();
    });

    document.getElementById('btnKonversiEmas')?.addEventListener('click', () => {
        const gram = parseFloat(document.getElementById('gramEmasInput').value || 0);
        const hargaEmas = parseInt(document.getElementById('maalEmas').value || 0);
        const totalNilai = gram * hargaEmas;
        if(gram > 0) {
            document.getElementById('maalHarta').value = totalNilai;
            document.getElementById('maalHartaFormatted').value = Number(totalNilai).toLocaleString('id-ID');
            document.getElementById('emasKonsiTotal').textContent = fmt(totalNilai);
            document.getElementById('emasKonsiBox').classList.remove('hidden');
            calcMaal();
        }
    });

    document.getElementById('maalHartaFormatted')?.addEventListener('input', () => {
        document.getElementById('emasKonsiBox').classList.add('hidden');
    });

    function calcMaal() {
        const harta = parseInt(document.getElementById('maalHarta').value || 0);
        const emas = parseInt(document.getElementById('maalEmas').value || 0);
        const nisab = 85 * emas;
        const haulChecked = document.querySelector('input[name="haul"]:checked');
        const haul = haulChecked ? haulChecked.value : 'ya';
        const wajib = harta >= nisab && haul === 'ya';
        const zakat = wajib ? Math.round(harta * 0.025) : 0;

        document.getElementById('maalNisab').textContent = fmt(nisab);
        document.getElementById('maalHartaOut').textContent = fmt(harta);
        document.getElementById('maalStatus').textContent = wajib ? 'Wajib Zakat' : (haul !== 'ya' ? 'Belum Haul' : 'Belum Mencapai Nisab');
        document.getElementById('maalKet').textContent = wajib ? 'Harta telah mencapai nisab dan haul.' : (haul !== 'ya' ? 'Tunggu genap 1 tahun hijriah.' : 'Harta masih di bawah nisab.');
        document.getElementById('maalZakat').textContent = fmt(zakat);
        const gramZakat = emas > 0 ? (zakat / emas) : 0;
        document.getElementById('maalZakatGram').textContent = 'Setara ' + fmtKg(gramZakat) + ' gram emas';
    }
    document.querySelectorAll('input[name="haul"]').forEach(r => r.addEventListener('change', calcMaal));

    function calcFidyah() {
        const hari = Math.max(1, parseInt(document.getElementById('fidyahHari').value || 1));
        const harga = parseInt(document.getElementById('fidyahHarga').value || 0);
        const total = hari * harga;
        const berasKg = 0.75 * hari;

        document.getElementById('fidyahHariOut').textContent = hari;
        document.getElementById('fidyahPerHari').textContent = fmt(harga);
        document.getElementById('fidyahTotal').textContent = fmt(total);

        const box = document.getElementById('fidyahBerasOut');
        if(document.getElementById('fidyahModeBeras').checked) {
            box.textContent = 'Setara beras: ' + fmtKg(berasKg) + ' kg (' + hari + ' × 0,75 kg)';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    ['fidyahHari','fidyahHarga'].forEach(id => {
        const el = document.getElementById(id);
        if(el) el.addEventListener('input', calcFidyah);
    });
    document.getElementById('fidyahModeBeras')?.addEventListener('change', calcFidyah);
    document.getElementById('fidyahMinus')?.addEventListener('click', () => {
        const input = document.getElementById('fidyahHari');
        input.value = Math.max(1, parseInt(input.value || 1) - 1);
        calcFidyah();
    });
    document.getElementById('fidyahPlus')?.addEventListener('click', () => {
        const input = document.getElementById('fidyahHari');
        input.value = parseInt(input.value || 1) + 1;
        calcFidyah();
    });

    calcFitrah();
    calcMaal();
    calcFidyah();
});
</script>
@endsection