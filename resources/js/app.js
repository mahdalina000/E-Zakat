// E-Zakat — JS bundling via Vite
// Leaflet untuk peta di /direktori
// Chart.js untuk dashboard super admin

// Turbo (Hotwire) — navigasi instan tanpa full reload
import * as Turbo from '@hotwired/turbo';
window.Turbo = Turbo;

// Leaflet & Chart.js global via namespace import (UMD)
import * as LeafletNS from 'leaflet';
const L = (LeafletNS && LeafletNS.default) ? LeafletNS.default : LeafletNS;
window.L = L;

import Chart from 'chart.js/auto';
window.Chart = Chart;

// Leaflet CSS — Vite akan auto-bundle
import 'leaflet/dist/leaflet.css';

// Smooth page transition (SPA-feel) — nonaktif otomatis saat Turbo aktif
import './transition.js';

// Helper: jalankan `fn` begitu DOM siap — aman untuk load pertama DAN
// navigasi Turbo (di mana DOMContentLoaded tidak menyala lagi).
window.ezOnReady = function (fn) {
    if (typeof fn !== 'function') return;
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        fn();
    }
};

// ---- Transisi halus setelah Turbo mengganti konten ----
// Dipicu pada SETIAP render Turbo sehingga animasi fade-in selalu
// main lagi (bukan hanya sekali). Berlaku untuk semua halaman.
function playTurboIn() {
    const b = document.body;
    b.classList.remove('zy-turbo-in');
    // Paksa reflow supaya animasi bisa main lagi tiap render.
    void b.offsetWidth;
    b.classList.add('zy-turbo-in');
}

document.addEventListener('turbo:render', playTurboIn);
document.addEventListener('turbo:load', playTurboIn);

console.log('[E-Zakat] JS bundle: Turbo + Leaflet + Chart.js + Transition loaded');

