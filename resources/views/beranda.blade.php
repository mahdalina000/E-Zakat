@extends('layouts.app')
@section('title','Beranda — E-Zakat Banjarbaru')
@section('content')
{{-- Hero Beranda --}}
<section class="bg-cream">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-8 lg:py-10">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white border border-cream3 px-3 py-1.5 rounded-full text-xs font-semibold text-olive"><i class="fa-solid fa-sparkles"></i> ZAKAT MEMBERSIHKAN HARTA & JIWA</div>
                <h1 class="mt-4 font-extrabold text-oliveDark text-[28px] lg:text-[40px] leading-[1.05]">Mudahkan Zakat,<br><span class="text-olive">Raih Berkah.</span></h1>
                <p class="mt-3 text-sm lg:text-[15px] text-olive/70 leading-relaxed">Hitung zakat fitrah & maal, fidyah, temukan titik penyaluran terdekat di Banjarbaru, dan pelajari panduan lengkap sesuai syariat.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ url('/kalkulator') }}" class="bg-olive text-white font-semibold px-6 py-3 rounded-full hover:bg-olive2 transition shadow"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
                    <a href="{{ url('/direktori') }}" class="bg-white border border-cream3 text-olive font-semibold px-6 py-3 rounded-full hover:bg-cream transition"><i class="fa-solid fa-map-location-dot mr-2"></i> Lihat Direktori</a>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                    <div class="bg-white rounded-2xl p-3 border border-cream3"><div class="text-xl font-extrabold text-olive">2.5<span class="text-sm">kg</span></div><div class="text-xs text-olive/60">Zakat Fitrah / jiwa</div></div>
                    <div class="bg-white rounded-2xl p-3 border border-cream3"><div class="text-xl font-extrabold text-olive">3<span class="text-sm"> kategori</span></div><div class="text-xs text-olive/60">Titik Penyaluran</div></div>
                    <div class="bg-white rounded-2xl p-3 border border-cream3"><div class="text-xl font-extrabold text-olive">8</div><div class="text-xs text-olive/60">Asnaf Penerima</div></div>
                </div>
            </div>
            <div class="bg-white rounded-[24px] p-6 border border-cream3 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-bullhorn"></i></div>
                    <div>
                        <div class="font-bold text-oliveDark text-sm">Pengumuman Penting</div>
                        <div class="text-xs text-olive/60">Batas Zakat Fitrah 1 Syawal • Fidyah Rp45.000/hari (estimasi)</div>
                    </div>
                </div>
                <div class="mt-5 space-y-3">
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-olive text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-wheat-awn text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-oliveDark">Beras Banjar Premium</div><div class="text-xs text-olive/60">Opsi default untuk zakat fitrah • 2.5 kg atau 3.5 liter / jiwa</div></div>
                    </div>
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-earth text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-bowl-rice text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-oliveDark">Beras Lainnya</div><div class="text-xs text-olive/60">Pilih harga per kg untuk konversi uang zakat</div></div>
                    </div>
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-olive2 text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-utensils text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-oliveDark">Fidyah Puasa</div><div class="text-xs text-olive/60">1 mud (±0.75 kg) atau 1 porsi makan / hari yang ditinggalkan</div></div>
                    </div>
                </div>
                <a href="{{ url('/panduan') }}" class="mt-5 block text-center bg-cream text-olive font-semibold py-2.5 rounded-full border border-cream3 hover:bg-cream3 transition text-sm">Baca Panduan Lengkap <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- Menu Cards --}}
<section class="max-w-7xl mx-auto px-4 lg:px-6 py-8">
    <h2 class="font-bold text-oliveDark">Jelajahi Fitur</h2>
    <p class="text-sm text-olive/60">Pilih kebutuhan Anda — semua dalam satu tempat.</p>
    <div class="mt-4 grid md:grid-cols-3 gap-4">
        <a href="{{ url('/kalkulator') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-olive text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-calculator"></i></div>
            <div class="mt-4 font-bold text-oliveDark">Kalkulator Zakat</div>
            <div class="text-sm text-olive/60 mt-1">Hitung zakat fitrah (Beras Banjar & lainnya), zakat maal, dan fidyah dengan otomatis & akurat.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Buka Kalkulator <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
        <a href="{{ url('/direktori') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-earth text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="mt-4 font-bold text-oliveDark">Direktori Maps</div>
            <div class="text-sm text-olive/60 mt-1">Peta interaktif Banjarbaru — BAZNAS, UPZ/Masjid, dan rumah warga yang membutuhkan.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Buka Peta <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
        <a href="{{ url('/panduan') }}" class="bg-white rounded-[20px] border border-cream3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-olive2 text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-book-open"></i></div>
            <div class="mt-4 font-bold text-oliveDark">Panduan Zakat</div>
            <div class="text-sm text-olive/60 mt-1">Niat, syarat, waktu, besaran, 8 asnaf, dalil & FAQ — ringkas dan mudah dipahami.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Baca Panduan <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
    </div>
</section>

{{-- Hadis harian ringkas di beranda --}}
<section class="max-w-7xl mx-auto px-4 lg:px-6 pb-4">
    <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white flex flex-col lg:flex-row gap-4 items-start lg:items-center">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-quote-left"></i></div>
        <div class="flex-1">
            <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HADIS HARI INI</div>
            <div id="dailyHadith" class="text-sm lg:text-[15px] mt-1 leading-relaxed"></div>
        </div>
        <a href="{{ url('/') }}" class="text-xs bg-white text-olive font-semibold px-4 py-2 rounded-full hover:bg-cream transition flex-shrink-0">Lihat 20 Hadis <i class="fa-solid fa-arrow-right ml-1"></i></a>
    </div>
</section>
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
</script>
@endsection
