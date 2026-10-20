@extends('layouts.app')
@section('title','Beranda — E-Zakat Banjarbaru')

@section('content')
<div class="max-w-7xl mx-auto w-full px-4 py-4 flex-1 flex flex-col justify-center">

    <!-- CONTAINER UTAMA -->
    <main class="space-y-4 my-auto">

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
        <div id="holidayBannerNote" class="hidden text-[10px] text-center text-olive/50 py-0.5">
            <i class="fa-solid fa-circle-info mr-1"></i> Jadwal hari raya bersifat <b>perkiraan</b> berdasarkan hisab & dapat berubah mengikuti hasil Sidang Isbat Kemenag.
        </div>

        <!-- HERO TEXT (KIRI) + PENGUMUMAN CARD (KANAN) -->
        <div class="grid lg:grid-cols-12 gap-6 items-center w-full">
            
            <!-- KOLOM KIRI: HERO RINGKAS -->
            <div class="lg:col-span-7 space-y-3">
                <div class="inline-flex items-center gap-2 border border-cream3/40 px-3.5 py-1 rounded-full text-xs font-bold text-olive anim-smooth delay-2">
                    <i class="fa-solid fa-sparkles text-earth"></i> ZAKAT MEMBERSIHKAN HARTA & JIWA
                </div>

                <h1 class="font-black text-oliveDark text-[34px] lg:text-[48px] leading-[1.02] tracking-tight anim-smooth delay-3">
                    Mudahkan Zakat,<br>
                    <span class="text-olive">Raih Berkah.</span>
                </h1>

                <p class="text-oliveDark/80 text-xs lg:text-sm max-w-lg leading-relaxed font-medium anim-smooth delay-4">
                    Hitung zakat fitrah & maal, fidyah, temukan titik penyaluran terdekat di Banjarbaru, dan pelajari panduan lengkap sesuai syariat.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-1 anim-smooth delay-4">
                    <a href="{{ url('/kalkulator') }}" class="bg-olive hover:bg-olive2 text-white font-bold px-6 py-2.5 rounded-full text-xs transition shadow flex items-center gap-2 hover-smooth active:scale-95">
                        <i class="fa-solid fa-calculator"></i> Hitung Zakat
                    </a>
                    <a href="{{ url('/direktori') }}" class="border border-cream3/50 hover:bg-cream/20 text-olive font-bold px-6 py-2.5 rounded-full text-xs transition hover-smooth active:scale-95">
                        <i class="fa-solid fa-map-location-dot"></i> Lihat Lokasi Penyaluran
                    </a>
                </div>

                <!-- STATS CARD -->
                <div class="grid grid-cols-3 gap-2.5 pt-2 max-w-md text-center anim-smooth delay-5">
                    <div class="rounded-2xl p-2.5 border border-cream3/30 hover-smooth">
                        <div class="text-base font-black text-olive">2.5<span class="text-xs font-semibold">kg</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Zakat Fitrah / jiwa</div>
                    </div>
                    <div class="rounded-2xl p-2.5 border border-cream3/30 hover-smooth">
                        <div class="text-base font-black text-olive">3<span class="text-xs font-semibold"> Kat.</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Titik Penyaluran</div>
                    </div>
                    <div class="rounded-2xl p-2.5 border border-cream3/30 hover-smooth">
                        <div class="text-base font-black text-olive">8</div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Asnaf Penerima</div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: PENGUMUMAN -->
            <div class="lg:col-span-5 bg-panel rounded-3xl p-5 border border-panel-border space-y-3 anim-smooth delay-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-olive text-white rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                        <i class="fa-solid fa-bullhorn text-sm"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-oliveDark text-xs">Pengumuman Penting</div>
                        <div class="text-[10px] text-olive/70">Batas Zakat Fitrah 1 Syawal • Fidyah Rp45.000/hari</div>
                    </div>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-olive/15 text-olive rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-wheat-awn text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Banjar Premium</div>
                            <div class="text-[10px] text-olive/70">2.5 kg / 3.5 liter per jiwa</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-earth/20 text-olive rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-bowl-rice text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Lainnya</div>
                            <div class="text-[10px] text-olive/70">Pilih harga/kg untuk konversi uang</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-panel-2/70 rounded-xl p-2.5 border border-panel-border">
                        <div class="w-7 h-7 bg-olive2/15 text-olive2 rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-utensils text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Fidyah Puasa</div>
                            <div class="text-[10px] text-olive/70">1 mud (±0.75 kg) atau 1 porsi makan/hari</div>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/panduan') }}" class="block text-center bg-cream hover:bg-olive hover:text-white text-olive font-bold py-2 rounded-xl border border-cream3 transition text-xs shadow-sm active:scale-95">
                    Baca Panduan Lengkap <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </a>
            </div>

        </div>

        <!-- 3 MENU CARDS RINGKAS -->
        <div class="grid md:grid-cols-3 gap-3 shrink-0 anim-smooth delay-4">
            <a href="{{ url('/kalkulator') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3">
                <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm"><i class="fa-solid fa-calculator"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-olive transition">Kalkulator Zakat</div>
                    <div class="text-[10px] text-olive/70 mt-0.5">Hitung Fitrah, Maal & Fidyah otomatis.</div>
                </div>
            </a>

            <a href="{{ url('/direktori') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3">
                <div class="w-10 h-10 bg-earth text-oliveDark rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm font-bold"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-olive transition">Lokasi Penyaluran</div>
                    <div class="text-[10px] text-olive/70 mt-0.5">Peta BAZNAS, UPZ & titik penerima.</div>
                </div>
            </a>

            <a href="{{ url('/panduan') }}" class="bg-panel rounded-2xl border border-panel-border p-3.5 hover-smooth transition group flex items-center gap-3">
                <div class="w-10 h-10 bg-olive2 text-white rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm"><i class="fa-solid fa-book-open"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-olive transition">Panduan Zakat</div>
                    <div class="text-[10px] text-olive/70 mt-0.5">Niat, syarat, 8 asnaf & FAQ zakat.</div>
                </div>
            </a>
        </div>

        <!-- HADIS HARIAN -->
        <div class="bg-olive/95 rounded-2xl px-4 py-2.5 text-white flex items-center justify-between gap-4 shrink-0 shadow-lg anim-smooth delay-5">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center shrink-0 text-earth text-[10px]"><i class="fa-solid fa-quote-left"></i></div>
                <div class="truncate text-xs">
                    <span class="font-bold text-earth mr-2">HADIS HARI INI:</span>
                    <span id="dailyHadith" class="text-cream/90 font-medium"></span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="text-[11px] bg-white/20 text-white font-bold px-3.5 py-1.5 rounded-full hover:bg-white/30 transition shrink-0 active:scale-95">
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
    "Ambillah zakat dari sebagian harta meeka... — QS. At-Taubah: 103",
    "Tangan di atas lebih baik daripada tangan di bawah. — HR. Bukhari & Muslim",
    "Berinfaklah wahai anak Adam, niscaya Aku akan berinfak kepadamu. — HR. Bukhari & Muslim",
];
document.getElementById('dailyHadith').textContent = '"' + list[new Date().getDate() % list.length] + '"';

// =========================================================
// BANNER HARI RAYA / PENGINGAT RAMADAN & ZAKAT (TUGAS 8)
// =========================================================
// Kumpulan tanggal hari raya (perkiraan — bisa disesuaikan dgn hasil isbat).
// 2 Syawal 1448H (Idul Fitri 2) ≈ 31 Maret 2027
// 1 Syawal 1447H (Idul Fitri 1) ≈ 21 Maret 2026
// Ramadan 1448H mulai ≈ 8 Feb 2027
// Idul Adha 1448H (10 Dzulhijjah) ≈ 16 Mei 2027
const HOLIDAYS = [
    {
        key: 'ramadan-1448',
        name: 'Bulan Suci Ramadan 1448H',
        date: new Date(2027, 1, 8),        // 8 Feb 2027
        before: 30,                          // tampil 30 hari sebelum
        after: 0,
        icon: 'fa-solid fa-star-and-crescent',
        color: 'olive',
        title: 'Ramadan 1448H Akan Tiba!',
        text: 'Bersyukurlah & siapkan fisik dan harta. Segera tunaikan zakat fitrah menjelang akhir Ramadan.',
    },
    {
        key: 'idul-fitri-1447',
        name: '1 Syawal 1447H (Idul Fitri)',
        date: new Date(2026, 2, 21),       // 21 Mar 2026
        before: 15,
        after: 3,
        icon: 'fa-solid fa-mosque',
        color: 'earth',
        title: 'Idul Fitri Mendekat!',
        text: 'Segera tunaikan zakat fitrah sebelum Sholat Id. 2,5 kg beras/jiwa (±Rp16.000).',
    },
    {
        key: 'idul-fitri-1448',
        name: '1 Syawal 1448H (Idul Fitri)',
        date: new Date(2027, 2, 30),       // 30 Mar 2027
        before: 15,
        after: 3,
        icon: 'fa-solid fa-mosque',
        color: 'earth',
        title: 'Selamat Hari Raya Idul Fitri 1448H!',
        text: 'Semoga ibadah kita diterima dan zakat kita membersihkan harta. Maaf lahir dan batin.',
    },
    {
        key: 'idul-adha-1448',
        name: '10 Dzulhijjah 1448H (Idul Adha)',
        date: new Date(2027, 4, 16),       // 16 Mei 2027
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

    // Temukan event terdekat yang masih relevan
    let active = null;
    for(const h of HOLIDAYS){
        const start = new Date(h.date.getTime() - h.before * DAY_MS);
        const end = new Date(h.date.getTime() + h.after * DAY_MS);
        if(now >= start && now <= end){
            // Pilih event yang paling dekat harinya
            const daysUntil = Math.max(0, Math.round((h.date - now) / DAY_MS));
            const daysAfter = Math.max(0, Math.round((now - h.date) / DAY_MS));
            if(!active || Math.min(daysUntil, daysAfter) < Math.min(active.daysUntil ?? 999, active.daysAfter ?? 999)){
                active = { ...h, daysUntil, daysAfter };
                break;
            }
        }
    }

    if(!active) return;

    // Cek apakah banner ini sudah ditutup user (per event)
    const closedKey = 'ezakat_banner_closed_' + active.key;
    if(localStorage.getItem(closedKey) === String(now.getFullYear())){
        return; // jangan tampil lagi tahun ini
    }

    // Warna dinamis
    const palette = {
        olive:  { bg: 'bg-olive',   border: 'border-olive',   text: 'text-white',   iconBg: 'bg-white/20' },
        earth:  { bg: 'bg-earth',   border: 'border-earth',   text: 'text-oliveDark', iconBg: 'bg-oliveDark/10' },
    };
    const p = palette[active.color] || palette.olive;

    inner.className = 'flex items-start gap-3 p-4 rounded-2xl border shadow-lg text-sm ' +
        'bg-' + p.bg + ' border-' + p.border + ' text-' + p.text + ' hover-smooth';
    iconEl.className = 'text-2xl shrink-0 mt-0.5 ' + p.iconBg + ' p-2 rounded-xl';
    iconEl.innerHTML = '<i class="' + active.icon + '"></i>';

    // Teks dinamis sesuai tahap
    if(active.daysAfter === 0){
        titleEl.textContent = active.title;
        textEl.textContent = active.text;
    } else if(active.daysAfter > 0){
        // Hari raya sudah lewat
        titleEl.textContent = active.title;
        textEl.textContent = 'Hari ini ' + active.name + ' yang lalu (H-' + active.daysAfter + '). ' + active.text;
    } else {
        // Masih sebelum hari raya
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