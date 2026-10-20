@extends('layouts.app')
@section('title','Lokasi Penyaluran Zakat — E-Zakat Banjarbaru')

@section('head')
<style>
    #map { height: 500px; border-radius: 20px; position: relative; z-index: 0; } 
    .leaflet-popup-content { font-family: 'Poppins', sans-serif; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 w-full">
    <!-- HERO HEADER DIREKTORI -->
    <div class="anim-smooth delay-1">
        <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
            <i class="fa-solid fa-map-location-dot text-olive"></i> Lokasi Penyaluran Zakat — Banjarbaru
        </h1>
        <p class="text-xs lg:text-sm text-olive/70 mt-1 font-medium">Peta interaktif titik penyaluran. Filter berdasarkan kategori dan klik pin untuk detail & rute.</p>

        {{-- Legend --}}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-cream2/80 rounded-2xl p-3 border border-cream3/80 flex gap-3 items-center shadow-sm hover-smooth">
                <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 shrink-0"></span>
                <div>
                    <div class="font-bold text-xs lg:text-sm text-oliveDark">BAZNAS</div>
                    <div class="text-[10px] text-olive/60">Resmi • Kota Banjarbaru</div>
                </div>
                <span class="ml-auto text-xs font-bold bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full" id="countBaznas">0</span>
            </div>

            <!-- UPZ LEGEND DIBUAT BIRU SERAGAM -->
            <div class="bg-cream2/80 rounded-2xl p-3 border border-cream3/80 flex gap-3 items-center shadow-sm hover-smooth">
                <span class="w-3.5 h-3.5 rounded-full bg-blue-600 shrink-0"></span>
                <div>
                    <div class="font-bold text-xs lg:text-sm text-oliveDark">UPZ / Masjid</div>
                    <div class="text-[10px] text-olive/60">Menerima zakat fitrah & maal</div>
                </div>
                <span class="ml-auto text-xs font-bold bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full" id="countUpz">0</span>
            </div>

            <div class="bg-cream2/80 rounded-2xl p-3 border border-cream3/80 flex gap-3 items-center shadow-sm hover-smooth">
                <span class="w-3.5 h-3.5 rounded-full bg-red-500 shrink-0"></span>
                <div>
                    <div class="font-bold text-xs lg:text-sm text-oliveDark">Rumah Warga</div>
                    <div class="text-[10px] text-olive/60">Terdeteksi membutuhkan</div>
                </div>
                <span class="ml-auto text-xs font-bold bg-red-100 text-red-800 px-2.5 py-1 rounded-full" id="countWarga">0</span>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-2 items-center">
            <span class="text-xs font-bold text-oliveDark">Filter:</span>
            <button data-filter="all" class="fbtn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-sm active:scale-95 transition">Semua</button>
            <button data-filter="baznas" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-bold shadow-sm active:scale-95 transition">BAZNAS</button>
            <button data-filter="upz" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-bold shadow-sm active:scale-95 transition">UPZ/Masjid</button>
            <button data-filter="warga" class="fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-bold shadow-sm active:scale-95 transition">Warga</button>
            <span class="text-[11px] text-olive/60 ml-2 font-medium">Data live dari pengelolaan Admin UPZ/BAZNAS.</span>
        </div>
    </div>

    <!-- PETA + LIST LOKASI -->
    <div class="mt-6 grid lg:grid-cols-[1fr_360px] gap-6 anim-smooth delay-2">
        <div class="bg-panel rounded-[24px] border border-panel-border p-2">
            <div id="map"></div>
        </div>

        {{-- List --}}
        <div class="bg-panel rounded-[24px] border border-panel-border p-4 flex flex-col">
            <div class="flex items-center justify-between pb-2 border-b border-cream3/60">
                <h3 class="font-extrabold text-oliveDark text-xs uppercase tracking-wider">Daftar Lokasi</h3>
                <input id="searchBox" placeholder="Cari nama / alamat..." class="border border-cream3 rounded-full px-3 py-1.5 text-xs w-40 bg-cream2 focus:outline-none focus:ring-2 focus:ring-olive/40 transition">
            </div>
            <div id="listBox" class="mt-3 space-y-2 max-h-[440px] overflow-auto pr-1 flex-1"></div>
        </div>
    </div>

    {{-- Penjelasan Warna (SUDAH DIUBAH DARI ORANGE KE BIRU) --}}
    <div class="mt-6 bg-panel rounded-[24px] border border-panel-border p-5 anim-smooth delay-3">
        <h3 class="font-extrabold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-olive"></i> Penjelasan Warna Pin
        </h3>
        <div class="mt-3 grid md:grid-cols-3 gap-4 text-xs">
            <div class="bg-emerald-50/80 rounded-2xl p-4 border border-emerald-100/80 shadow-sm">
                <div class="font-bold text-emerald-800 text-sm flex items-center gap-2">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full inline-block"></span> Hijau — BAZNAS
                </div>
                <p class="text-emerald-900/70 text-xs mt-2 leading-relaxed">Badan Amil Zakat Nasional Kota Banjarbaru. Menerima semua jenis zakat, infak, sedekah. Penyaluran terverifikasi ke 8 asnaf dan program pemberdayaan. Buka jam kerja, ada layanan jemput zakat.</p>
            </div>

            <!-- PENJELASAN UPZ WARNA BIRU -->
            <div class="bg-blue-50/80 rounded-2xl p-4 border border-blue-100/80 shadow-sm">
                <div class="font-bold text-blue-800 text-sm flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-600 rounded-full inline-block"></span> Biru — UPZ / Masjid
                </div>
                <p class="text-blue-900/70 text-xs mt-2 leading-relaxed">Unit Pengumpul Zakat atau masjid yang ditunjuk. Melayani zakat fitrah & maal lingkungan sekitar, fidyah, dan sedekah. Cocok untuk penyaluran terdekat dari rumah.</p>
            </div>

            <div class="bg-red-50/80 rounded-2xl p-4 border border-red-100/80 shadow-sm">
                <div class="font-bold text-red-800 text-sm flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full inline-block"></span> Merah — Rumah Warga
                </div>
                <p class="text-red-900/70 text-xs mt-2 leading-relaxed">Rumah warga / keluarga yang terdeteksi membutuhkan (fakir, miskin, dhuafa) berdasarkan assesmen. Data sensitif — tampil sebagai titik umum; hubungi BAZNAS/UPZ untuk penyaluran langsung.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const spots = @json($spots);

// SINKRONISASI WARNA BIRU UNTUK UPZ (#2563eb)
const color = {baznas:'#10b981', upz:'#2563eb', warga:'#ef4444'};
const label = {baznas:'BAZNAS', upz:'UPZ / Masjid', warga:'Rumah Warga'};

const map = L.map('map').setView([-3.442,114.833], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);

const markers = {};
spots.forEach(s=>{
    const c = color[s.cat] || '#6b7280';
    const icon = L.divIcon({
        html:'<div style="background:'+c+';width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,.35)"></div>',
        className:'', iconSize:[14,14], iconAnchor:[7,7]
    });
    const m = L.marker([s.lat,s.lng],{icon}).addTo(map);
    m.bindPopup(
        '<div style="min-width:220px">' +
        '<div style="font-weight:700;color:#001F3F">'+s.name+'</div>' +
        '<div style="font-size:11px;color:#4B8B3B;margin-top:2px"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:'+c+';margin-right:6px"></span>'+(label[s.cat]||s.cat)+' • '+(s.wil||'')+'</div>' +
        '<div style="font-size:12px;color:#001F3F;margin-top:6px">'+s.addr+'</div>' +
        '<div style="font-size:11px;color:#6b7280;margin-top:4px">'+s.tel+' • '+s.jam+'</div>' +
        (s.ket ? '<div style="font-size:11px;color:#001F3F;margin-top:6px;background:#EAEAEA;padding:6px 8px;border-radius:8px">'+s.ket+'</div>' : '') +
        '<a href="https://www.google.com/maps/dir/?api=1&destination='+s.lat+','+s.lng+'" target="_blank" style="display:inline-block;margin-top:8px;background:#4B8B3B;color:white;padding:6px 12px;border-radius:20px;font-size:12px;text-decoration:none;font-weight:bold">Buka Rute &rarr;</a>' +
        '</div>'
    );
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
        const q = search==='' || (s.name+' '+s.addr+' '+(s.ket||'')).toLowerCase().includes(search.toLowerCase());
        return f && q;
    });
    spots.forEach(s=>{
        if((activeFilter==='all' || s.cat===activeFilter) && (s.name+' '+s.addr).toLowerCase().includes(search.toLowerCase())){ if(!map.hasLayer(markers[s.id])) markers[s.id].addTo(map); }
        else { if(map.hasLayer(markers[s.id])) map.removeLayer(markers[s.id]); }
    });
    box.innerHTML = filtered.map(s=>{
        const c = color[s.cat] || '#6b7280';
        return '<button onclick="focusSpot('+s.id+')" class="w-full text-left bg-cream2/80 rounded-2xl p-3 hover:bg-olive/10 transition border border-cream3/60 shadow-sm group">' +
            '<div class="flex items-center gap-2"><span style="width:10px;height:10px;border-radius:50%;background:'+c+';display:inline-block"></span><span class="text-xs font-extrabold" style="color:'+c+'">'+(label[s.cat]||s.cat)+'</span></div>' +
            '<div class="font-bold text-xs text-oliveDark mt-1 group-hover:text-olive transition">'+s.name+'</div>' +
            '<div class="text-[11px] text-olive/60 truncate">'+s.addr+'</div>' +
        '</button>';
    }).join('') || '<div class="text-xs text-olive/50 text-center py-8">Tidak ada hasil.</div>';
}
window.focusSpot = id=>{
    const s=spots.find(x=>x.id===id);
    map.setView([s.lat,s.lng], 16);
    markers[id].openPopup();
};
document.querySelectorAll('.fbtn').forEach(b=>{
    b.addEventListener('click', ()=>{
        activeFilter=b.dataset.filter;
        document.querySelectorAll('.fbtn').forEach(x=> x.className='fbtn bg-white border border-cream3 text-olive px-4 py-1.5 rounded-full text-xs font-bold shadow-sm transition');
        b.className='fbtn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-sm transition';
        renderList();
    });
});
document.getElementById('searchBox').addEventListener('input', e=>{ search=e.target.value; renderList(); });
renderList();
</script>
@endsection