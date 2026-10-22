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
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto w-full px-4 py-4 flex-1 flex flex-col justify-center">
<!-- ORNAMEN EMAS DI BAGIAN ATAS (POSISI DI BELAKANG TEKS) -->
<div class="absolute top-0 left-0 w-full pointer-events-none z-0 overflow-hidden">
    <img src="{{ asset('images/ornamen-emas.jpg') }}" 
         alt="Ornamen Ramadhan" 
         class="w-full h-[120px] md:h-[160px] object-cover object-top opacity-70">
</div>


    <!-- CONTAINER UTAMA -->
    <main class="space-y-4 my-auto relative">

        {{-- BANNER HARI RAYA & PENGINGAT ZAKAT --}}
        <div id="holidayBanner" class="hidden anim-smooth delay-1">
            <div id="holidayBannerInner" class="flex items-start gap-3 p-4 rounded-2xl border shadow-lg text-sm" style="transition: all .25s ease;">
                <div id="holidayBannerIcon" class="text-lg shrink-0 mt-0.5"></div>
                <div class="flex-1">
                    <div id="holidayBannerTitle" class="font-extrabold text-base"></div>
                    <div id="holidayBannerText" class="text-xs mt-0.5 leading-relaxed"></div>
                </div>
                <button id="holidayBannerClose" type="button" class="w-7 h-7 rounded-full hover:opacity-70 transition flex items-center justify-center shrink-0 text-xs" title="Sembunyikan pengingat">
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
            <div class="lg:col-span-7 space-y-3 relative overflow-hidden rounded-3xl p-2">
                
                <!-- ORNAMEN EMAS PAS DUA POJOKAN (UKURAN DIKUNCI KECIL) -->
                <img src="{{ asset('images/ornamen-emas.png') }}" class="ornamen-medium top-0 right-0" alt="Ornamen">

                <div class="inline-flex items-center gap-2 border border-gold/50 bg-gold/15 px-3.5 py-1 rounded-full text-xs font-bold text-oliveDark dark:text-gold2 anim-smooth delay-2">
                    <i class="fa-solid fa-sparkles text-gold2"></i> ZAKAT MEMBERSIHKAN HARTA & JIWA
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
            <div class="lg:col-span-5 bg-panel rounded-3xl p-5 border border-panel-border space-y-3 anim-smooth delay-3 shadow-md border-l-4 border-l-gold relative overflow-hidden">
                
                <!-- ORNAMEN EMAS KECIL DI KANAN ATAS KARTU PENGUMUMAN -->
                <img src="{{ asset('images/ornamen-emas.png') }}" class="ornamen-small -top-2 -right-2" alt="Ornamen">

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
        <div class="grid md:grid-cols-3 gap-3 shrink-0 anim-smooth delay-4">
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

        <!-- HADIS HARIAN -->
        <div class="bg-olive/95 rounded-2xl px-4 py-2.5 text-white flex items-center justify-between gap-4 shrink-0 shadow-lg anim-smooth delay-5 border-l-4 border-l-gold2 relative overflow-hidden">
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

const HOLIDAYS = [
    {
        key: 'ramadan-1448',
        name: 'Bulan Suci Ramadan 1448H',
        date: new Date(2027, 1, 8),
        before: 30,
        after: 0,
        icon: 'fa-solid fa-star-and-crescent',
        color: 'olive',
        title: 'Ramadan 1448H Akan Tiba!',
        text: 'Bersyukurlah & siapkan fisik dan harta. Segera tunaikan zakat fitrah menjelang akhir Ramadan.',
    },
    {
        key: 'idul-fitri-1447',
        name: '1 Syawal 1447H (Idul Fitri)',
        date: new Date(2026, 2, 21),
        before: 15,
        after: 3,
        icon: 'fa-solid fa-mosque',
        color: 'olive',
        title: 'Idul Fitri Mendekat!',
        text: 'Segera tunaikan zakat fitrah sebelum Sholat Id. 2,5 kg beras/jiwa (±Rp16.000).',
    },
    {
        key: 'idul-fitri-1448',
        name: '1 Syawal 1448H (Idul Fitri)',
        date: new Date(2027, 2, 30),
        before: 15,
        after: 3,
        icon: 'fa-solid fa-mosque',
        color: 'olive',
        title: 'Selamat Hari Raya Idul Fitri 1448H!',
        text: 'Semoga ibadah kita diterima dan zakat kita membersihkan harta. Maaf lahir dan batin.',
    },
    {
        key: 'idul-adha-1448',
        name: '10 Dzulhijjah 1448H (Idul Adha)',
        date: new Date(2027, 4, 16),
        before: 15,
        after: 3,
        icon: 'fa-solid fa-cow',
        color: 'olive',
        title: 'Idul Adha Mendekat!',
        text: 'Waktunya kurban. Siapkan 1/7 bagian hewan kurban setara daging — minimal ±2,5 kg per jiwa.',
    },
];

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

    const palette = {
        olive:  { bg: 'bg-olive', border: 'border-olive', text: 'text-white', iconBg: 'bg-white/20' },
    };
    const p = palette.olive;

    inner.className = 'flex items-start gap-3 p-4 rounded-2xl border shadow-lg text-sm ' +
        'bg-' + p.bg + ' border-' + p.border + ' text-' + p.text + ' hover-smooth';
    iconEl.className = 'text-2xl shrink-0 mt-0.5 ' + p.iconBg + ' p-2 rounded-xl';
    iconEl.innerHTML = '<i class="' + active.icon + '"></i>';

    if(active.daysAfter === 0){
        titleEl.textContent = active.title;
        textEl.textContent = active.text;
    } else if(active.daysAfter > 0){
        titleEl.textContent = active.title;
        textEl.textContent = 'Hari ini ' + active.name + ' yang lalu (H-' + active.daysAfter + '). ' + active.text;
    } else {
        titleEl.textContent = active.daysAfter === 0 ? active.title : (active.name + ' dalam ' + active.daysUntil + ' hari');
        textEl.textContent = active.text;
    }

    banner.classList.remove('hidden');
    noteEl.classList.remove('hidden');

    closeBtn.addEventListener('click', () => {
        banner.classList.add('hidden');
        noteEl.classList.add('hidden');
        localStorage.setItem(closedKey, String(now.getFullYear()));
    });
})();
</script>
@endsection