@extends('layouts.app')
@section('title','Lokasi Penyaluran Zakat — E-Zakat Banjarbaru')

@section('head')
<!-- Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

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
    body.dark-mode .text-black\/80,
    body.dark-mode .text-black\/70,
    body.dark-mode .text-black\/60,
    body.dark-mode .text-black\/50 { color: #e2e8f0 !important; }
    body.dark-mode .text-oliveDark\/80,
    body.dark-mode .text-oliveDark\/70,
    body.dark-mode .text-oliveDark\/60 { color: #cbd5e1 !important; }
    /* Aksen emas di dark mode */
    body.dark-mode .text-gold,
    body.dark-mode .text-gold2 { color: #D4AF37 !important; }
    body.dark-mode .text-gold { color: #F2C94C !important; }
    body.dark-mode .bg-gold\/15 { background-color: rgba(212,175,55,0.20) !important; }
    body.dark-mode .border-gold\/40 { border-color: rgba(212,175,55,0.45) !important; }

    /* FIX TEKS POPUP MAPS — terang di dark, gelap di light (kontras dua-duanya) */
    .leaflet-popup-content-wrapper,
    .leaflet-popup-content,
    .leaflet-popup-content b,
    .leaflet-popup-content span {
        color: #0F172A !important;
    }
    body.dark-mode .leaflet-popup-content-wrapper {
        background-color: #1e293b !important;
        border-color: rgba(212,175,55,0.3) !important;
    }
    body.dark-mode .leaflet-popup-content,
    body.dark-mode .leaflet-popup-content b,
    body.dark-mode .leaflet-popup-content span {
        color: #f8fafc !important;
    }

    /* BLOK PUTIH TRANSPARAN SAAT DARK MODE */
    body.dark-mode .bg-panel,
    body.dark-mode .bg-panel-2\/70,
    body.dark-mode .bg-panel-2 { 
        background-color: rgba(255, 255, 255, 0.12) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-color: rgba(255, 255, 255, 0.2) !important; 
    }

    body.dark-mode input {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        color: #FFFFFF !important;
    }

    /* MENYEMBUNYIKAN SEMUA CAHAYA/GLOW ORANYE KUNING DI BACKGROUND LAYOUT INDUK */
    body > div > div[class*="amber"],
    body > div > div[class*="yellow"],
    body > div > div[class*="earth"],
    body > div > .absolute.right-0,
    body > div > .absolute.top-0.right-0,
    body > div > .absolute.bottom-0.right-0,
    [class*="bg-amber"],
    [class*="bg-yellow-500"],
    [class*="bg-gold"],
    [class*="from-amber"],
    [class*="from-yellow"] {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        background: none !important;
    }

    /* STRUKTUR GRID FIX */
    .fix-grid-layout {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .fix-grid-layout {
            grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
        }
        .fix-col-map {
            grid-column: span 8 / span 8 !important;
        }
        .fix-col-list {
            grid-column: span 4 / span 4 !important;
        }
    }

    .map-wrapper {
        width: 100% !important;
        height: 420px !important;
        position: relative !important;
        border-radius: 16px !important;
        overflow: hidden !important;
    }

    #map {
        width: 100% !important;
        height: 100% !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 10 !important;
    }

    .leaflet-container {
        width: 100% !important;
        height: 100% !important;
    }

    /* CUSTOM PIN MARKER MAP */
    .custom-pin {
        width: 28px;
        height: 28px;
        border-radius: 50% 50% 50% 0;
        position: absolute;
        transform: rotate(-45deg);
        left: 50%;
        top: 50%;
        margin: -20px 0 0 -14px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #FFFFFF;
    }
    .custom-pin::after {
        content: '';
        width: 10px;
        height: 10px;
        margin: 0;
        background: #FFFFFF;
        position: absolute;
        border-radius: 50%;
    }
    .pin-baznas { background: #10B981; }
    .pin-upz { background: #2563EB; }
    .pin-warga { background: #F43F5E; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 w-full space-y-4">

    <!-- BLOK 1: HEADER JUDUL & KARTU STATISTIK PENYALURAN -->
    <div class="bg-panel rounded-[24px] border border-panel-border p-5 lg:p-6 shadow-sm space-y-5">
        <div>
            <h1 class="font-black text-oliveDark text-xl lg:text-2xl flex items-center gap-2">
                <i class="fa-solid fa-map-location-dot text-black"></i> Lokasi Penyaluran Zakat — Banjarbaru
            </h1>
            <p class="text-xs lg:text-sm text-black/70 mt-1 font-medium">Peta interaktif titik penyaluran. Filter berdasarkan kategori dan klik pin untuk detail & rute.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-3">
            <div class="bg-panel-2 rounded-2xl p-3.5 border border-emerald-500/30 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-3.5 h-3.5 rounded-full bg-emerald-500 shrink-0"></div>
                    <div>
                        <div class="font-extrabold text-xs text-oliveDark">BAZNAS</div>
                        <div class="text-[10px] text-black/70">Resmi • Kota Banjarbaru</div>
                    </div>
                </div>
                <span id="countBaznas" class="font-black text-sm bg-emerald-500 text-white px-2.5 py-0.5 rounded-full">0</span>
            </div>

            <div class="bg-panel-2 rounded-2xl p-3.5 border border-blue-500/30 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-3.5 h-3.5 rounded-full bg-blue-600 shrink-0"></div>
                    <div>
                        <div class="font-extrabold text-xs text-oliveDark">UPZ / Masjid</div>
                        <div class="text-[10px] text-black/70">Menerima zakat fitrah & maal</div>
                    </div>
                </div>
                <span id="countUpz" class="font-black text-sm bg-blue-600 text-white px-2.5 py-0.5 rounded-full">0</span>
            </div>

            <div class="bg-panel-2 rounded-2xl p-3.5 border border-rose-500/30 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-3.5 h-3.5 rounded-full bg-rose-500 shrink-0"></div>
                    <div>
                        <div class="font-extrabold text-xs text-oliveDark">Rumah Warga</div>
                        <div class="text-[10px] text-black/70">Terdeteksi membutuhkan</div>
                    </div>
                </div>
                <span id="countWarga" class="font-black text-sm bg-rose-500 text-white px-2.5 py-0.5 rounded-full">0</span>
            </div>
        </div>
    </div>

    <!-- BLOK 2: BAR FILTER PETA TERPISAH -->
    <div class="bg-panel rounded-2xl p-3.5 border border-panel-border flex flex-wrap items-center justify-between gap-3 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-oliveDark">Filter:</span>
            <button data-filter="all" class="filter-btn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-bold transition active:scale-95 shadow-sm">Semua</button>
            <button data-filter="baznas" class="filter-btn border border-emerald-500/40 text-black px-4 py-1.5 rounded-full text-xs font-bold transition active:scale-95">BAZNAS</button>
            <button data-filter="upz" class="filter-btn border border-blue-500/40 text-black px-4 py-1.5 rounded-full text-xs font-bold transition active:scale-95">UPZ/Masjid</button>
            <button data-filter="warga" class="filter-btn border border-rose-500/40 text-black px-4 py-1.5 rounded-full text-xs font-bold transition active:scale-95">Warga</button>
        </div>
        <div class="text-[11px] text-black/60 font-medium">
            <i class="fa-solid fa-circle-info mr-1"></i> Data live dari pengelolaan Admin UPZ/BAZNAS.
        </div>
    </div>

    <!-- CONTAINER UTAMA PETA & DAFTAR LOKASI -->
    <div class="fix-grid-layout">
        
        <!-- KOLOM PETA (KIRI) -->
        <div class="fix-col-map bg-panel rounded-[24px] border border-panel-border p-3.5 shadow-md w-full flex flex-col justify-between space-y-3">
            <div class="map-wrapper">
                <div id="map"></div>
            </div>

            <!-- LEGENDA PENJELASAN WARNA PENANDA LOKASI DI BAWAH PETA -->
            <div class="bg-panel-2 rounded-2xl p-3 border border-panel-border">
                <div class="text-[11px] font-extrabold text-oliveDark mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-layer-group"></i> Penjelasan Warna Titik Lokasi pada Peta:
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-[11px]">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0 border border-white"></span>
                        <span class="text-black/80 font-semibold">Hijau: <span class="font-normal">Kantor BAZNAS Resmi</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-600 shrink-0 border border-white"></span>
                        <span class="text-black/80 font-semibold">Biru: <span class="font-normal">UPZ / Masjid / Musholla</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500 shrink-0 border border-white"></span>
                        <span class="text-black/80 font-semibold">Merah: <span class="font-normal">Rumah Warga Membutuhkan</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM DAFTAR LOKASI (KANAN) -->
        <div class="fix-col-list bg-panel rounded-[24px] border border-panel-border p-5 shadow-md flex flex-col justify-between space-y-4 w-full">
            <div>
                <div class="flex items-center justify-between gap-2 mb-3">
                    <h2 class="font-black text-xs uppercase tracking-wider text-oliveDark">DAFTAR LOKASI</h2>
                    <input id="searchLocation" type="text" placeholder="Cari nama / alamat..." class="border border-panel-border rounded-full px-3 py-1 text-xs bg-panel-2 font-medium w-36">
                </div>

                <!-- LIST LOKASI SCROLLABLE -->
                <div id="locationList" class="space-y-2.5 max-h-[350px] overflow-y-auto pr-1">
                    <!-- Item lokasi diproduksi via JS -->
                </div>
            </div>

            <div class="bg-panel-2 rounded-2xl p-3 border border-panel-border text-[11px] text-black/70 leading-relaxed">
                <i class="fa-solid fa-location-arrow text-oliveDark mr-1"></i> Klik salah satu lokasi di daftar atau pin di peta untuk melihat rute petunjuk arah.
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const banjarbaruCoords = [-3.4402, 114.8302];
    
    const map = L.map('map', {
        center: banjarbaruCoords,
        zoom: 13
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    function fixMapSize() {
        setTimeout(() => { map.invalidateSize(); }, 200);
        setTimeout(() => { map.invalidateSize(); }, 600);
    }
    fixMapSize();
    window.addEventListener('resize', fixMapSize);

    function createCustomIcon(category) {
        let pinClass = 'pin-baznas';
        if (category === 'upz') pinClass = 'pin-upz';
        if (category === 'warga') pinClass = 'pin-warga';

        return L.divIcon({
            className: 'custom-pin-wrapper',
            html: `<div class="custom-pin ${pinClass}"></div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 28],
            popupAnchor: [0, -28]
        });
    }

    const locations = [
        { id: 1, name: "BAZNAS Kota Banjarbaru", cat: "baznas", lat: -3.4428, lng: 114.8315, address: "Jl. Panglima Batur No. 1, Loktabat Utara" },
        { id: 2, name: "UPZ Masjid Agung Al-Munawwarah", cat: "upz", lat: -3.4410, lng: 114.8340, address: "Jl. Trikora, Banjarbaru" },
        { id: 3, name: "UPZ Masjid Landasan Ulin", cat: "upz", lat: -3.4500, lng: 114.8000, address: "Jl. A. Yani Km. 23, Landasan Ulin" },
        { id: 4, name: "Penerima Fidyah & Zakat (Warga 1)", cat: "warga", lat: -3.4350, lng: 114.8250, address: "Guntung Paikat, Banjarbaru" },
    ];

    let markers = [];

    function renderLocations(filter = 'all', search = '') {
        const listEl = document.getElementById('locationList');
        if(!listEl) return;
        listEl.innerHTML = '';

        markers.forEach(m => map.removeLayer(m));
        markers = [];

        let countBaznas = 0, countUpz = 0, countWarga = 0;

        locations.forEach(loc => {
            if(loc.cat === 'baznas') countBaznas++;
            if(loc.cat === 'upz') countUpz++;
            if(loc.cat === 'warga') countWarga++;

            const matchFilter = filter === 'all' || loc.cat === filter;
            const matchSearch = loc.name.toLowerCase().includes(search.toLowerCase()) || loc.address.toLowerCase().includes(search.toLowerCase());

            if(matchFilter && matchSearch) {
                const marker = L.marker([loc.lat, loc.lng], { icon: createCustomIcon(loc.cat) }).addTo(map)
                    .bindPopup(`<b style="color:#0F172A;">${loc.name}</b><br><span style="font-size:11px; color:#475569;">${loc.address}</span>`);
                markers.push(marker);

                const item = document.createElement('div');
                item.className = 'bg-panel-2 rounded-xl p-2.5 border border-panel-border hover:border-olive cursor-pointer transition text-xs flex items-center justify-between';
                
                let dotColor = 'bg-emerald-500';
                if (loc.cat === 'upz') dotColor = 'bg-blue-600';
                if (loc.cat === 'warga') dotColor = 'bg-rose-500';

                item.innerHTML = `
                    <div class="flex items-start gap-2.5 overflow-hidden">
                        <span class="w-2.5 h-2.5 rounded-full ${dotColor} shrink-0 mt-1"></span>
                        <div class="truncate">
                            <div class="font-extrabold text-oliveDark truncate">${loc.name}</div>
                            <div class="text-[10px] text-black/70 truncate mt-0.5">${loc.address}</div>
                        </div>
                    </div>
                `;
                item.addEventListener('click', () => {
                    map.setView([loc.lat, loc.lng], 15);
                    marker.openPopup();
                });
                listEl.appendChild(item);
            }
        });

        document.getElementById('countBaznas').textContent = countBaznas;
        document.getElementById('countUpz').textContent = countUpz;
        document.getElementById('countWarga').textContent = countWarga;
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.className = 'filter-btn border border-panel-border text-black px-4 py-1.5 rounded-full text-xs font-bold transition';
            });
            btn.className = 'filter-btn bg-olive text-white px-4 py-1.5 rounded-full text-xs font-bold transition shadow-sm';
            renderLocations(btn.dataset.filter, document.getElementById('searchLocation').value);
        });
    });

    document.getElementById('searchLocation')?.addEventListener('input', (e) => {
        const activeFilter = document.querySelector('.filter-btn.bg-olive')?.dataset.filter || 'all';
        renderLocations(activeFilter, e.target.value);
    });

    renderLocations();
});
</script>
@endsection