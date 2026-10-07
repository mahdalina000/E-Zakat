@extends('layouts.app')
@section('title','Direktori Maps — E-Zakat')
@section('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>#map{height:520px;border-radius:20px} .leaflet-popup-content{font-family:Poppins,sans-serif}</style>
@endsection
@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
    <div class="bg-cream rounded-[20px] p-5 lg:p-6 border border-cream3">
        <h1 class="font-extrabold text-oliveDark text-xl lg:text-2xl"><i class="fa-solid fa-map-location-dot text-olive mr-2"></i> Direktori Penyaluran Zakat — Banjarbaru</h1>
        <p class="text-sm text-olive/60 mt-1">Peta interaktif titik penyaluran. Filter berdasarkan kategori dan klik pin untuk detail & rute.</p>

        {{-- Legend --}}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-white rounded-2xl p-3 border border-cream3 flex gap-3 items-center">
                <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                <div><div class="font-bold text-sm text-oliveDark">BAZNAS</div><div class="text-xs text-olive/60">Resmi • Kota Banjarbaru</div></div>
                <span class="ml-auto text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-full" id="countBaznas">0</span>
            </div>
            <div class="bg-white rounded-2xl p-3 border border-cream3 flex gap-3 items-center">
                <span class="w-3.5 h-3.5 rounded-full bg-orange-500 flex-shrink-0"></span>
                <div><div class="font-bold text-sm text-oliveDark">UPZ / Masjid</div><div class="text-xs text-olive/60">Menerima zakat fitrah & maal</div></div>
                <span class="ml-auto text-xs bg-orange-50 text-orange-700 px-2 py-1 rounded-full" id="countUpz">0</span>
            </div>
            <div class="bg-white rounded-2xl p-3 border border-cream3 flex gap-3 items-center">
                <span class="w-3.5 h-3.5 rounded-full bg-red-500 flex-shrink-0"></span>
                <div><div class="font-bold text-sm text-oliveDark">Rumah Warga</div><div class="text-xs text-olive/60">Terdeteksi membutuhkan</div></div>
                <span class="ml-auto text-xs bg-red-50 text-red-700 px-2 py-1 rounded-full" id="countWarga">0</span>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-2 items-center">
            <span class="text-xs font-semibold text-oliveDark">Filter:</span>
            <button data-filter="all" class="fbtn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-semibold">Semua</button>
            <button data-filter="baznas" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-semibold">BAZNAS</button>
            <button data-filter="upz" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-semibold">UPZ/Masjid</button>
            <button data-filter="warga" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-semibold">Warga</button>
            <span class="text-xs text-olive/50 ml-2">Data contoh wilayah Banjarbaru — dapat diganti data riil.</span>
        </div>
    </div>

    <div class="mt-6 grid lg:grid-cols-[1fr_360px] gap-6">
        <div class="bg-white rounded-[20px] border border-cream3 p-2">
            <div id="map"></div>
        </div>

        {{-- List --}}
        <div class="bg-white rounded-[20px] border border-cream3 p-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-oliveDark text-sm">Daftar Lokasi</h3>
                <input id="searchBox" placeholder="Cari nama / alamat..." class="border border-cream3 rounded-full px-3 py-1.5 text-xs w-40">
            </div>
            <div id="listBox" class="mt-3 space-y-2 max-h-[460px] overflow-auto pr-1"></div>
        </div>
    </div>

    {{-- Penjelasan warna --}}
    <div class="mt-6 bg-white rounded-[20px] border border-cream3 p-5">
        <h3 class="font-bold text-oliveDark"><i class="fa-solid fa-circle-info text-olive mr-2"></i> Penjelasan Warna Pin</h3>
        <div class="mt-3 grid md:grid-cols-3 gap-4 text-sm">
            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                <div class="font-bold text-emerald-800"><span class="inline-block w-3 h-3 bg-emerald-500 rounded-full mr-2"></span>Hijau — BAZNAS</div>
                <p class="text-emerald-900/70 text-xs mt-2 leading-relaxed">Badan Amil Zakat Nasional Kota Banjarbaru. Menerima semua jenis zakat, infak, sedekah. Penyaluran terverifikasi ke 8 asnaf dan program pemberdayaan. Buka jam kerja, ada layanan jemput zakat.</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                <div class="font-bold text-orange-800"><span class="inline-block w-3 h-3 bg-orange-500 rounded-full mr-2"></span>Orange — UPZ / Masjid</div>
                <p class="text-orange-900/70 text-xs mt-2 leading-relaxed">Unit Pengumpul Zakat atau masjid yang ditunjuk. Melayani zakat fitrah & maal lingkungan sekitar, fidyah, dan sedekah. Cocok untuk penyaluran terdekat dari rumah.</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                <div class="font-bold text-red-800"><span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>Merah — Rumah Warga</div>
                <p class="text-red-900/70 text-xs mt-2 leading-relaxed">Rumah warga / keluarga yang terdeteksi membutuhkan (fakir, miskin, dhuafa) berdasarkan assesmen. Data sensitif — tampil sebagai titik umum; hubungi BAZNAS/UPZ untuk penyaluran langsung.</p>
            </div>
        </div>
        <p class="text-xs text-olive/50 mt-4">Koordinat contoh berada di area Banjarbaru (sekitar -3.44, 114.83). Ganti dengan data riil kelurahan Anda melalui file view ini.</p>
    </div>
</div>
@endsection
@section('scripts')
<script>
const spots = [
    // BAZNAS - hijau
    {id:1, cat:'baznas', name:'BAZNAS Kota Banjarbaru', addr:'Jl. A. Yani KM 33,5 — Komplek Perkantoran Pemko', lat:-3.442, lng:114.831, tel:'(0511) 4772xxx', jam:'08.00–16.00 WITA', ket:'Pusat. Jemput zakat, transfer & QRIS.'},
    {id:2, cat:'baznas', name:'BAZNAS Gerai Banjarbaru Mart', addr:'Jl. RO Ulin, Loktabat', lat:-3.439, lng:114.838, tel:'0821-5xxx-xxxx', jam:'09.00–17.00', ket:'Gerai layanan zakat di pusat perbelanjaan.'},
    // UPZ / Masjid - orange
    {id:3, cat:'upz', name:'Masjid Agung Al-Munawwarah', addr:'Jl. Trikora, Banjarbaru', lat:-3.444, lng:114.829, tel:'0812-5xxx-xxxx', jam:'Menjelang Idul Fitri 24 jam', ket:'UPZ resmi. Menerima beras & uang.'},
    {id:4, cat:'upz', name:'Masjid At-Taqwa Landasan Ulin', addr:'Jl. A. Yani KM 24, Landasan Ulin', lat:-3.452, lng:114.815, tel:'0821-5xxx-xxxx', jam:'Ba\'da shalat', ket:'UPZ Landasan Ulin.'},
    {id:5, cat:'upz', name:'Masjid Nurul Iman Cempaka', addr:'Jl. Mistar Cokrokusumo, Cempaka', lat:-3.435, lng:114.845, tel:'0852-5xxx-xxxx', jam:'08.00–20.00', ket:'Melayani zakat fitrah & fidyah.'},
    {id:6, cat:'upz', name:'Masjid Al-Ikhlas Guntung Paikat', addr:'Guntung Paikat, Banjarbaru Selatan', lat:-3.448, lng:114.840, tel:'0813-5xxx-xxxx', jam:'Ba\'da shalat', ket:'UPZ lingkungan.'},
    {id:7, cat:'upz', name:'UPZ Kelurahan Loktabat Utara', addr:'Kantor Lurah Loktabat Utara', lat:-3.436, lng:114.833, tel:'0822-5xxx-xxxx', jam:'08.00–15.00', ket:'Koordinasi RT/RW.'},
    // Warga - merah
    {id:8, cat:'warga', name:'Keluarga Ibu S — Dhuafa', addr:'Sekitar Guntung Manggis (titik umum)', lat:-3.450, lng:114.835, tel:'Via BAZNAS', jam:'-', ket:'Janda, 3 anak. Rumah tidak layak huni.'},
    {id:9, cat:'warga', name:'Bapak H — Lansia Sebatang Kara', addr:'Sekitar Landasan Ulin Timur', lat:-3.455, lng:114.820, tel:'Via UPZ At-Taqwa', jam:'-', ket:'Lansia 72 th, tidak mampu puasa.'},
    {id:10, cat:'warga', name:'Keluarga A — Fakir', addr:'Sekitar Cempaka Dalam', lat:-3.430, lng:114.848, tel:'Via UPZ Nurul Iman', jam:'-', ket:'Penghasilan tidak menentu, 4 anak.'},
    {id:11, cat:'warga', name:'Adik R — Yatim', addr:'Sekitar Loktabat Selatan', lat:-3.440, lng:114.826, tel:'Via Masjid Al-Munawwarah', jam:'-', ket:'Yatim piatu, asuh nenek.'},
];

const color = {baznas:'#10b981', upz:'#f97316', warga:'#ef4444'};
const label = {baznas:'BAZNAS', upz:'UPZ / Masjid', warga:'Rumah Warga'};

const map = L.map('map').setView([-3.442,114.833], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);

const markers = {};
spots.forEach(s=>{
    const icon = L.divIcon({
        html:`<div style="background:${color[s.cat]};width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,.35)"></div>`,
        className:'', iconSize:[14,14], iconAnchor:[7,7]
    });
    const m = L.marker([s.lat,s.lng],{icon}).addTo(map);
    m.bindPopup(`
        <div style="min-width:220px">
            <div style="font-weight:700;color:#3D4A24">${s.name}</div>
            <div style="font-size:11px;color:#6B7F3D;margin-top:2px"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:${color[s.cat]};margin-right:6px"></span>${label[s.cat]}</div>
            <div style="font-size:12px;color:#5A6B33;margin-top:6px"><i class="fa-solid fa-location-dot"></i> ${s.addr}</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px"><i class="fa-solid fa-phone"></i> ${s.tel} &nbsp; <i class="fa-regular fa-clock"></i> ${s.jam}</div>
            <div style="font-size:11px;color:#3D4A24;margin-top:6px;background:#F5EAD8;padding:6px 8px;border-radius:8px">${s.ket}</div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=${s.lat},${s.lng}" target="_blank" style="display:inline-block;margin-top:8px;background:#5A6B33;color:white;padding:6px 12px;border-radius:20px;font-size:12px;text-decoration:none">Buka Rute →</a>
        </div>
    `);
    markers[s.id]=m;
});

// Counts
document.getElementById('countBaznas').textContent = spots.filter(s=>s.cat==='baznas').length;
document.getElementById('countUpz').textContent = spots.filter(s=>s.cat==='upz').length;
document.getElementById('countWarga').textContent = spots.filter(s=>s.cat==='warga').length;

// List render
let activeFilter='all', search='';
function renderList(){
    const box=document.getElementById('listBox');
    const filtered = spots.filter(s=>{
        const f = activeFilter==='all' || s.cat===activeFilter;
        const q = search==='' || (s.name+' '+s.addr+' '+s.ket).toLowerCase().includes(search.toLowerCase());
        return f && q;
    });
    // show/hide markers
    spots.forEach(s=>{
        if(activeFilter==='all' || s.cat===activeFilter){
            if((s.name+' '+s.addr).toLowerCase().includes(search.toLowerCase())){ if(!map.hasLayer(markers[s.id])) markers[s.id].addTo(map); }
            else { if(map.hasLayer(markers[s.id])) map.removeLayer(markers[s.id]); }
        } else { if(map.hasLayer(markers[s.id])) map.removeLayer(markers[s.id]); }
    });
    box.innerHTML = filtered.map(s=>`
        <button onclick="focusSpot(${s.id})" class="w-full text-left bg-cream rounded-xl p-3 hover:bg-cream3 transition border border-transparent hover:border-cream3">
            <div class="flex items-center gap-2">
                <span style="width:10px;height:10px;border-radius:50%;background:${color[s.cat]};display:inline-block"></span>
                <span class="text-xs font-semibold" style="color:${color[s.cat]}">${label[s.cat]}</span>
            </div>
            <div class="font-bold text-sm text-oliveDark mt-1">${s.name}</div>
            <div class="text-xs text-olive/60">${s.addr}</div>
        </button>
    `).join('') || '<div class="text-sm text-olive/50 text-center py-8">Tidak ada hasil.</div>';
}
window.focusSpot = id=>{
    const s=spots.find(x=>x.id===id);
    map.setView([s.lat,s.lng], 16);
    markers[id].openPopup();
};
document.querySelectorAll('.fbtn').forEach(b=>{
    b.addEventListener('click', ()=>{
        activeFilter=b.dataset.filter;
        document.querySelectorAll('.fbtn').forEach(x=> x.className='fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-semibold');
        b.className='fbtn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-semibold';
        renderList();
    });
});
document.getElementById('searchBox').addEventListener('input', e=>{ search=e.target.value; renderList(); });
renderList();
</script>
@endsection
