@extends('layouts.app')
@section('title','Beranda — E-Zakat Banjarbaru')

@section('content')
<div class="max-w-7xl mx-auto w-full px-4 py-4 flex-1 flex flex-col justify-center">

    <!-- CONTAINER UTAMA -->
    <main class="space-y-4 my-auto">

        <!-- HERO TEXT (KIRI) + PENGUMUMAN CARD (KANAN) -->
        <div class="grid lg:grid-cols-12 gap-6 items-center w-full">
            
            <!-- KOLOM KIRI: HERO RINGKAS -->
            <div class="lg:col-span-7 space-y-3">
                <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-md border border-cream3 px-3.5 py-1 rounded-full text-xs font-bold text-olive shadow-sm anim-smooth delay-2">
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
                    <a href="{{ url('/direktori') }}" class="bg-white hover:bg-cream border border-cream3 text-olive font-bold px-6 py-2.5 rounded-full text-xs transition shadow-sm hover-smooth active:scale-95">
                        <i class="fa-solid fa-map-location-dot"></i> Lihat Direktori
                    </a>
                </div>

                <!-- STATS CARD -->
                <div class="grid grid-cols-3 gap-2.5 pt-2 max-w-md text-center anim-smooth delay-5">
                    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-2.5 border border-cream3 shadow-sm hover-smooth">
                        <div class="text-base font-black text-olive">2.5<span class="text-xs font-semibold">kg</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Zakat Fitrah / jiwa</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-2.5 border border-cream3 shadow-sm hover-smooth">
                        <div class="text-base font-black text-olive">3<span class="text-xs font-semibold"> Kat.</span></div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Titik Penyaluran</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-2.5 border border-cream3 shadow-sm hover-smooth">
                        <div class="text-base font-black text-olive">8</div>
                        <div class="text-[10px] text-oliveDark/70 font-medium">Asnaf Penerima</div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: PENGUMUMAN -->
            <div class="lg:col-span-5 bg-white/90 backdrop-blur-md rounded-3xl p-5 border border-cream3 shadow-xl space-y-3 anim-smooth delay-3 hover-smooth">
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
                    <div class="flex items-center gap-2.5 bg-cream2/80 rounded-xl p-2.5 border border-cream3/60">
                        <div class="w-7 h-7 bg-olive/15 text-olive rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-wheat-awn text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Banjar Premium</div>
                            <div class="text-[10px] text-olive/70">2.5 kg / 3.5 liter per jiwa</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-cream2/80 rounded-xl p-2.5 border border-cream3/60">
                        <div class="w-7 h-7 bg-earth/20 text-olive rounded-lg flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-bowl-rice text-xs"></i></div>
                        <div class="leading-tight">
                            <div class="font-bold text-oliveDark text-[11px]">Beras Lainnya</div>
                            <div class="text-[10px] text-olive/70">Pilih harga/kg untuk konversi uang</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 bg-cream2/80 rounded-xl p-2.5 border border-cream3/60">
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
            <a href="{{ url('/kalkulator') }}" class="bg-white/90 backdrop-blur-md rounded-2xl border border-cream3 p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm"><i class="fa-solid fa-calculator"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-olive transition">Kalkulator Zakat</div>
                    <div class="text-[10px] text-olive/70 mt-0.5">Hitung Fitrah, Maal & Fidyah otomatis.</div>
                </div>
            </a>

            <a href="{{ url('/direktori') }}" class="bg-white/90 backdrop-blur-md rounded-2xl border border-cream3 p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 bg-earth text-oliveDark rounded-xl flex items-center justify-center text-base group-hover:scale-110 transition shrink-0 shadow-sm font-bold"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="leading-tight">
                    <div class="font-bold text-oliveDark text-xs group-hover:text-olive transition">Direktori Maps</div>
                    <div class="text-[10px] text-olive/70 mt-0.5">Peta BAZNAS, UPZ & titik penerima.</div>
                </div>
            </a>

            <a href="{{ url('/panduan') }}" class="bg-white/90 backdrop-blur-md rounded-2xl border border-cream3 p-3.5 hover-smooth transition group flex items-center gap-3 shadow-sm">
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
            <a href="{{ url('/') }}" class="text-[11px] bg-white text-oliveDark font-bold px-3.5 py-1.5 rounded-full hover:bg-earth transition shrink-0 active:scale-95 shadow-sm">
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
</script>
@endsection