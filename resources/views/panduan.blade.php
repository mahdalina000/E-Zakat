@extends('layouts.app')
@section('title','Panduan Zakat — E-Zakat Banjarbaru')

@section('head')
<style>
    /* KONSISTENSI PANEL PADA LIGHT MODE */
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
    body.dark-mode .text-black\/70,
    body.dark-mode .text-black\/60,
    body.dark-mode .text-black\/50 { color: #e2e8f0 !important; }
    body.dark-mode .text-oliveDark\/70,
    body.dark-mode .text-oliveDark\/60 { color: #cbd5e1 !important; }
    
    /* Aksen emas di dark mode */
    body.dark-mode .text-gold,
    body.dark-mode .text-gold2 { color: #D4AF37 !important; }
    body.dark-mode .bg-gold\/15 { background-color: rgba(212,175,55,0.20) !important; }
    body.dark-mode .border-gold\/40 { border-color: rgba(212,175,55,0.45) !important; }
    
    /* BLOK PUTIH TRANSPARAN SAAT DARK MODE */
    body.dark-mode .bg-panel,
    body.dark-mode .bg-panel-2\/70,
    body.dark-mode .bg-panel-2 { 
        background-color: rgba(255, 255, 255, 0.12) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(255, 255, 255, 0.2) !important; 
    }

    /* MENYEMBUNYIKAN SEMUA GLOW ORANYE/KUNING DI BACKGROUND LAYOUT INDUK
       (kotak bg-gold seperti panel "gram emas" TIDAK dihapus) */
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

    /* BLOK LAFAL NIAT — HIJAU (selaras panel lain), bukan putih */
    .bg-niat-box {
        background-color: rgba(36, 108, 66, 0.12) !important;
        border: 1px solid rgba(36, 108, 66, 0.30) !important;
    }
    body.dark-mode .bg-niat-box {
        background-color: rgba(255, 255, 255, 0.10) !important;
        border-color: rgba(212, 175, 55, 0.40) !important;
    }
    /* TEKS ARAB (Amiri) — di LIGHT: hitam pekat. DI DARK: hijau muda terang. */
    .bg-niat-box .font-amiri {
        color: #0c1f14 !important;
        font-size: 1.35rem;
        line-height: 2;
    }
    body.dark-mode .bg-niat-box .font-amiri {
        color: #d7f0dc !important;
    }

    /* KONTROL UKURAN ORNAMEN */
    .ornamen-small {
        width: 60px !important;
        height: auto !important;
        opacity: 0.35;
        pointer-events: none;
        position: absolute;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 w-full space-y-4">

    <!-- HEADER PANDUAN DENGAN BLOK TRANSPARAN SERTA AKSELERASI ORNAMEN -->
    <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm relative overflow-hidden anim-smooth delay-1">
        <svg class="absolute right-4 top-2 w-20 h-20 opacity-15 pointer-events-none text-gold2" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L15 8L21 9L17 14L18 20L12 17L6 20L7 14L3 9L9 8L12 2Z"/>
        </svg>

        <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
            <i class="fa-solid fa-book-quran text-black"></i> Panduan Zakat Lengkap
        </h1>
        <p class="text-xs lg:text-sm text-black/70 mt-1 font-medium">Pahami niat, syarat, waktu, besaran, 8 asnaf, dalil, dan tanya jawab — ringkas dan sesuai rujukan syariat.</p>
        <div class="mt-4 flex flex-wrap gap-2 text-xs">
            <a href="#niat" class="bg-olive text-white border border-olive px-3.5 py-1.5 rounded-full font-bold shadow-sm hover-smooth">Niat</a>
            <a href="#fitrah" class="bg-panel-2 border border-panel-border px-3.5 py-1.5 rounded-full text-oliveDark font-bold hover:bg-olive hover:text-white transition shadow-sm">Zakat Fitrah</a>
            <a href="#asnaf" class="bg-panel-2 border border-panel-border px-3.5 py-1.5 rounded-full text-oliveDark font-bold hover:bg-olive hover:text-white transition shadow-sm">8 Asnaf</a>
            <a href="#maal" class="bg-panel-2 border border-panel-border px-3.5 py-1.5 rounded-full text-oliveDark font-bold hover:bg-olive hover:text-white transition shadow-sm">Zakat Maal</a>
            <a href="#fidyah" class="bg-panel-2 border border-panel-border px-3.5 py-1.5 rounded-full text-oliveDark font-bold hover:bg-olive hover:text-white transition shadow-sm">Fidyah</a>
            <a href="#faq" class="bg-panel-2 border border-panel-border px-3.5 py-1.5 rounded-full text-oliveDark font-bold hover:bg-olive hover:text-white transition shadow-sm">FAQ</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_300px] gap-6">
        <div class="space-y-6">
            {{-- Niat --}}
            <div id="niat" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-2 shadow-sm">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm font-black">1</span> Niat Zakat
                </h2>
                <p class="text-xs text-black/70 mt-1">Niat di dalam hati; melafalkan membantu menguatkan. Berikut lafal yang umum diajarkan ulama.</p>

                <div class="mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-niat-box rounded-2xl p-4 border border-panel-border">
                        <div class="text-[10px] font-extrabold tracking-wider text-gold2 uppercase">NIAT ZAKAT FITRAH UNTUK DIRI SENDIRI</div>
                        <div class="font-amiri text-oliveDark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُّ أُنْ أُخْرِجَ زَكَاةَ الِافْطِرِ عَنِ نَفْسِي فَرْضًا لِلهِ تَعَالَى</div>
                        <div class="text-xs text-gold2 mt-2 italic font-semibold">"Nawaitu an ukhrija zakatal fitri 'an nafsi fardhan lillahi ta'ala"</div>
                        <div class="text-[11px] text-black/70 mt-1">Artinya: Aku berniat mengeluarkan zakat fitrah untuk diriku sendiri, fardu karena Allah Ta'ala.</div>
                    </div>

                    <div class="bg-niat-box rounded-2xl p-4 border border-panel-border">
                        <div class="text-[10px] font-extrabold tracking-wider text-gold2 uppercase">NIAT ZAKAT FITRAH UNTUK KELUARGA</div>
                        <div class="font-amiri text-oliveDark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُّ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَنِّي وَعَنْ جَمِيعِ مَنْ تَلْزَمُنِي نَفَقَتُهُ فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-xs text-gold2 mt-2 italic font-semibold">"Nawaitu an ukhrija zakatal fitri 'anni wa 'an jami'i man talzmunni nafaqatuhu fardhan lillahi ta'ala"</div>
                        <div class="text-[11px] text-black/70 mt-1">Untuk kepala keluarga yang menanggung istri/anak.</div>
                    </div>
                </div>
            </div>

            {{-- Zakat Fitrah --}}
            <div id="fitrah" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-3 shadow-sm border-l-4 border-l-gold">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm">2</span> Zakat Fitrah
                </h2>
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-2.5">
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Hukum</div><div class="text-black/70 mt-0.5">Wajib bagi setiap muslim — laki/perempuan, dewasa/anak, merdeka/budak — yang memiliki kelebihan makanan pokok di malam & hari Id.</div></div>
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Besaran</div><div class="text-black/70 mt-0.5">1 sha' = <b>2,5 kg beras</b> (atau 3,5 liter) per jiwa. Di Banjarbaru default <b>Beras Banjar</b>; boleh beras lain dengan harga setara.</div></div>
                    </div>
                    <div class="bg-olive text-white rounded-2xl p-4 flex flex-col justify-between shadow-md border-l-4 border-l-gold2">
                        <div>
                            <div class="text-[10px] text-gold2 font-extrabold uppercase tracking-wider">CONTOH CEPAT</div>
                            <div class="font-bold mt-1">Keluarga 4 jiwa × Beras Banjar Rp16.500/kg</div>
                            <div class="text-white/80 text-xs mt-1">4 × 2,5 kg × Rp16.500 = <b class="text-gold2">Rp165.000</b> atau 10 kg beras.</div>
                        </div>
                        <a href="{{ url('/kalkulator') }}" class="inline-block mt-3 bg-gold2 text-oliveDark text-xs font-extrabold px-4 py-1.5 rounded-full text-center shadow-sm hover:bg-gold transition active:scale-95">Hitung di Kalkulator →</a>
                    </div>
                </div>
            </div>

            {{-- 8 Asnaf --}}
            <div id="asnaf" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-4 shadow-sm">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm">3</span> 8 Asnaf Penerima Zakat
                </h2>
                <p class="text-xs text-black/70 mt-1">QS. At-Taubah: 60 — Sesungguhnya zakat itu hanyalah untuk...</p>
                <div class="mt-4 grid sm:grid-cols-2 gap-3 text-xs">
                    @php $asnafs = [
                        ['Fakir','Tidak punya harta & penghasilan, atau sangat tidak mencukupi.','fa-person-circle-question'],
                        ['Miskin','Punya penghasilan tapi tidak cukup untuk kebutuhan pokok.','fa-hand-holding-heart'],
                        ['Amil','Pengelola zakat yang ditunjuk.','fa-people-group'],
                        ['Muallaf','Yang dijinakkan hatinya (baru masuk Islam).','fa-heart'],
                        ['Riqab','Budak/hamba sahaya (konteks modern: memerdekakan dari jeratan).','fa-link-slash'],
                        ['Gharimin','Berhutang untuk kebutuhan pokok & tidak mampu membayar.','fa-scale-balanced'],
                        ['Fisabilillah','Di jalan Allah (dakwah, jihad, kepentingan umum syar\'i).','fa-mosque'],
                        ['Ibnu Sabil','Musafir kehabisan bekal.','fa-person-walking-luggage'],
                    ]; @endphp
                    @foreach($asnafs as $i=>$a)
                    <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border flex gap-3 items-center">
                        <div class="w-8 h-8 bg-gold/20 text-gold rounded-lg flex items-center justify-center font-bold shrink-0 shadow-sm"><i class="fa-solid {{ $a[2] }} text-xs"></i></div>
                        <div><div class="font-bold text-oliveDark text-xs">{{ $i+1 }}. {{ $a[0] }}</div><div class="text-[10px] text-black/70 mt-0.5 leading-tight">{{ $a[1] }}</div></div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Zakat Maal --}}
            <div id="maal" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-4 shadow-sm border-l-4 border-l-gold">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm">4</span> Zakat Maal
                </h2>
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-2.5">
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Hukum</div><div class="text-black/70 mt-0.5">Wajib atas harta yang mencapai nisab (85 gr emas) dan haul (genap 1 tahun hijriah).</div></div>
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Besaran</div><div class="text-black/70 mt-0.5">2,5% dari total harta yang memenuhi syarat.</div></div>
                    </div>
                    <div class="bg-olive text-white rounded-2xl p-4 flex flex-col justify-between shadow-md border-l-4 border-l-gold2">
                        <div>
                            <div class="text-[10px] text-gold2 font-extrabold uppercase tracking-wider">CONTOH CEPAT</div>
                            <div class="font-bold mt-1">Harta Rp200.000.000 (sudah haul)</div>
                            <div class="text-white/80 text-xs mt-1">2,5% × 200.000.000 = <b class="text-gold2">Rp5.000.000</b> zakat maal.</div>
                        </div>
                        <a href="{{ url('/kalkulator') }}" class="inline-block mt-3 bg-gold2 text-oliveDark text-xs font-extrabold px-4 py-1.5 rounded-full text-center shadow-sm hover:bg-gold transition active:scale-95">Hitung di Kalkulator →</a>
                    </div>
                </div>
            </div>

            {{-- Fidyah --}}
            <div id="fidyah" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-4 shadow-sm border-l-4 border-l-gold">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm">5</span> Fidyah
                </h2>
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-2.5">
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Syarat</div><div class="text-black/70 mt-0.5">Bagi yang tidak mampu berpuasa (sakit menahun, lansia).</div></div>
                        <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border"><div class="font-bold text-oliveDark">Besaran</div><div class="text-black/70 mt-0.5">1 hari = 1 mud (±0,75 kg beras) atau 1 porsi makan per hari yang ditinggalkan.</div></div>
                    </div>
                    <div class="bg-olive text-white rounded-2xl p-4 flex flex-col justify-between shadow-md border-l-4 border-l-gold2">
                        <div>
                            <div class="text-[10px] text-gold2 font-extrabold uppercase tracking-wider">BENTUK FIDYAH</div>
                            <div class="text-white/80 text-xs mt-1">Uang tunai, beras (0,75 kg/hari), atau <b class="text-gold2">porsi makanan siap saji</b> (nasi + lauk + sayur) yang dibagikan ke fakir/miskin.</div>
                        </div>
                        <a href="{{ url('/kalkulator') }}" class="inline-block mt-3 bg-gold2 text-oliveDark text-xs font-extrabold px-4 py-1.5 rounded-full text-center shadow-sm hover:bg-gold transition active:scale-95">Hitung Fidyah →</a>
                    </div>
                </div>
            </div>

            {{-- FAQ --}}
            <div id="faq" class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 anim-smooth delay-4 shadow-sm">
                <h2 class="font-extrabold text-oliveDark text-base lg:text-lg flex items-center gap-2">
                    <span class="w-8 h-8 bg-olive text-white rounded-xl inline-flex items-center justify-center text-xs shadow-sm">6</span> FAQ Zakat
                </h2>
                <div class="mt-4 space-y-3 text-xs">
                    <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                        <div class="font-bold text-oliveDark mb-1"><i class="fa-solid fa-circle-question text-gold2 mr-1.5"></i>Apakah zakat fitrah boleh dibayar pakai uang?</div>
                        <div class="text-black/70 mt-0.5 leading-relaxed">Boleh, dengan konversi harga beras lokal (±Rp16.500/kg × 2,5 kg/jiwa). Disunnahkan membayar dengan beras langsung agar manfaatnya lebih cepat sampai ke asnaf.</div>
                    </div>
                    <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                        <div class="font-bold text-oliveDark mb-1"><i class="fa-solid fa-circle-question text-gold2 mr-1.5"></i>Kapan waktu membayar zakat fitrah?</div>
                        <div class="text-black/70 mt-0.5 leading-relaxed">Sebaiknya sebelum Shalat Idul Fitri. Tidak disarankan melebihkan 2 hari sebelum Id. Waktu ideal: akhir Ramadhan sampai H-1 Idul Fitri.</div>
                    </div>
                    <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                        <div class="font-bold text-oliveDark mb-1"><i class="fa-solid fa-circle-question text-gold2 mr-1.5"></i>Apakah anak & lansia wajib zakat fitrah?</div>
                        <div class="text-black/70 mt-0.5 leading-relaxed">Ya — setiap jiwa muslim yang masih hidup di 1 Syawal wajib ditunaikan zakat fitrahnya. Wali/kepala keluarga membayar atas nama mereka.</div>
                    </div>
                    <div class="bg-panel-2/70 rounded-xl p-3 border border-panel-border">
                        <div class="font-bold text-oliveDark mb-1"><i class="fa-solid fa-circle-question text-gold2 mr-1.5"></i>Ke mana zakat saya disalurkan?</div>
                        <div class="text-black/70 mt-0.5 leading-relaxed">Melalui amil yang sah: BAZNAS, UPZ masjid, atau lembaga yang ditunjuk pemerintah kota Banjarbaru. Lihat <a href="{{ url('/direktori') }}" class="font-bold text-gold2 underline">Lokasi Penyaluran</a> untuk titik terdekat.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar sticky --}}
        <div class="space-y-4 anim-smooth delay-3">
            <div class="bg-olive rounded-[24px] p-5 text-white lg:sticky lg:top-[80px] shadow-xl hover-smooth border border-white/20 border-l-4 border-l-gold2 relative overflow-hidden">
                <div class="w-10 h-10 bg-gold2 text-oliveDark rounded-xl flex items-center justify-center font-black shadow-sm"><i class="fa-solid fa-lightbulb text-base"></i></div>
                <div class="font-bold text-sm mt-3">Butuh Hitung Cepat?</div>
                <p class="text-xs text-white/80 mt-1 leading-relaxed">Buka kalkulator untuk simulasi zakat fitrah, maal, dan fidyah otomatis.</p>
                <a href="{{ url('/kalkulator') }}" class="mt-4 block text-center bg-gold2 text-oliveDark font-extrabold py-2.5 rounded-full text-xs hover:bg-gold transition shadow active:scale-95">Buka Kalkulator <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection