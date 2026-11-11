@extends('layouts.app')
@section('title','Beranda — E-Zakat Banjarbaru')

@section('head')
<style>
    /* Custom Rules Dark Mode — teks gelap jadi terang, aksen emas tetap terbaca */
    body.dark-mode .text-black,
    body.dark-mode .text-oliveDark { color: #f8fafc !important; }
    body.dark-mode .text-oliveDark\/80,
    body.dark-mode .text-oliveDark\/70 { color: #cbd5e1 !important; }
    body.dark-mode .text-black\/70,
    body.dark-mode .text-black\/60,
    body.dark-mode .text-black\/50 { color: #e2e8f0 !important; }
    /* Aksen emas di dark mode */
    body.dark-mode .text-gold,
    body.dark-mode .text-gold2 { color: #D4AF37 !important; }
    body.dark-mode .text-earth { color: #F2C94C !important; }
    body.dark-mode .bg-gold\/15 { background-color: rgba(212,175,55,0.20) !important; }
    body.dark-mode .bg-gold\/20 { background-color: rgba(212,175,55,0.25) !important; }
    body.dark-mode .border-gold\/40,
    body.dark-mode .border-gold\/50 { border-color: rgba(212,175,55,0.45) !important; }

    /* UBAH WARNA BLOK PENGUMUMAN, STATS, & KARTU BAWAH SAAT DARK MODE MENJADI PUTIH TRANSPARAN */
    body.dark-mode .bg-panel,
    body.dark-mode .bg-panel-2\/70,
    body.dark-mode .bg-panel-2 { 
        background-color: rgba(255, 255, 255, 0.12) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(245, 158, 11, 0.3) !important; 
    }

    /* Sembunyikan elemen dekorasi orb/cahaya oranye dari layout induk */
    body > div > div[class*="amber"],
    body > div > div[class*="yellow"],
    body > div > div[class*="earth"],
    [class*="bg-amber"],
    [class*="bg-yellow-500"],
    [class*="bg-earth/"],
    [class*="from-amber"],
    [class*="from-yellow"] {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        background: none !important;
    }

    /* KONTROL UKURAN ORNAMEN AGAR PAS DAN TIDAK KEGEDEAN */
    .ornamen-small {
        width: 60px !important;
        height: auto !important;
        opacity: 0.35;
        pointer-events: none;
        position: absolute;
    }

    .ornamen-medium {
        width: 100px !important;
        height: auto !important;
        opacity: 0.25;
        pointer-events: none;
        position: absolute;
    }

    body {
        position: relative;
        overflow-x: hidden;
    }

    /* ===== BANNER PENGINGAT ZAKAT — DESAIN PREMIUM (glassmorphism + glow + hover-lift) ===== */
    .festive-hero {
        background: linear-gradient(135deg, #1d5b37 0%, #246c42 45%, #0e2a1c 100%);
        border: 1px solid rgba(226, 179, 86, 0.35);
        box-shadow: 0 30px 60px -24px rgba(8, 32, 20, 0.7),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
    }
    /* kilau emas menyapu diagonal */
    .festive-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(600px 220px at 85% -10%, rgba(226, 179, 86, 0.22), transparent 60%);
        pointer-events: none;
    }
    /* LAPISAN BINTANG KAYA — beberapa lapis dengan ukuran & posisi berbeda agar tidak kosong */
    .festive-stars {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            /* bintang kecil rapat */
            radial-gradient(circle at 10% 20%, rgba(255,255,255,0.55) 1.2px, transparent 1.8px),
            radial-gradient(circle at 28% 65%, rgba(255,255,255,0.40) 1px, transparent 1.6px),
            radial-gradient(circle at 45% 15%, rgba(226,179,86,0.6) 1.4px, transparent 2px),
            radial-gradient(circle at 62% 80%, rgba(255,255,255,0.45) 1.1px, transparent 1.7px),
            radial-gradient(circle at 78% 30%, rgba(226,179,86,0.5) 1.3px, transparent 1.9px),
            radial-gradient(circle at 92% 70%, rgba(255,255,255,0.50) 1.2px, transparent 1.8px),
            /* kelompok bintang emas tersebar */
            radial-gradient(circle at 17% 78%, rgba(226,179,86,0.55) 1.6px, transparent 2.2px),
            radial-gradient(circle at 55% 45%, rgba(255,255,255,0.38) 1px, transparent 1.6px),
            radial-gradient(circle at 85% 12%, rgba(226,179,86,0.45) 1.4px, transparent 2px),
            radial-gradient(circle at 35% 40%, rgba(255,255,255,0.42) 1.2px, transparent 1.8px),
            radial-gradient(circle at 70% 55%, rgba(255,255,255,0.36) 1px, transparent 1.6px),
            radial-gradient(circle at 5% 50%, rgba(226,179,86,0.40) 1.3px, transparent 1.9px);
        background-size: 140px 140px, 180px 180px, 120px 120px,
                         200px 200px, 160px 160px, 130px 130px,
                         220px 220px, 150px 150px, 240px 240px,
                         170px 170px, 120px 120px, 190px 190px;
        background-position: 0 0, 40px 60px, 80px 20px, 20px 90px,
                             110px 40px, 60px 120px, 140px 80px,
                             30px 140px, 160px 10px, 100px 100px,
                             50px 30px, 120px 130px;
        opacity: 0.7;
        animation: festiveTwinkle 5s ease-in-out infinite;
    }
    @keyframes festiveTwinkle {
        0%, 100% { opacity: 0.45; }
        50% { opacity: 0.85; }
    }
    body.dark-mode .festive-stars { opacity: 0.5; }
    /* kartu sub premium */
    .festive-card {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: transform 0.25s ease, border-color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
    }
    .festive-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.10);
        border-color: rgba(226, 179, 86, 0.5);
        box-shadow: 0 14px 30px -14px rgba(226, 179, 86, 0.45);
    }
    /* kartu emas menonjol (CTA value) */
    .festive-gold-card {
        background: linear-gradient(140deg, rgba(226, 179, 86, 0.28), rgba(226, 179, 86, 0.10));
        border: 1px solid rgba(226, 179, 86, 0.55);
        box-shadow: 0 10px 28px -12px rgba(226, 179, 86, 0.55);
    }
    /* chip kalender premium */
    .festive-chip {
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        transition: all 0.2s ease;
    }
    .festive-chip:hover {
        background: rgba(226, 179, 86, 0.25);
        border-color: rgba(226, 179, 86, 0.6);
        color: #f6e3b0;
        transform: translateY(-1px);
    }
    /* glow ikon emas */
    .festive-ico {
        background: linear-gradient(140deg, #e2b356, #c89d44);
        box-shadow: 0 0 18px rgba(226, 179, 86, 0.55), inset 0 1px 0 rgba(255,255,255,0.4);
    }
    /* tombol CTA emas premium */
    .festive-cta {
        background: linear-gradient(140deg, #f0cd7e, #d9a94f);
        box-shadow: 0 12px 26px -10px rgba(226, 179, 86, 0.7), inset 0 1px 0 rgba(255,255,255,0.5);
        transition: all 0.25s ease;
    }
    .festive-cta:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 18px 34px -12px rgba(226, 179, 86, 0.9);
    }
    /* dark mode: banner lebih pekat, teks tetap putih */
    body.dark-mode .festive-hero {
        background: linear-gradient(135deg, #0d2417 0%, #0f2f1e 45%, #05130c 100%);
        border-color: rgba(226, 179, 86, 0.30);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto w-full px-4 py-4 flex-1 flex flex-col justify-center">

    <!-- CONTAINER UTAMA -->
    <main class="space-y-4 my-auto relative">

        {{-- BANNER HARI RAYA & PENGINGAT ZAKAT --}}
        <style>
            /* Ornamen ketupat bergoyang menggantung (nuansa hari raya) */
            .ketupat-wrap{position:absolute;top:-22px;pointer-events:none;z-index:3;display:flex;align-items:flex-start;gap:6px}
            .ketupat-wrap.left{left:-8px}
            .ketupat-wrap.right{left:auto;right:-8px}
            .ketupat{display:inline-block;transform-origin:top center;animation:ketupatSway 4s ease-in-out infinite;filter:drop-shadow(0 2px 3px rgba(0,0,0,.22))}
            .ketupat:nth-child(2){animation-delay:-2.1s;animation-duration:4.8s}
            .ketupat:nth-child(3){animation-delay:-3.2s;animation-duration:5.2s}
            .ketupat-wrap.right .ketupat{animation-delay:-2.7s;animation-duration:4.6s}
            .ketupat-wrap.right .ketupat:nth-child(2){animation-delay:-1.3s}
            .ketupat-wrap.right .ketupat:nth-child(3){animation-delay:-3.8s}
            @keyframes ketupatSway{0%,100%{transform:rotate(-9deg)}50%{transform:rotate(9deg)}}
        </style>
        <div id="holidayBanner" class="relative hidden anim-smooth delay-1">
            <div class="ketupat-wrap left" aria-hidden="true">
                <span class="ketupat"><svg width="30" height="46" viewBox="0 0 30 46" fill="none"><line x1="15" y1="0" x2="15" y2="12" stroke="#c89d44" stroke-width="1.6"/><polygon points="15,14 29,27 15,40 1,27" fill="url(#kg1)" stroke="#e2b356" stroke-width="1.4" stroke-linejoin="round"/><line x1="15" y1="14" x2="15" y2="40" stroke="rgba(255,255,255,.4)" stroke-width="1"/><line x1="1" y1="27" x2="29" y2="27" stroke="rgba(255,255,255,.4)" stroke-width="1"/><path d="M15 40 L12 45 M15 40 L18 45" stroke="#e2b356" stroke-width="1.3" stroke-linecap="round"/><defs><linearGradient id="kg1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2f8a54"/><stop offset="1" stop-color="#1d5b37"/></linearGradient></defs></svg></span>
                <span class="ketupat"><svg width="26" height="40" viewBox="0 0 26 40" fill="none"><line x1="13" y1="0" x2="13" y2="11" stroke="#c89d44" stroke-width="1.4"/><polygon points="13,13 25,24 13,35 1,24" fill="url(#kg2)" stroke="#e2b356" stroke-width="1.3" stroke-linejoin="round"/><line x1="13" y1="13" x2="13" y2="35" stroke="rgba(255,255,255,.4)" stroke-width="0.9"/><line x1="1" y1="24" x2="25" y2="24" stroke="rgba(255,255,255,.4)" stroke-width="0.9"/><path d="M13 35 L10 39.5 M13 35 L16 39.5" stroke="#c89d44" stroke-width="1.1" stroke-linecap="round"/><defs><linearGradient id="kg2" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#c89d44"/><stop offset="1" stop-color="#a97c2d"/></linearGradient></defs></svg></span>
                <span class="ketupat"><svg width="22" height="34" viewBox="0 0 22 34" fill="none"><line x1="11" y1="0" x2="11" y2="10" stroke="#c89d44" stroke-width="1.2"/><polygon points="11,12 21,21 11,30 1,21" fill="url(#kg1)" stroke="#e2b356" stroke-width="1.1" stroke-linejoin="round"/><line x1="11" y1="12" x2="11" y2="30" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><line x1="1" y1="21" x2="21" y2="21" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><path d="M11 30 L8.5 34 M11 30 L13.5 34" stroke="#e2b356" stroke-width="1" stroke-linecap="round"/></svg></span>
            </div>
            <div class="ketupat-wrap right" aria-hidden="true">
                <span class="ketupat"><svg width="24" height="38" viewBox="0 0 24 38" fill="none"><line x1="12" y1="0" x2="12" y2="10" stroke="#c89d44" stroke-width="1.3"/><polygon points="12,12 23,22 12,32 1,22" fill="url(#kg3)" stroke="#e2b356" stroke-width="1.2" stroke-linejoin="round"/><line x1="12" y1="12" x2="12" y2="32" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><line x1="1" y1="22" x2="23" y2="22" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><path d="M12 32 L9.5 36 M12 32 L14.5 36" stroke="#c89d44" stroke-width="1" stroke-linecap="round"/><defs><linearGradient id="kg3" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#c89d44"/><stop offset="1" stop-color="#a97c2d"/></linearGradient></defs></svg></span>
                <span class="ketupat"><svg width="30" height="46" viewBox="0 0 30 46" fill="none"><line x1="15" y1="0" x2="15" y2="12" stroke="#c89d44" stroke-width="1.6"/><polygon points="15,14 29,27 15,40 1,27" fill="url(#kg1)" stroke="#e2b356" stroke-width="1.4" stroke-linejoin="round"/><line x1="15" y1="14" x2="15" y2="40" stroke="rgba(255,255,255,.4)" stroke-width="1"/><line x1="1" y1="27" x2="29" y2="27" stroke="rgba(255,255,255,.4)" stroke-width="1"/><path d="M15 40 L12 45 M15 40 L18 45" stroke="#e2b356" stroke-width="1.3" stroke-linecap="round"/></svg></span>
                <span class="ketupat"><svg width="22" height="34" viewBox="0 0 22 34" fill="none"><line x1="11" y1="0" x2="11" y2="10" stroke="#c89d44" stroke-width="1.2"/><polygon points="11,12 21,21 11,30 1,21" fill="url(#kg2)" stroke="#e2b356" stroke-width="1.1" stroke-linejoin="round"/><line x1="11" y1="12" x2="11" y2="30" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><line x1="1" y1="21" x2="21" y2="21" stroke="rgba(255,255,255,.4)" stroke-width="0.8"/><path d="M11 30 L8.5 34 M11 30 L13.5 34" stroke="#e2b356" stroke-width="1" stroke-linecap="round"/></svg></span>
            </div>
            <div id="holidayBannerInner" class="relative flex items-center gap-3 p-4 sm:p-5 rounded-2xl border shadow-lg text-sm overflow-hidden" style="transition: all .25s ease;">
                <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle at 10% 25%, rgba(255,255,255,.30) 1px, transparent 1.6px), radial-gradient(circle at 90% 15%, rgba(255,255,255,.26) 1px, transparent 1.6px), radial-gradient(circle at 70% 80%, rgba(255,255,255,.20) 1px, transparent 1.6px); background-size: 28px 28px;"></div>
                <div id="holidayBannerIcon" class="text-2xl shrink-0 relative rounded-xl flex items-center justify-center w-11 h-11"></div>
                <div class="flex-1 relative">
                    <div id="holidayBannerTitle" class="font-black text-lg sm:text-2xl text-gold2 leading-tight drop-shadow-sm"></div>
                    <div id="holidayBannerText" class="text-xs mt-1 text-white/85 leading-relaxed"></div>
                </div>
                <button id="holidayBannerClose" type="button" aria-label="Tutup pengingat" class="relative z-20 cursor-pointer w-7 h-7 rounded-full hover:opacity-70 transition flex items-center justify-center shrink-0 text-sm bg-black/20 text-white" title="Sembunyikan pengingat">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
        <div id="holidayBannerNote" class="hidden text-[10px] text-center text-black/50 py-0.5">
            <i class="fa-solid fa-circle-info mr-1"></i> Jadwal hari raya bersifat <b>perkiraan</b> berdasarkan hisab & dapat berubah mengikuti hasil Sidang Isbat Kemenag.
        </div>

        <!-- HERO TEXT (KIRI) + PENGUMUMAN CARD (KANAN) -->
        <div class="grid lg:grid-cols-12 gap-6 items-center w-full">
            
            <!-- KOLOM KIRI: HERO RINGKAS -->
            <div class="lg:col-span-7 space-y-3 relative overflow-hidden rounded-3xl p-2 eze-col-left">

<style>
    /* Badge hero: teks gelap di light mode, emas di dark mode (inline, anti-cache) */
    .eze-badge-txt { color: #0e2a1c; }
    body.dark-mode .eze-badge-txt { color: #e2b356; }
</style>
<div class="inline-flex items-center gap-2 border border-emerald-900/30 dark:border-gold/50 bg-emerald-800/10 dark:bg-gold/15 px-3.5 py-1 rounded-full text-xs font-extrabold text-oliveDark dark:text-gold2 anim-smooth delay-2">
    <i class="eze-badge-txt fa-solid fa-sparkles"></i> <span class="eze-badge-txt">ZAKAT MEMBERSIHKAN HARTA & JIWA</span>
</div>
                <h1 class="font-black text-oliveDark text-[34px] lg:text-[48px] leading-[1.02] tracking-tight anim-smooth delay-3">
                    Mudahkan Zakat,<br>
                    <span class="text-black">Raih Berkah.</span>
                </h1>

                <p class="text-oliveDark/80 text-xs lg:text-sm max-w-lg leading-relaxed font-medium anim-smooth delay-4">
                    Hitung zakat fitrah & maal, fidyah, temukan titik penyaluran terdekat di Banjarbaru, dan pelajari panduan lengkap sesuai syariat.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-1 anim-smooth delay-4">
                    <a href="{{ url('/kalkulator') }}" class="bg-olive hover:bg-olive2 text-white font-bold px-6 py-2.5 rounded-full text-xs transition shadow flex items-center gap-2 hover-smooth active:scale-95 border border-gold/40">
                        <i class="fa-solid fa-calculator text-gold2"></i> Hitung Zakat
                    </a>
                    <a href="{{ url('/direktori') }}" class="border border-panel-border hover:bg-panel-2/60 text-black font-bold px-6 py-2.5 rounded-full text-xs transition hover-smooth active:scale-95">
                        <i class="fa-solid fa-map-location-dot"></i> Lihat Lokasi Penyaluran
                    </a>
                </div>

                <!-- STATS CARD -->
                <div class="grid grid-cols-3 gap-2.5 pt-2 max-w-md text-center anim-smooth delay-5">
                    <div class="bg-panel rounded-2xl p-2.5 border border-panel-border border-b-2 border-b-gold hover-smooth shadow-sm">
                        <div class="text-base font-black text-black">2.5<span class="text-xs font-semibold">kg</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Zakat Fitrah / jiwa</div>
                    </div>
                    <div class="bg-panel rounded-2xl p-2.5 border border-panel-border border-b-2 border-b-blue-500 hover-smooth shadow-sm">
                        <div class="text-base font-black text-black">3<span class="text-xs font-semibold"> Kat.</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Titik Penyaluran</div>
                    </div>
                    <div class="bg-panel rounded-2xl p-2.5 border border-panel-border border-b-2 border-b-emerald-500 hover-smooth shadow-sm">
                        <div class="text-base font-black text-black">8</div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Asnaf Penerima</div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: PENGUMUMAN CARD -->
            <div class="lg:col-span-5 bg-panel rounded-3xl p-5 border border-panel-border space-y-3 anim-smooth delay-3 shadow-md border-l-4 border-l-gold relative overflow-hidden eze-col-right">

                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-9 h-9 bg-olive text-white rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                        <i class="fa-solid fa-bullhorn text-sm"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-oliveDark text-xs">Pengumuman Penting</div>
                        <div class="text-[10px] text-black/70">Batas Zakat Fitrah 1 Syawal • Fidyah Rp45.000/hari</div>
                    </div>
                </div>

                <div class="space-y-2 text-xs relative z-10">
                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-gold/20 text-gold rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-wheat-awn text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Banjar Premium</div>
                            <div class="text-[10px] text-black/70">2.5 kg / 3.5 liter per jiwa</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-blue-500/15 text-blue-600 rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-bowl-rice text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Lainnya</div>
                            <div class="text-[10px] text-black/70">Pilih harga/kg untuk konversi uang</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-emerald-500/15 text-emerald-600 rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-utensils text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Fidyah Puasa</div>
                            <div class="text-[10px] text-black/70">1 mud (±0.75 kg) atau 1 porsi makan/hari</div>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/panduan') }}" class="block text-center bg-panel-2/70 hover:bg-olive hover:text-white text-oliveDark font-bold py-2 rounded-xl border border-panel-border transition text-xs shadow-sm active:scale-95 relative z-10">
                    Baca Panduan Lengkap <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </a>
            </div>

        </div>

        <!-- 3 MENU CARDS RINGKAS -->
        <div class="grid md:grid-cols-3 gap-3 shrink-0 anim-smooth delay-4 eze-up">
            <a href="{{ url('/kalkulator') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm relative overflow-hidden">
                <div class="w-10 h-10 bg-gold/20 text-gold rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm font-bold"><i class="fa-solid fa-calculator"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-black transition">Kalkulator Zakat</div>
                    <div class="text-[10px] text-black/70 mt-0.5">Hitung Fitrah, Maal & Fidyah otomatis.</div>
                </div>
            </a>

            <a href="{{ url('/direktori') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm relative overflow-hidden">
                <div class="w-10 h-10 bg-blue-500/20 text-blue-600 rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm font-bold"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-black transition">Lokasi Penyaluran</div>
                    <div class="text-[10px] text-black/70 mt-0.5">Peta BAZNAS, UPZ & titik penerima.</div>
                </div>
            </a>

            <a href="{{ url('/panduan') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm relative overflow-hidden">
                <div class="w-10 h-10 bg-emerald-500/20 text-emerald-600 rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm font-bold"><i class="fa-solid fa-book-open"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-black transition">Panduan Zakat</div>
                    <div class="text-[10px] text-black/70 mt-0.5">Niat, syarat, 8 asnaf & FAQ zakat.</div>
                </div>
            </a>
        </div>

        <!-- BANNER UCAPAN SELAMAT HARI RAYA & PENGINGAT ZAKAT -->
        <section class="shrink-0 anim-smooth delay-5 eze-up">
            <!-- PANEL PENUH: ucapan + pengingat zakat dalam satu hero -->
            <div class="festive-hero rounded-3xl text-white">
                <!-- ornamen bintang islami halus di background -->
                <div class="festive-stars"></div>
                <!-- bulan sabit dekoratif kanan -->
                <svg class="absolute right-6 top-6 w-24 h-24 text-gold2/40 pointer-events-none" viewBox="0 0 100 100" fill="currentColor"><path d="M62 8a46 46 0 1 0 0 84 52 52 0 0 1 0-84z"/></svg>
                <!-- lentera gantung dekoratif kiri -->
                <div class="absolute left-8 top-0 pointer-events-none opacity-70">
                    <div class="w-1.5 h-10 bg-gold2/40 mx-auto"></div>
                    <div class="w-8 h-11 bg-gold2/80 rounded-[45%] mx-auto shadow-[0_0_18px_rgba(226,179,86,0.5)]"></div>
                </div>

                <div class="relative z-10 p-5 sm:p-7">
                    <!-- baris atas: label + countdown ke hari raya terdekat -->
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-2.5">
                            <div class="w-11 h-11 festive-ico rounded-2xl flex items-center justify-center text-oliveDark text-lg"><i class="fa-solid fa-star-and-crescent"></i></div>
                            <div>
                                <div class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gold2">Peringatan Hari Raya &amp; Keagamaan</div>
                                <div class="text-sm font-black mt-0.5">Maaf Lahir &amp; Batin &mdash; Semoga Ibadah Kita Diterima</div>
                            </div>
                        </div>
                        <!-- COUNTDOWN dinamis (Hari : Jam : Menit : Detik) -->
                        <div class="flex items-center gap-3 sm:gap-4 festive-card rounded-2xl px-4 py-3">
                            <div class="flex items-end gap-1.5 sm:gap-2.5">
                                <div class="text-center">
                                    <div id="countdownDays" class="text-3xl sm:text-4xl font-black text-gold2 leading-none tabular-nums">--</div>
                                    <div class="text-[9px] text-white/60 font-bold uppercase tracking-wider mt-1">Hari</div>
                                </div>
                                <span class="pb-5 text-xl sm:text-2xl font-black text-gold2/80 leading-none">:</span>
                                <div class="text-center">
                                    <div id="countdownHours" class="text-3xl sm:text-4xl font-black text-gold2 leading-none tabular-nums">--</div>
                                    <div class="text-[9px] text-white/60 font-bold uppercase tracking-wider mt-1">Jam</div>
                                </div>
                                <span class="pb-5 text-xl sm:text-2xl font-black text-gold2/80 leading-none">:</span>
                                <div class="text-center">
                                    <div id="countdownMinutes" class="text-3xl sm:text-4xl font-black text-gold2 leading-none tabular-nums">--</div>
                                    <div class="text-[9px] text-white/60 font-bold uppercase tracking-wider mt-1">Mnt</div>
                                </div>
                                <span class="pb-5 text-xl sm:text-2xl font-black text-gold2/80 leading-none">:</span>
                                <div class="text-center">
                                    <div id="countdownSeconds" class="text-3xl sm:text-4xl font-black text-gold2 leading-none tabular-nums">--</div>
                                    <div class="text-[9px] text-white/60 font-bold uppercase tracking-wider mt-1">Dtk</div>
                                </div>
                            </div>
                            <div class="text-left">
                                <div id="countdownName" class="text-[11px] font-extrabold leading-tight">Hari Raya Terdekat</div>
                                <div id="countdownDate" class="text-[9px] text-white/60 mt-0.5">menunggu data&hellip;</div>
                            </div>
                        </div>
                    </div>

                    <!-- tag hari raya + pengingat zakat dalam satu grid -->
                    <div class="grid lg:grid-cols-[1fr_1.2fr] gap-4 mt-5">
                        <!-- kiri: chip tanggal keagamaan -->
                        <div class="space-y-3">
                            <div class="text-[10px] font-extrabold uppercase tracking-widest text-gold2/90"><i class="fa-solid fa-calendar-days mr-1"></i> Kalender Terdekat</div>
                            <div class="flex flex-wrap gap-2 p-3.5 festive-card rounded-2xl" id="festivalChips">
                                @forelse($holidayBanners as $h)
                                <button type="button" data-key="{{ $h['key'] }}" class="festive-chip rounded-full px-3.5 py-1.5 text-white text-[11px] font-bold transition">
                                    {{ $h['name'] }}
                                </button>
                                @empty
                                <span class="text-[11px] text-white/60">Belum ada data hari raya.</span>
                                @endforelse
                            </div>
                            <a href="{{ url('/kalkulator') }}" class="inline-flex items-center gap-2 bg-gold2 hover:bg-gold text-white text-xs font-extrabold px-5 py-2.5 rounded-full transition active:scale-95 shadow-md">
                                <i class="fa-solid fa-calculator"></i> Hitung Zakat Sekarang
                            </a>
                        </div>

                        <!-- kanan: 3 pengingat zakat -->
                        <div class="space-y-3">
                            <div class="text-[10px] font-extrabold uppercase tracking-widest text-gold2/90"><i class="fa-solid fa-bell mr-1"></i> Pengingat Zakat</div>
                            <div class="festive-card rounded-2xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-quote-left text-gold2 text-sm"></i>
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-gold2/90">Motivasi Ibadah</span>
                                </div>
                                <div id="motivationText" class="text-xs leading-relaxed text-white/85">Sedang memuat&hellip;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- HADIS HARIAN -->
        <div class="bg-olive/95 rounded-2xl px-4 py-2.5 text-white flex items-center justify-between gap-4 shrink-0 shadow-lg anim-smooth delay-5 border-l-4 border-l-gold2 relative overflow-hidden eze-up">
            <div class="flex items-center gap-3 overflow-hidden relative z-10">
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center shrink-0 text-gold2 text-[10px]"><i class="fa-solid fa-quote-left"></i></div>
                <div class="truncate text-xs">
                    <span class="font-bold text-gold2 mr-2">HADIS HARI INI:</span>
                    <span id="dailyHadith" class="text-white/90 font-medium"></span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="text-[11px] bg-gold2 text-oliveDark font-extrabold px-3.5 py-1.5 rounded-full hover:bg-gold transition shrink-0 active:scale-95 shadow-sm relative z-10">
                20 Hadis <i class="fa-solid fa-arrow-right ml-1 text-[9px]"></i>
            </a>
        </div>

    </main>
</div>
@endsection

@section('scripts')
<script>
const list = [
    "Sedekah tidak akan mengurangi harta. — HR. Muslim",
    "Bentengilah hartamu dengan zakat. — HR. Thabrani",
    "Ambillah zakat dari sebagian harta mereka... — QS. At-Taubah: 103",
    "Tangan di atas lebih baik daripada tangan di bawah. — HR. Bukhari & Muslim",
    "Berinfaklah wahai anak Adam, niscaya Aku akan berinfak kepadamu. — HR. Bukhari & Muslim",
];
document.getElementById('dailyHadith').textContent = '"' + list[new Date().getDate() % list.length] + '"';

/* COUNTDOWN HARI RAYA TERDEKAT (dipakai oleh banner bagian bawah) */
let countdownTarget = null;
function initCountdown() {
    const now = new Date();
    let next = countdownTarget || null;
    if(!next){
        for(const h of HOLIDAYS){
            if(h.date > now){
                if(!next || h.date < next.date) next = h;
            }
        }
    }
    const dEl = document.getElementById('countdownDays');
    const hEl = document.getElementById('countdownHours');
    const mEl = document.getElementById('countdownMinutes');
    const sEl = document.getElementById('countdownSeconds');
    const nEl = document.getElementById('countdownName');
    const dtEl = document.getElementById('countdownDate');
    if(!next){
        if(dEl) dEl.textContent = '—';
        if(hEl) hEl.textContent = '—';
        if(mEl) mEl.textContent = '—';
        if(sEl) sEl.textContent = '—';
        return;
    }
    const diff = Math.max(0, next.date.getTime() - now.getTime());
    const days = Math.floor(diff / 86400000);
    const hours = Math.floor((diff % 86400000) / 3600000);
    const minutes = Math.floor((diff % 3600000) / 60000);
    const seconds = Math.floor((diff % 60000) / 1000);
    if(dEl) dEl.textContent = days;
    if(hEl) hEl.textContent = String(hours).padStart(2,'0');
    if(mEl) mEl.textContent = String(minutes).padStart(2,'0');
    if(sEl) sEl.textContent = String(seconds).padStart(2,'0');
    if(nEl) nEl.textContent = next.name.replace(' 1448H','').replace(' 1447H','');
    if(dtEl) dtEl.textContent = next.date.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
}
window.addEventListener('load', initCountdown);
setInterval(initCountdown, 1000);

/* Motivasi ibadah (rotasi) + ucapan hari raya */
const MOTIVATIONS = [
    'Raih ketenangan hati dengan bersedekah dan menunaikan zakat.',
    'Setiap kebaikan kecil adalah cahaya bagi hari-hari Anda.',
    'Perbanyak rasa syukur, niscaya nikmat semakin bertambah.',
    'Berbagi rezeki tidak mengurangi, justru menambah keberkahan.',
    'Istiqamah dalam kebaikan adalah kunci ketenteraman hati.',
];
function initMotivation() {
    const el = document.getElementById('motivationText');
    if (!el) return;
    const now = new Date();
    let holidayEl = null;
    for (const h of HOLIDAYS) {
        const start = new Date(h.date.getTime() - h.before * 86400000);
        const end = new Date(h.date.getTime() + h.after * 86400000);
        if (now >= start && now <= end) { holidayEl = h; break; }
    }
    const upd = () => {
        if (holidayEl) {
            const name = (holidayEl.name || '').replace(' 1448H','').replace(' 1447H','');
            el.textContent = 'Selamat Hari Raya ' + name + ' — Maaf Lahir & Batin. Semoga ibadah kita diterima Allah SWT.';
        } else {
            el.textContent = MOTIVATIONS[Math.floor(Math.random() * MOTIVATIONS.length)];
        }
    };
    upd();
    if (!holidayEl) setInterval(upd, 9000);
}
window.addEventListener('load', initMotivation);

// Banner hari raya dibangun dari tabel holiday_banners (dikelola Admin BAZNAS)
const HOLIDAYS = (@json($holidayBanners ?? collect())).map(h => ({
    key: h.key,
    name: h.name,
    date: new Date(h.year, h.month - 1, h.day),
    before: h.before,
    after: h.after,
    icon: h.icon,
    color: h.color,
    title: h.title,
    text: h.text,
}));

const paletteAll = {
    olive:   { bg: '#3f5f43', border: '#7d9b72', soft: 'rgba(63,95,67,0.14)' },
    teal:   { bg: '#0f766e', border: '#14b8a6', soft: 'rgba(15,118,110,0.14)' },
    blue:   { bg: '#1d4ed8', border: '#60a5fa', soft: 'rgba(29,78,216,0.14)' },
    emerald: { bg: '#047857', border: '#34d399', soft: 'rgba(4,120,87,0.14)' },
    rose:   { bg: '#be123c', border: '#fb7185', soft: 'rgba(190,18,60,0.14)' },
    gold:   { bg: '#926c1a', border: '#e2b356', soft: 'rgba(210,150,40,0.16)' },
};

// Tampilkan banner + perbarui countdown untuk satu hari raya (dipakai klik chip & auto)
function applyFestival(h) {
    const banner = document.getElementById('holidayBanner');
    const inner = document.getElementById('holidayBannerInner');
    const iconEl = document.getElementById('holidayBannerIcon');
    const titleEl = document.getElementById('holidayBannerTitle');
    const textEl = document.getElementById('holidayBannerText');
    const noteEl = document.getElementById('holidayBannerNote');
    if(!banner || !inner || !h) return;

    const p = paletteAll[h.color] || paletteAll.olive;
    inner.style.background = 'linear-gradient(135deg, ' + p.bg + ', ' + p.border + ')';
    inner.style.borderColor = p.border;
    inner.style.color = '#ffffff';
    inner.style.boxShadow = '0 8px 20px -8px ' + p.soft;
    iconEl.style.background = 'rgba(255,255,255,0.22)';
    iconEl.style.color = '#ffffff';
    iconEl.className = 'text-2xl shrink-0 mt-0.5 rounded-xl flex items-center justify-center w-11 h-11';
    iconEl.innerHTML = '<i class="' + h.icon + '"></i>';

    const now = new Date();
    const days = Math.max(0, Math.round((h.date - now) / 86400000));
    titleEl.textContent = h.title;
    textEl.textContent = (days > 0 ? h.name + ' dalam ' + days + ' hari. ' : '') + h.text;

    banner.classList.remove('hidden');
    if(noteEl) noteEl.classList.remove('hidden');

    const dEl = document.getElementById('countdownDays');
    const nEl = document.getElementById('countdownName');
    const dtEl = document.getElementById('countdownDate');
    if(dEl) dEl.textContent = days;
    if(nEl) nEl.textContent = h.name.replace(/ 14\d+H/, '').trim();
    if(dtEl) dtEl.textContent = h.date.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });

    // Selaraskan countdown (Hari:Jam:Mnt:Dtk) dengan chip/banner yang aktif
    countdownTarget = h;
    initCountdown();
}

// Tutup banner dengan mulus + simpan status (per sesi & per tahun)
function hideBanner() {
    const banner = document.getElementById('holidayBanner');
    const noteEl = document.getElementById('holidayBannerNote');
    if(!banner) return;
    banner.style.transition = 'opacity .25s ease, transform .25s ease';
    banner.style.opacity = '0';
    banner.style.transform = 'translateY(-6px)';
    setTimeout(() => {
        banner.classList.add('hidden');
        banner.style.opacity = '';
        banner.style.transform = '';
        banner.style.transition = '';
    }, 260);
    if(noteEl){
        noteEl.style.transition = 'opacity .2s ease';
        noteEl.style.opacity = '0';
        setTimeout(() => { noteEl.classList.add('hidden'); noteEl.style.opacity = ''; noteEl.style.transition = ''; }, 200);
    }
}
function rememberClosed(hKey) {
    try { sessionStorage.setItem('ezakat_festival_closed', hKey); } catch(e) {}
    try { localStorage.setItem('ezakat_banner_closed_' + hKey, String(new Date().getFullYear())); } catch(e) {}
}

(function initHolidayBanner() {
    const banner = document.getElementById('holidayBanner');
    const inner = document.getElementById('holidayBannerInner');
    const iconEl = document.getElementById('holidayBannerIcon');
    const titleEl = document.getElementById('holidayBannerTitle');
    const textEl = document.getElementById('holidayBannerText');
    const closeBtn = document.getElementById('holidayBannerClose');
    const noteEl = document.getElementById('holidayBannerNote');
    if(!banner || !inner) return;

    const now = new Date();
    const DAY_MS = 86400000;

    let active = null;
    for(const h of HOLIDAYS){
        const start = new Date(h.date.getTime() - h.before * DAY_MS);
        const end = new Date(h.date.getTime() + h.after * DAY_MS);
        if(now >= start && now <= end){
            const daysUntil = Math.max(0, Math.round((h.date - now) / DAY_MS));
            const daysAfter = Math.max(0, Math.round((now - h.date) / DAY_MS));
            if(!active || Math.min(daysUntil, daysAfter) < Math.min(active.daysUntil ?? 999, active.daysAfter ?? 999)){
                active = { ...h, daysUntil, daysAfter };
                break;
            }
        }
    }

    if(!active) return;

    const closedKey = 'ezakat_banner_closed_' + active.key;
    if(localStorage.getItem(closedKey) === String(now.getFullYear())){
        return;
    }

    applyFestival(active);

    closeBtn.addEventListener('click', () => {
        rememberClosed(active.key);
        hideBanner();
    });
})();

// Klik chip "Kalender Terdekat" -> tampilkan banner & perbarui countdown
(function(){
    const chips = document.querySelectorAll('#festivalChips [data-key]');
    chips.forEach(btn => {
        btn.addEventListener('click', () => {
            const h = HOLIDAYS.find(x => x.key === btn.dataset.key);
            if(h) applyFestival(h);
            chips.forEach(b => b.classList.remove('bg-gold2', 'text-oliveDark', 'ring-2', 'ring-gold2'));
            btn.classList.add('bg-gold2', 'text-oliveDark', 'ring-2', 'ring-gold2');
        });
    });
})();

// Tombol tutup (X) selalu berfungsi, apa pun cara banner tampil (auto / klik chip)
(function(){
    const closeBtn = document.getElementById('holidayBannerClose');
    if(!closeBtn) return;
    closeBtn.addEventListener('click', () => {
        const activeChip = document.querySelector('#festivalChips [data-key].bg-gold2');
        const key = activeChip ? activeChip.dataset.key : null;
        if(key) rememberClosed(key);
        hideBanner();
    });
})();
</script>
@endsection