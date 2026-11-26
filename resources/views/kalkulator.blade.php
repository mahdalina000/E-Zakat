@extends('layouts.app')
@section('title', __('Kalkulator Zakat & Fidyah — E-Zakat Banjarbaru'))

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

    /* Warna label emas: hijau tua di mode terang, tetap emas di mode gelap */
    .text-emas-custom {
        color: #3b6d2e !important;
    }
    body.dark-mode .text-emas-custom {
        color: #D4AF37 !important;
    }

    body.dark-mode .bg-panel,
    body.dark-mode .bg-panel-2\/70,
    body.dark-mode .bg-panel-2 { 
        background-color: rgba(255, 255, 255, 0.12) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(255, 255, 255, 0.2) !important; 
    }

    /* PANEL BAZNAS RESMI — hijau solid di light, tetap kontras di dark */
    body.dark-mode .baznas-panel { 
        background-color: rgba(29, 91, 55, 0.92) !important; 
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        border-left: 4px solid #e2b356 !important;
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

    /* HILANGKAN SEMUA ELEMEN GLOW ORANYE DI BACKGROUND
       (hanya elemen amber/yellow; kotak bg-gold seperti "gram emas" TIDAK dihapus) */
    body > div > div[class*="amber"],
    body > div > div[class*="yellow"],
    body > div > div[class*="earth"],
    [class*="bg-amber"],
    [class*="bg-yellow-500"],
    [class*="from-amber"],
    [class*="from-yellow"] {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        background: none !important;
    }

    /* Sub-kartu hijau di dalam kartu hasil (bg-panel-2) — light: hijau pucat; dark: gelap */
    body.dark-mode .result-card-olive .bg-panel-2 {
        background-color: rgba(255, 255, 255, 0.10) !important;
        border-color: rgba(255, 255, 255, 0.18) !important;
    }
    body.dark-mode .result-card-olive .bg-panel-2 .text-black { color: #f8fafc; }

    /* KARTU HASIL PERHITUNGAN — profesional: gradient hijau + ornamen + aksen emas */
    .result-card-olive {
        position: relative;
        background: linear-gradient(135deg, #1d5b37 0%, #246c42 55%, #143d28 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.18) !important;
        border-left: 4px solid #e2b356 !important;
        box-shadow: 0 18px 40px -18px rgba(20, 61, 40, 0.55) !important;
        overflow: hidden;
    }
    /* ornamen bintang islami halus di belakang konten (kaya & tersebar agar tidak polos) */
    .result-card-olive::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 15% 22%, rgba(226,179,86,0.18) 2px, transparent 2.6px),
            radial-gradient(circle at 82% 78%, rgba(255,255,255,0.14) 1.6px, transparent 2.2px),
            radial-gradient(circle at 55% 15%, rgba(226,179,86,0.14) 1.8px, transparent 2.4px),
            radial-gradient(circle at 70% 45%, rgba(255,255,255,0.10) 1.5px, transparent 2.1px),
            radial-gradient(circle at 30% 85%, rgba(226,179,86,0.15) 1.9px, transparent 2.5px),
            radial-gradient(circle at 90% 20%, rgba(255,255,255,0.11) 1.4px, transparent 2px),
            radial-gradient(circle at 8% 60%, rgba(255,255,255,0.08) 1.3px, transparent 1.9px),
            radial-gradient(circle at 45% 55%, rgba(226,179,86,0.10) 1.7px, transparent 2.3px),
            radial-gradient(circle at 25% 40%, rgba(255,255,255,0.07) 1.2px, transparent 1.8px),
            radial-gradient(circle at 62% 90%, rgba(226,179,86,0.12) 1.5px, transparent 2.1px);
        background-size: 150px 150px, 190px 190px, 130px 130px,
                         220px 220px, 170px 170px, 140px 140px,
                         200px 200px, 160px 160px, 180px 180px,
                         240px 240px;
        background-position: 0 0, 50px 70px, 90px 20px, 30px 100px,
                             120px 50px, 70px 130px, 150px 90px,
                             40px 160px, 110px 10px, 160px 120px;
        opacity: 0.85;
        pointer-events: none;
    }
    .result-card-olive > * { position: relative; z-index: 1; }
    /* sub-kartu di dalam hasil — kaca */
    .result-card-olive .bg-panel-2 {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
    .result-card-olive .bg-black\/15 {
        background-color: rgba(0, 0, 0, 0.18) !important;
        border: 1px solid rgba(255, 255, 255, 0.10) !important;
    }
    .result-card-olive .bg-gold\/20 {
        background-color: rgba(226, 179, 86, 0.16) !important;
        border: 1px solid rgba(226, 179, 86, 0.35) !important;
        box-shadow: 0 8px 24px -10px rgba(226,179,86,0.45) !important;
    }
    body.dark-mode .result-card-olive {
        background: linear-gradient(135deg, #0d2417 0%, #123826 55%, #07160f 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.14) !important;
        border-left: 4px solid #e2b356 !important;
        box-shadow: 0 18px 44px -18px rgba(0,0,0,0.6) !important;
    }
    body.dark-mode .result-card-olive .bg-panel-2 {
        background-color: rgba(255, 255, 255, 0.07) !important;
        border-color: rgba(255, 255, 255, 0.14) !important;
    }
</style>
@endsection

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-6 space-y-4 overflow-x-hidden">
    <!-- HEADER TAB TIPE ZAKAT DALAM BLOK TRANSPARAN DENGAN ORNAMEN SVG -->
    <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm relative overflow-hidden eze-up">
        <svg class="absolute right-4 top-2 w-20 h-20 opacity-15 pointer-events-none text-gold2" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L15 8L21 9L17 14L18 20L12 17L6 20L7 14L3 9L9 8L12 2Z"/>
        </svg>

        <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
            <i class="fa-solid fa-calculator text-black"></i> {{ __('Kalkulator Zakat & Fidyah') }}
        </h1>
        <p class="text-xs lg:text-sm text-black/70 mt-1 font-medium">{{ __('Pilih jenis zakat, atur jumlah, dan lihat hasil perhitungan secara otomatis. Harga beras dapat disesuaikan.') }}</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button data-tab="fitrah" class="tab-btn bg-olive text-white px-5 py-2 rounded-full text-xs lg:text-sm font-bold shadow transition active:scale-95">{{ __('Zakat Fitrah') }}</button>
            <button data-tab="maal" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">{{ __('Zakat Maal') }}</button>
            <button data-tab="penghasilan" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">{{ __('Zakat Penghasilan') }}</button>
            <button data-tab="perniagaan" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">{{ __('Zakat Perniagaan') }}</button>
            <button data-tab="pertanian" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">{{ __('Zakat Pertanian') }}</button>
            <button data-tab="fidyah" class="tab-btn border border-cream3 text-black px-5 py-2 rounded-full text-xs lg:text-sm font-bold transition active:scale-95">{{ __('Fidyah') }}</button>
        </div>
    </div>

    {{-- FITRAH --}}
    <div id="panel-fitrah" class="tab-panel space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-wheat-awn text-black"></i> {{ __('Zakat Fitrah') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __("Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran: 2,5 kg beras atau 3,5 liter / jiwa (1 sha').") }}</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">{{ __('Jumlah Jiwa') }}</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fitrahMinus" type="button" class="w-10 h-10 shrink-0 rounded-full bg-panel-2 border border-cream3/70 text-black font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fitrahJiwa" type="number" min="1" value="1" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-panel-2">
                    <button id="fitrahPlus" type="button" class="w-10 h-10 shrink-0 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">{{ __('Jenis Beras') }}</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <label class="cursor-pointer min-w-0">
                        <input type="radio" name="beras" value="banjar" checked class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive border border-cream3/40 rounded-2xl p-2.5 lg:p-3 text-center transition shadow-sm overflow-hidden">
                            <div class="text-xs font-extrabold truncate">{{ __('Beras Banjar') }}</div>
                            <div class="text-[10px] opacity-80 truncate">{{ __('Premium lokal') }}</div>
                            <div class="text-[11px] lg:text-xs mt-1 font-bold truncate">Rp <span id="labelBanjar">{{ number_format($hargaBeras ?? 16500,0,',','.') }}</span>/kg</div>
                        </div>
                    </label>
                    <label class="cursor-pointer min-w-0">
                        <input type="radio" name="beras" value="lain" class="peer sr-only">
                        <div class="peer-checked:bg-olive peer-checked:text-white peer-checked:border-olive border border-cream3/40 rounded-2xl p-2.5 lg:p-3 text-center transition shadow-sm overflow-hidden">
                            <div class="text-xs font-extrabold truncate">{{ __('Beras Lain') }}</div>
                            <div class="text-[10px] opacity-80 truncate">{{ __('Atur harga') }}</div>
                            <div class="text-[11px] lg:text-xs mt-1 font-bold truncate">{{ __('Custom/kg') }}</div>
                        </div>
                    </label>
                </div>

                <div id="hargaBanjarBox" class="mt-4">
                    <label class="text-xs font-bold text-oliveDark">{{ __('Harga Beras Banjar (per kg)') }}</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-black shrink-0">Rp</span>
                        <input id="hargaBanjarFormatted" type="text" value="{{ number_format($hargaBeras ?? 16500,0,',','.') }}" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="hargaBanjar" type="hidden" value="{{ $hargaBeras ?? 16500 }}">
                    </div>
                </div>

                <div id="hargaLainBox" class="mt-4 hidden">
                    <label class="text-xs font-bold text-oliveDark">{{ __('Harga Beras Lain (per kg)') }}</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-xs font-bold text-black shrink-0">Rp</span>
                        <input id="hargaLainFormatted" type="text" value="14.000" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="hargaLain" type="hidden" value="14000">
                    </div>
                    <input id="namaBerasLain" placeholder="{{ __('Nama beras (opsional, mis. Beras Siam)') }}" class="mt-2 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2">
                </div>

                <div class="mt-5 p-3.5 rounded-2xl bg-panel-2/70 border border-panel-border text-[11px] text-oliveDark leading-relaxed">
                    <b class="text-black">{{ __('Cara pakai:') }} {{ __('Atur jumlah jiwa, pilih jenis beras, dan sesuaikan harga per kg. Hasil berubah otomatis. Boleh setor dalam bentuk beras atau uang (sesuai harga beras lokal).') }}
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN FITRAH DENGAN AKSEN WARTA EMAS -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between min-w-0">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL PERHITUNGAN') }}</div>
                    <h3 class="font-black text-2xl mt-1 text-white">{{ __('Zakat Fitrah') }}</h3>

                    <div class="mt-4 space-y-2">
                        <div class="bg-panel-2 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-white/20 space-y-1.5">
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Jumlah Jiwa') }}</span><span id="fitrahJiwaOut" class="font-bold text-white">1 {{ __('orang') }}</span></div>
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Total Beras') }}</span><span id="fitrahBeras" class="font-bold text-white">2,5 kg</span></div>
                            <div class="flex justify-between text-xs font-medium hidden sm:flex"><span class="text-white/80">{{ __('Setara Volume') }}</span><span id="fitrahLiter" class="font-bold text-white">≈ 3,5 liter</span></div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-3 sm:p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Setara Uang') }}</div>
                            <div id="fitrahRupiah" class="font-black text-xl sm:text-2xl text-gold2 mt-0.5">Rp 41.250</div>
                            <div id="fitrahJenisLabel" class="text-[10px] sm:text-[11px] text-white/90 mt-1 font-medium">{{ __('Beras Banjar • Rp16.500/kg') }}</div>
                        </div>

                        <div id="fitrahRincian" class="bg-black/15 backdrop-blur-md rounded-2xl p-2.5 border border-white/15 text-[10px] sm:text-[11px] text-white leading-snug hidden sm:block">
                            {{ __('• Per orang: Rp 41.250 (2,5 kg × Rp16.500/kg)') }}
                        </div>
                    </div>
                </div>
                <p class="text-[11px] text-white/80 mt-5 flex items-center gap-1.5 font-medium"><i class="fa-solid fa-clock text-xs text-gold2"></i> {{ __('Waktu utama: akhir Ramadhan hingga sebelum shalat Id.') }}</p>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Besaran Standar') }}</b>: {{ __('Sesuai Peraturan BAZNAS RI, zakat fitrah ditunaikan sebesar') }} <b>{{ __('2,5 kg atau 3,5 liter beras') }}</b> {{ __('(makanan pokok) per jiwa.') }}</li>
                <li><b>{{ __('Konversi Nilai Uang') }}</b>: {{ __('Ditentukan berdasarkan standar harga beras yang dikonsumsi sehari-hari dikalikan dengan besaran zakat per jiwa (2,5 kg × harga beras/kg).') }}</li>
                <li><b>{{ __('Kewajiban Jiwa') }}</b>: {{ __('Wajib dibayarkan untuk seluruh anggota keluarga yang menjadi tanggungan hidup sebelum shalat Idul Fitri.') }}</li>
            </ul>
        </div>
    </div>

    {{-- MAAL --}}
    <div id="panel-maal" class="tab-panel hidden space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-coins text-black"></i> {{ __('Zakat Maal (Harta)') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __('2,5% dari harta yang telah mencapai nisab (85 gr emas) dan haul 1 tahun.') }}</p>

                <div class="mt-3 p-3.5 rounded-2xl border-2 border-gold/50 bg-gold/10">
                    <label class="block text-xs font-extrabold text-emas-custom mb-1">
                        <i class="fa-solid fa-ring mr-1 text-emas-custom"></i> {{ __('Emas Milik Pribadi — Hitung Otomatis ke Rupiah') }}
                    </label>
                    <div class="flex items-center gap-2">
                        <input id="gramEmasInput" type="number" min="0" step="0.1" value="100" class="w-full min-w-0 border border-cream3 rounded-full px-3.5 py-2 text-xs font-bold bg-panel-2">
                        <span class="text-[10px] text-black/60 shrink-0">gram</span>
                    </div>
                    <div id="emasKonsiBox" class="mt-2.5 rounded-xl bg-panel-2 border border-panel-border p-3">
                        <div class="text-[10px] text-black/70 font-semibold uppercase tracking-wider">{{ __('Nilai Emas Anda (otomatis, tanpa tombol)') }}</div>
                        <div class="flex items-baseline gap-2 flex-wrap mt-1">
                            <span class="text-sm font-black text-oliveDark" id="emasKonsiTotal">Rp 130.000.000</span>
                            <span class="text-[10px] text-black/60">= <span id="emasKonsiGramLabel">100</span> gr × <span id="emasKonsiHarga">Rp 1.300.000</span>/gr</span>
                        </div>
                        <div class="text-[10px] text-black/70 mt-1.5 leading-relaxed">
                            {{ __('Nilai ini otomatis masuk ke kolom') }} <b>"{{ __('Total Harta') }}"</b> {{ __('di atas. Ubah gram atau harga emas → nilai & zakat-nya langsung terhitung. Cek status wajib di panel hasil (kanan).') }}
                        </div>
                    </div>
                    <div class="text-[10px] text-black/60 mt-2">
                        <i class="fa-solid fa-circle-info mr-1"></i> {{ __('Nisab BAZNAS 2026:') }} <b>{{ __('85 gr emas') }}</b> {{ __('Gram ≥ 85 →') }} <b>{{ __('Wajib Zakat') }}</b> {{ __('(2,5%).') }}
                    </div>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">{{ __('Harga Emas per gram (Rp)') }}</label>
                <div class="mt-1.5 flex items-center gap-2">
                    <span class="text-xs font-bold text-black shrink-0">Rp</span>
                    <input id="maalEmasFormatted" type="text" value="1.300.000" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                    <span class="text-[10px] text-black/60 shrink-0">/gram</span>
                </div>
                <input id="maalEmas" type="hidden" value="1300000">
                
                <label class="block mt-4 text-xs font-bold text-oliveDark">{{ __('Sudah haul 1 tahun?') }}</label>
                <div class="mt-2 flex gap-2">
                    <label class="flex-1 cursor-pointer min-w-0"><input type="radio" name="haul" value="ya" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold">{{ __('Ya') }}</div></label>
                    <label class="flex-1 cursor-pointer min-w-0"><input type="radio" name="haul" value="belum" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold">{{ __('Belum') }}</div></label>
                </div>

                {{-- Total Harta diletakkan paling bawah: hasil akhir dari semua isian di atas --}}
                <div class="mt-5 pt-4 border-t border-panel-border">
                    <label class="block text-xs font-extrabold text-oliveDark">{{ __('Total Harta (Rp)') }}</label>
                    <input id="maalHartaFormatted" type="text" value="100.000.000" class="mt-1.5 w-full min-w-0 border-2 border-olive/40 rounded-full px-4 py-2.5 text-sm bg-panel-2 font-black text-oliveDark">
                    <input id="maalHarta" type="hidden" value="100000000">
                    <p class="text-[10px] text-black/60 mt-1">
                        <i class="fa-solid fa-circle-info mr-1"></i> {{ __('Otomatis terisi dari gram emas di atas. Bisa juga diketik manual untuk menambah tabungan, deposito, atau harta lain.') }}
                    </p>
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN MAAL -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between min-w-0">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL ZAKAT MAAL') }}</div>
                    <h3 class="font-black text-2xl mt-1 text-white">{{ __('Zakat Harta') }}</h3>

                    <div class="mt-5 space-y-3">
                        <div class="bg-panel-2 backdrop-blur-md rounded-2xl p-4 border border-white/20 space-y-2">
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Nisab (85 gr emas)') }}</span><span id="maalNisab" class="font-bold text-gold2">Rp 110.500.000</span></div>
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Harta Anda') }}</span><span id="maalHartaOut" class="font-bold text-white">Rp 100.000.000</span></div>
                        </div>

                        <div class="bg-black/15 backdrop-blur-md rounded-2xl p-3.5 text-center border border-white/15">
                            <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">{{ __('Status Kewajiban') }}</div>
                            <div id="maalStatus" class="font-extrabold text-white text-base mt-0.5">{{ __('Belum wajib zakat') }}</div>
                            <div id="maalKet" class="text-[10px] text-white/80 mt-0.5">{{ __('Harta masih di bawah nisab.') }}</div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Zakat Yang Harus Dibayar (2,5%)') }}</div>
                            <div id="maalZakat" class="font-black text-2xl text-gold2 mt-0.5">Rp 0</div>
                            <div id="maalZakatGram" class="text-[10px] text-white/80 mt-1">{{ __('Setara 0,0 gram emas') }}</div>
                        </div>
                        <div class="text-[11px] text-white/80 leading-relaxed bg-black/15 rounded-2xl p-3.5 border border-white/15">
                            <b class="text-gold2">{{ __('Cara pakai:') }} {{ __('Masukkan total harta (tabungan, deposito, emas, barang dagang). Gunakan kotak') }} "{{ __('Hitung Dari Gram Emas') }}" {{ __('untuk menambah nilai emas. Status berubah') }} <b>{{ __('Wajib') }}</b> {{ __('jika harta ≥ nisab (85 gr) & sudah haul 1 tahun. Zakat = 2,5% dari harta.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Nisab Harta') }}</b>: {{ __('Mengikuti standar BAZNAS, nisab zakat maal adalah senilai') }} <b>{{ __('85 gram emas murni') }}</b> {{ __('(85 gram × harga pasaran emas per gram).') }}</li>
                <li><b>{{ __('Syarat Haul') }}</b>: {{ __('Kepemilikan harta harus sudah mencapai') }} <b>{{ __('1 tahun hijriah (haul)') }}</b> {{ __('dan bebas dari hutang jangka pendek yang jatuh tempo.') }}</li>
                <li><b>{{ __('Kadar Zakat') }}</b>: {{ __('Jika total gabungan simpanan/harta melebihi nisab dan sudah haul, dikenakan zakat sebesar') }} <b>{{ __('2,5%') }}</b> {{ __('dari total harta.') }}</li>
            </ul>
        </div>
    </div>

    {{-- PENGHASILAN --}}
    <div id="panel-penghasilan" class="tab-panel hidden space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-briefcase text-black"></i> {{ __('Zakat Penghasilan') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __('2,5% dari penghasilan bulanan yang mencapai nisab. Nisab:') }} <b>{{ __('Rp 7.640.144/bulan') }}</b> {{ __('(BAZNAS 2026, setara 85 gr emas).') }}</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">{{ __('Penghasilan Bersih / Bulan (Rp)') }}</label>
                <input id="penghasilanFormatted" type="text" value="7.640.144" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                <input id="penghasilan" type="hidden" value="7640144">

                <div class="mt-4 p-3 rounded-2xl border border-gold/30 bg-gold/5 text-[11px] text-black/80 leading-relaxed">
                    <i class="fa-solid fa-circle-info text-gold2 mr-1"></i>
                    {{ __('Zakat penghasilan dapat ditunaikan') }} <b>{{ __('setiap bulan') }}</b> {{ __('(Rp 7.640.144 nisab bulanan) atau') }} <b>{{ __('akhir tahun') }}</b> {{ __('(Rp 91.681.728 nisab tahunan).') }}
                </div>
            </div>

            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl min-w-0">
                <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL ZAKAT PENGHASILAN') }}</div>
                <h3 class="font-black text-2xl mt-1 text-white">2,5%</h3>
                <div class="mt-5 space-y-3">
                    <div class="bg-panel-2 rounded-2xl p-4 border border-white/20 space-y-2">
                        <div class="flex justify-between text-xs"><span class="text-white/80">{{ __('Nisab / bulan') }}</span><span id="penghasilanNisab" class="font-bold text-gold2">Rp 7.640.144</span></div>
                        <div class="flex justify-between text-xs"><span class="text-white/80">{{ __('Penghasilan Anda') }}</span><span id="penghasilanOut" class="font-bold text-white">Rp 7.640.144</span></div>
                    </div>
                    <div class="bg-black/15 rounded-2xl p-3.5 text-center border border-white/15">
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">{{ __('Status') }}</div>
                        <div id="penghasilanStatus" class="font-extrabold text-white text-base mt-0.5">{{ __('Wajib Zakat') }}</div>
                    </div>
                    <div class="bg-gold/20 rounded-2xl p-4 text-center border border-gold/40">
                        <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Zakat / Bulan') }}</div>
                        <div id="penghasilanZakat" class="font-black text-2xl text-gold2 mt-0.5">Rp 191.004</div>
                        <div id="penghasilanTahun" class="text-[10px] text-white/80 mt-1">{{ __('Setara Rp 0 / tahun') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Penentuan Nisab') }}</b>: {{ __('Mengikuti Keputusan Ketua BAZNAS RI Nomor 9 Tahun 2026, yaitu setara nilai 85 gram emas per tahun (Rp 91.681.728) atau') }} <b>{{ __('Rp 7.640.144 per bulan') }}</b>.</li>
                <li><b>{{ __('Pemeriksaan Syarat Wajib') }}</b>: {{ __('Jika penghasilan bersih bulanan Anda mencapai atau melebihi Rp 7.640.144, maka') }} <b>{{ __('Wajib Zakat') }}</b> {{ __('Jika di bawah nisab, maka tidak wajib.') }}</li>
                <li><b>{{ __('Kadar Zakat') }}</b>: {{ __('Sebesar') }} <b>{{ __('2,5%') }}</b> {{ __('dari total penghasilan kotor/bersih per bulan tanpa menunggu haul 1 tahun (dikeluarkan langsung saat menerima gaji/penghasilan).') }}</li>
            </ul>
        </div>
    </div>

    {{-- PERNIAGAAN --}}
    <div id="panel-perniagaan" class="tab-panel hidden space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-store text-black"></i> {{ __('Zakat Perniagaan') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __('2,5% dari harta bersih niaga setelah mencapai nisab') }} <b>{{ __('85 gr emas') }}</b>.</p>

                <div class="grid sm:grid-cols-2 gap-3 mt-5">
                    <div class="min-w-0">
                        <label class="block text-xs font-bold text-oliveDark">{{ __('Modal Diputar (Rp)') }}</label>
                        <input id="niagaModalFormatted" type="text" value="40.000.000" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="niagaModal" type="hidden" value="40000000">
                    </div>
                    <div class="min-w-0">
                        <label class="block text-xs font-bold text-oliveDark">{{ __('Keuntungan (Rp)') }}</label>
                        <input id="niagaUntungFormatted" type="text" value="10.000.000" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="niagaUntung" type="hidden" value="10000000">
                    </div>
                    <div class="min-w-0">
                        <label class="block text-xs font-bold text-oliveDark">{{ __('Piutang Lancar (Rp)') }}</label>
                        <input id="niagaPiutangFormatted" type="text" value="0" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="niagaPiutang" type="hidden" value="0">
                    </div>
                    <div class="min-w-0">
                        <label class="block text-xs font-bold text-oliveDark">{{ __('Utang Jatuh Tempo (Rp)') }}</label>
                        <input id="niagaUtangFormatted" type="text" value="10.000.000" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                        <input id="niagaUtang" type="hidden" value="10000000">
                    </div>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">{{ __('Harga Emas / gram (Rp)') }}</label>
                <div class="mt-1.5 flex items-center gap-2">
                    <span class="text-xs font-bold text-black shrink-0">Rp</span>
                    <input id="niagaEmasFormatted" type="text" value="1.300.000" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold">
                    <span class="text-[10px] text-black/60 shrink-0">/gram</span>
                </div>
                <input id="niagaEmas" type="hidden" value="1300000">

                <div class="mt-4 p-3.5 rounded-2xl border border-gold/30 bg-gold/5">
                    <div class="text-xs font-bold text-emas-custom flex items-center gap-1.5 mb-1.5">
                        <i class="fa-solid fa-ring text-emas-custom"></i> {{ __('Punya Emas? Hitung Gramnya') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="niagaGramEmas" type="number" placeholder="{{ __('Jumlah gram (mis. 200)') }}" class="w-1/2 min-w-0 border border-cream3 rounded-full px-3 py-1.5 text-xs font-semibold">
                        <button type="button" id="btnNiagaEmas" class="bg-gold hover:bg-gold text-white text-xs font-bold px-4 py-1.5 rounded-full transition shadow-sm active:scale-95 shrink-0">{{ __('Tambah ke Modal') }}</button>
                    </div>
                    <div class="text-[10px] text-black/60 mt-1.5">{{ __('Gram × harga emas = nilai emas, otomatis ditambah ke') }} "{{ __('Modal Diputar') }}".</div>
                </div>
            </div>

            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl min-w-0">
                <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL ZAKAT PERNIAGAAN') }}</div>
                <h3 class="font-black text-2xl mt-1 text-white">2,5%</h3>
                <div class="mt-5 space-y-3">
                    <div class="bg-panel-2 rounded-2xl p-4 border border-white/20 space-y-2 text-xs">
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Nisab (85 gr × harga emas)') }}</span><span id="niagaNisab" class="font-bold text-gold2">Rp 110.500.000</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Modal Diputar') }}</span><span id="niagaModalOut" class="font-bold text-white">Rp 40.000.000</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Keuntungan') }}</span><span id="niagaUntungOut" class="font-bold text-white">Rp 10.000.000</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Piutang Lancar') }}</span><span id="niagaPiutangOut" class="font-bold text-white">Rp 0</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Utang Jatuh Tempo') }}</span><span id="niagaUtangOut" class="font-bold text-white">Rp 10.000.000</span></div>
                        <div class="flex justify-between border-t border-white/20 pt-2"><span class="text-white/80 font-semibold">{{ __('Harta Bersih') }}</span><span id="niagaBersih" class="font-bold text-gold2">Rp 40.000.000</span></div>
                    </div>
                    <div class="bg-black/15 rounded-2xl p-3.5 text-center border border-white/15">
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">{{ __('Status') }}</div>
                        <div id="niagaStatus" class="font-extrabold text-white text-base mt-0.5">{{ __('Belum Wajib') }}</div>
                    </div>
                    <div class="bg-gold/20 rounded-2xl p-4 text-center border border-gold/40">
                        <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Zakat (2,5%)') }}</div>
                        <div id="niagaZakat" class="font-black text-2xl text-gold2 mt-0.5">Rp 0</div>
                    </div>
                    <div class="text-[11px] text-white/80 leading-relaxed bg-black/15 rounded-2xl p-3.5 border border-white/15">
                        <b class="text-gold2">{{ __('Cara pakai:') }} {{ __('Isi modal diputar, keuntungan, piutang lancar, dan utang jatuh tempo secara terpisah. Jika punya emas, isi gram lalu tekan') }} "{{ __('Tambah ke Modal') }}" {{ __('agar nilai emas ikut dihitung. Harta bersih = (modal + keuntungan + piutang) − utang. Zakat 2,5% hanya jika harta bersih ≥ nisab (85 gr emas).') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Rumus Harta Bersih Niaga') }}</b>: {{ __('(Modal Diputar + Keuntungan + Piutang Lancar) dikurangi (Utang Jatuh Tempo).') }}</li>
                <li><b>{{ __('Standar Nisab') }}</b>: {{ __('Setara nilai') }} <b>{{ __('85 gram emas') }}</b> {{ __('yang berlaku pada akhir tahun pembukuan usaha (haul 1 tahun).') }}</li>
                <li><b>{{ __('Kadar Zakat') }}</b>: {{ __('Apabila Nilai Harta Bersih ≥ Nisab (85 gr Emas), maka zakat yang wajib dikeluarkan sebesar') }} <b>{{ __('2,5%') }}</b>.</li>
            </ul>
        </div>
    </div>

    {{-- PERTANIAN --}}
    <div id="panel-pertanian" class="tab-panel hidden space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-wheat-awn text-black"></i> {{ __('Zakat Pertanian') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __('Nisab:') }} <b>{{ __('15,24 kuintal (960 kg)') }}</b> {{ __('hasil panen. Kadar:') }} <b>{{ __('5%') }}</b> {{ __('(tanpa irigasi) atau') }} <b>{{ __('2,5%') }}</b> {{ __('(dengan irigasi).') }}</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark">{{ __('Total Panen (kg)') }}</label>
                <div class="mt-1.5 flex items-center gap-2">
                    <input id="panenKg" type="number" value="1000" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold text-center">
                    <span class="text-xs font-bold text-black shrink-0">kg</span>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">{{ __('Sistem Irigasi') }}</label>
                <div class="mt-2 flex gap-2">
                    <label class="flex-1 cursor-pointer min-w-0"><input type="radio" name="irigasi" value="tidak" checked class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold truncate">{{ __('Tanpa Irigasi (5%)') }}</div></label>
                    <label class="flex-1 cursor-pointer min-w-0"><input type="radio" name="irigasi" value="ada" class="peer sr-only"><div class="peer-checked:bg-olive peer-checked:text-white border border-cream3/40 rounded-full py-2 text-center text-xs font-bold truncate">{{ __('Dengan Irigasi (2,5%)') }}</div></label>
                </div>

                <div class="mt-5 p-3.5 rounded-2xl bg-panel-2/70 border border-panel-border text-[11px] text-oliveDark leading-relaxed">
                    <b class="text-black">{{ __('Cara pakai:') }} {{ __('Isi total hasil panen dalam kg. Pilih irigasi:') }} <b>{{ __('Tanpa Irigasi') }}</b> {{ __('= kadar 5%,') }} <b>{{ __('Dengan Irigasi') }}</b> {{ __('= 2,5%. Wajib jika panen ≥ nisab 960 kg (15,24 kuintal).') }}
                </div>

                <div class="mt-4 p-3.5 rounded-2xl border border-gold/30 bg-gold/5 text-[11px] text-oliveDark leading-relaxed">
                    <div class="font-bold text-black flex items-center gap-1.5 mb-1.5">
                        <i class="fa-solid fa-circle-info text-gold2"></i> {{ __('Kategori Tanaman yang Dihitung') }}
                    </div>
                    <p class="mb-1.5">
                        {{ __('Zakat pertanian hanya dikenakan pada') }} <b>{{ __('tanaman makanan pokok') }}</b> {{ __('yang mengenyangkan dan menjadi bahan pangan utama, seperti') }} <b>{{ __('padi/gabah, jagung, gandum, kedelai, dan sagu') }}</b>.
                    </p>
                    <p class="mb-1.5">
                        {{ __('Sayuran, buah-buahan, dan rempah-rempah') }} <b>{{ __('tidak termasuk') }}</b> {{ __('zakat pertanian. Jika hasilnya dijual sebagai barang dagangan, maka dikenakan') }} <b>{{ __('zakat perdagangan') }}</b> {{ __('(tab Perniagaan).') }}
                    </p>
                    <p>
                        {{ __('Jika panen Anda berupa tanaman di luar makanan pokok, silakan gunakan tab') }} <b>{{ __('Zakat Perniagaan') }}</b> {{ __('atau') }} <b>{{ __('Zakat Maal') }}</b>.
                    </p>
                </div>
            </div>

            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl min-w-0">
                <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL ZAKAT PERTANIAN') }}</div>
                <h3 class="font-black text-2xl mt-1 text-white">{{ __('Panen') }}</h3>
                <div class="mt-5 space-y-3">
                    <div class="bg-panel-2 rounded-2xl p-4 border border-white/20 space-y-2 text-xs">
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Nisab') }}</span><span class="font-bold text-gold2">960 kg</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Panen Anda') }}</span><span id="pertanianPanen" class="font-bold text-white">1.000 kg</span></div>
                        <div class="flex justify-between"><span class="text-white/80">{{ __('Kadar') }}</span><span id="pertanianKadar" class="font-bold text-gold2">5%</span></div>
                    </div>
                    <div class="bg-black/15 rounded-2xl p-3.5 text-center border border-white/15">
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">{{ __('Status') }}</div>
                        <div id="pertanianStatus" class="font-extrabold text-white text-base mt-0.5">{{ __('Wajib Zakat') }}</div>
                    </div>
                    <div class="bg-gold/20 rounded-2xl p-4 text-center border border-gold/40">
                        <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Zakat Panen') }}</div>
                        <div id="pertanianZakat" class="font-black text-2xl text-gold2 mt-0.5">50 kg</div>
                    </div>
                    <div class="text-[11px] text-white/80 leading-relaxed bg-black/15 rounded-2xl p-3.5 border border-white/15 space-y-1">
                        <div class="font-bold text-gold2 text-xs"><i class="fa-solid fa-circle-info mr-1"></i> {{ __('Ketentuan Syariat Zakat Pertanian:') }}</div>
                        <ul class="list-disc list-inside space-y-1 text-white/90">
                            <li><b>{{ __('Waktu Dikeluarkan') }}</b>: {{ __('Zakat pertanian wajib ditunaikan') }} **{{ __('setiap kali panen') }}** {{ __('tidak menunggu haul (1 tahun).') }}</li>
                            <li><b>{{ __('Nisab') }}</b>: {{ __('Sebesar 5 wasaq (setara ±653 kg gabah/beras bersih atau 960 kg padi gabah kering panen).') }}</li>
                            <li><b>{{ __('Ketentuan Irigasi') }}</b>: {{ __('Kadar 10% jika mengandalkan air hujan/sungai alami, 5% jika mengalirkan air dengan biaya/pompa, dan 7,5% jika gabungan keduanya.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Nisab Panen') }}</b>: {{ __('Ditetapkan sebesar 5 wasaq atau setara') }} <b>{{ __('960 kg gabah/hasil panen') }}</b> {{ __('(atau ±653 kg jika makanan pokok bersih).') }}</li>
                <li><b>{{ __('Penentuan Kadar Zakat') }}</b>: {{ __('Sebesar') }} <b>{{ __('5%') }}</b> {{ __('apabila menggunakan sarana irigasi berbiaya/pompa, dan') }} <b>{{ __('10%') }}</b> {{ __('(atau 5% sesuai penyesuaian biaya operasional) jika mengandalkan air hujan alami.') }}</li>
                <li><b>{{ __('Tanpa Haul') }}</b>: {{ __('Zakat pertanian wajib dikeluarkan') }} <b>{{ __('langsung setiap kali masa panen') }}</b> {{ __('tanpa menunggu 1 tahun.') }}</li>
            </ul>
        </div>
    </div>

    {{-- FIDYAH --}}
    <div id="panel-fidyah" class="tab-panel hidden space-y-6 w-full overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-6 min-w-0">
            <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm min-w-0">
                <h2 class="font-extrabold text-oliveDark flex items-center gap-2 text-base"><i class="fa-solid fa-utensils text-black"></i> {{ __('Fidyah Puasa') }}</h2>
                <p class="text-xs text-black/70 mt-1">{{ __('Bagi yang tidak mampu berpuasa (sakit menahun, lansia). 1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan.') }}</p>

                <label class="block mt-5 text-xs font-bold text-oliveDark uppercase tracking-wider">{{ __('Jumlah hari yang ditinggalkan') }}</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fidyahMinus" type="button" class="w-10 h-10 shrink-0 rounded-full bg-panel-2 border border-cream3/70 text-black font-bold flex items-center justify-center hover:bg-cream3 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fidyahHari" type="number" min="1" value="7" class="w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-center font-black text-oliveDark text-base bg-panel-2">
                    <button id="fidyahPlus" type="button" class="w-10 h-10 shrink-0 rounded-full bg-olive text-white font-bold flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <label class="block mt-4 text-xs font-bold text-oliveDark">{{ __('Harga 1 porsi makan (Rp / porsi)') }}</label>
                <input id="fidyahHargaFormatted" type="text" value="45.000" class="mt-1.5 w-full min-w-0 border border-cream3 rounded-full px-4 py-2 text-xs bg-panel-2 font-bold" placeholder="14.000">
                <input id="fidyahHarga" type="hidden" value="45000">

                <div class="mt-4 flex items-center gap-2 bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                    <input id="fidyahModeBeras" type="checkbox" class="accent-olive rounded">
                    <label for="fidyahModeBeras" class="text-xs font-semibold text-oliveDark">{{ __('Hitung juga dalam beras (0,75 kg × hari)') }}</label>
                </div>

                <div class="mt-4 bg-panel-2/70 rounded-2xl p-3.5 border border-panel-border text-xs text-oliveDark leading-relaxed">
                    <div class="font-bold flex items-center gap-1.5 text-black">
                        <i class="fa-solid fa-circle-info"></i> {{ __('Catatan Bentuk Penyaluran Fidyah:') }}
                    </div>
                    <p class="mt-1 text-[11px] text-oliveDark/80">
                        {{ __('Fidyah tidak hanya dapat disalurkan dalam bentuk') }} <b>{{ __('uang tunai') }}</b> {{ __('atau') }} <b>{{ __('beras (0,75 kg/hari)') }}</b> {{ __('melainkan juga sangat dianjurkan berupa') }} <b>{{ __('porsi makanan siap saji lengkap beserta lauk-pauknya') }}</b> {{ __('yang dibagikan langsung kepada fakir dan miskin.') }}
                    </p>
                </div>
            </div>

            <!-- KARTU HASIL PERHITUNGAN FIDYAH -->
            <div class="result-card-olive rounded-[24px] p-6 text-white shadow-xl flex flex-col justify-between min-w-0">
                <div>
                    <div class="text-[10px] tracking-[0.18em] font-extrabold text-gold2 uppercase">{{ __('HASIL FIDYAH') }}</div>
                    <h3 class="font-black text-2xl mt-1 text-white">{{ __('Fidyah Puasa') }}</h3>

                    <div class="mt-4 space-y-2">
                        <div class="bg-panel-2 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-white/20 space-y-1.5">
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Jumlah Hari') }}</span><span id="fidyahHariOut" class="font-bold text-white">7 hari</span></div>
                            <div class="flex justify-between text-xs font-medium"><span class="text-white/80">{{ __('Per Hari') }}</span><span id="fidyahPerHari" class="font-bold text-white">Rp 45.000</span></div>
                        </div>

                        <div class="bg-gold/20 backdrop-blur-md rounded-2xl p-3 sm:p-4 text-center border border-gold/40 shadow-md">
                            <div class="text-[10px] text-gold2 uppercase tracking-wider font-bold">{{ __('Total Fidyah') }}</div>
                            <div id="fidyahTotal" class="font-black text-xl sm:text-2xl text-gold2 mt-0.5">Rp 315.000</div>
                            <div id="fidyahBerasOut" class="text-[10px] sm:text-[11px] text-white/90 mt-1 hidden"></div>
                        </div>

                        <div class="text-[11px] text-white/80 leading-relaxed bg-black/15 rounded-2xl p-3.5 border border-white/15">
                            <b class="text-gold2">{{ __('Fidyah:') }} {{ __('Bisa dibayar berupa uang (sesuai harga 1 porsi makan), ±0,75 kg beras/hari, atau makanan siap saji. Atur jumlah hari & harga per porsi.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOK PENJELASAN SOP BAZNAS UJUNG KE UJUNG -->
        <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm w-full">
            <div class="font-bold flex items-center gap-1.5 text-black text-xs lg:text-sm">
                <i class="fa-solid fa-book-open text-oliveDark"></i> {{ __('Penjelasan Cara Kerja Perhitungan (SOP BAZNAS):') }}
            </div>
            <ul class="mt-2 text-xs text-oliveDark/80 list-disc list-inside space-y-1">
                <li><b>{{ __('Kewajiban Per Hari') }}</b>: {{ __('Setiap 1 hari utang puasa Ramadhan yang ditinggalkan dibayar dengan') }} <b>{{ __('1 mud makanan pokok (±0,75 kg beras)') }}</b> {{ __('atau setara 1 porsi makan lengkap.') }}</li>
                <li><b>{{ __('Rumus Total') }}</b>: {{ __('(Jumlah Hari Utang Puasa) × (Harga 1 Porsi Makan Standar Lokal).') }}</li>
                <li><b>{{ __('Penyaluran Resmi') }}</b>: {{ __('Dikelola dan disalurkan kepada fakir miskin berupa paket makanan siap saji atau bahan makanan pokok.') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
window.ezOnReady(function () {
    try {
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
            } else if(hiddenId === 'penghasilan') {
                calcPenghasilan();
            } else if(hiddenId === 'niagaModal' || hiddenId === 'niagaUntung' || hiddenId === 'niagaPiutang' || hiddenId === 'niagaUtang' || hiddenId === 'niagaEmas') {
                calcNiaga();
            } else if(hiddenId === 'fidyahHarga') {
                calcFidyah();
            }
        });
    }

    formatCurrencyInput('hargaBanjarFormatted', 'hargaBanjar');
    formatCurrencyInput('hargaLainFormatted', 'hargaLain');
    formatCurrencyInput('maalHartaFormatted', 'maalHarta');
    formatCurrencyInput('maalEmasFormatted', 'maalEmas');
    formatCurrencyInput('fidyahHargaFormatted', 'fidyahHarga');

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
            • ${jiwa} orang × ${fmt(rupiahPerJiwa)} = <b class="text-white">${fmt(totalRupiah)}</b> (2,5 kg × Rp${Number(harga).toLocaleString('id-ID')}/kg)
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

    /* KONVERSI OTOMATIS gram emas → rupiah (tanpa tombol) */
    function calcGramEmasOtomatis() {
        const gram = parseFloat(document.getElementById('gramEmasInput').value || 0);
        const hargaEmas = parseInt(document.getElementById('maalEmas').value || 0);
        const totalNilai = gram * hargaEmas;

        document.getElementById('emasKonsiTotal').textContent = fmt(totalNilai);
        document.getElementById('emasKonsiGramLabel').textContent = gram || 0;
        document.getElementById('emasKonsiHarga').textContent = 'Rp ' + Number(hargaEmas).toLocaleString('id-ID');
        document.getElementById('emasKonsiBox').classList.remove('hidden');

        document.getElementById('maalHarta').value = totalNilai;
        document.getElementById('maalHartaFormatted').value = totalNilai ? Number(totalNilai).toLocaleString('id-ID') : '';
        calcMaal();
    }
    document.getElementById('gramEmasInput')?.addEventListener('input', calcGramEmasOtomatis);
    /* Saat harga emas diubah → konversi gram ulang otomatis */
    document.getElementById('maalEmas')?.addEventListener('input', calcGramEmasOtomatis);
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

    /* ================= ZAKAT PENGHASILAN ================= */
    const nisabPenghasilanBulan = 7640144; // BAZNAS 2026
    function calcPenghasilan() {
        const nilai = parseInt(document.getElementById('penghasilan').value || 0);
        const wajib = nilai >= nisabPenghasilanBulan;
        const zakat = wajib ? Math.round(nilai * 0.025) : 0;
        document.getElementById('penghasilanOut').textContent = fmt(nilai);
        document.getElementById('penghasilanStatus').textContent = wajib ? 'Wajib Zakat' : 'Belum Mencapai Nisab';
        document.getElementById('penghasilanZakat').textContent = fmt(zakat);
        document.getElementById('penghasilanTahun').textContent = fmt(zakat*12);
    }
    formatCurrencyInput('penghasilanFormatted','penghasilan');
    document.getElementById('penghasilan')?.addEventListener('input', calcPenghasilan);

    /* ================= ZAKAT PERNIAGAAN ================= */
    function calcNiaga() {
        const modal = parseInt(document.getElementById('niagaModal').value || 0);
        const untung = parseInt(document.getElementById('niagaUntung').value || 0);
        const piutang = parseInt(document.getElementById('niagaPiutang').value || 0);
        const utang = parseInt(document.getElementById('niagaUtang').value || 0);
        const emas  = parseInt(document.getElementById('niagaEmas').value || 0);
        const nisab = 85 * emas;
        const bersih = modal + untung + piutang - utang;
        const wajib = bersih >= nisab;
        const zakat = wajib ? Math.round(bersih * 0.025) : 0;
        document.getElementById('niagaNisab').textContent = fmt(nisab);
        document.getElementById('niagaModalOut').textContent = fmt(modal);
        document.getElementById('niagaUntungOut').textContent = fmt(untung);
        document.getElementById('niagaPiutangOut').textContent = fmt(piutang);
        document.getElementById('niagaUtangOut').textContent = fmt(utang);
        document.getElementById('niagaBersih').textContent = fmt(bersih);
        document.getElementById('niagaStatus').textContent = wajib ? 'Wajib Zakat' : 'Belum Wajib';
        document.getElementById('niagaZakat').textContent = fmt(zakat);
    }
    ['niagaModal','niagaUntung','niagaPiutang','niagaUtang','niagaEmas'].forEach(id => {
        const el = document.getElementById(id);
        if(el) el.addEventListener('input', calcNiaga);
    });
    formatCurrencyInput('niagaModalFormatted','niagaModal');
    formatCurrencyInput('niagaUntungFormatted','niagaUntung');
    formatCurrencyInput('niagaPiutangFormatted','niagaPiutang');
    formatCurrencyInput('niagaUtangFormatted','niagaUtang');
    formatCurrencyInput('niagaEmasFormatted','niagaEmas');

    document.getElementById('btnNiagaEmas')?.addEventListener('click', () => {
        const gram = parseFloat(document.getElementById('niagaGramEmas').value || 0);
        const hargaEmas = parseInt(document.getElementById('niagaEmas').value || 0);
        const nilaiEmas = Math.round(gram * hargaEmas);
        if(gram > 0) {
            const modal = parseInt(document.getElementById('niagaModal').value || 0);
            document.getElementById('niagaModal').value = modal + nilaiEmas;
            document.getElementById('niagaModalFormatted').value = Number(modal + nilaiEmas).toLocaleString('id-ID');
            calcNiaga();
        }
    });

    /* ================= ZAKAT PERTANIAN ================= */
    const nisabPertanian = 960; // kg (15,24 kuintal)
    function calcPertanian() {
        const panen = parseFloat(document.getElementById('panenKg').value || 0);
        const irigasi = document.querySelector('input[name="irigasi"]:checked');
        const kadar = irigasi?.value === 'ada' ? 0.025 : 0.05;
        const wajib = panen >= nisabPertanian;
        const zakat = wajib ? panen * kadar : 0;
        document.getElementById('pertanianPanen').textContent = Number(panen).toLocaleString('id-ID') + ' kg';
        document.getElementById('pertanianKadar').textContent = (kadar*100).toLocaleString('id-ID') + '%';
        document.getElementById('pertanianStatus').textContent = wajib ? 'Wajib Zakat' : 'Belum Mencapai Nisab';
        document.getElementById('pertanianZakat').textContent = fmtKg(zakat) + ' kg';
    }
    document.getElementById('panenKg')?.addEventListener('input', calcPertanian);
    document.querySelectorAll('input[name="irigasi"]').forEach(r => r.addEventListener('change', calcPertanian));

    calcFitrah();
    calcMaal();
    calcGramEmasOtomatis();
    calcPenghasilan();
    calcNiaga();
    calcPertanian();
    calcFidyah();

    } catch (e) { console.error('[Kalkulator] init error:', e); }});
</script>
@endsection