// E-Zakat — JS bundling via Vite
// Leaflet untuk peta di /direktori
// Chart.js untuk dashboard super admin

// Leaflet & Chart.js global via namespace import (UMD)
import * as LeafletNS from 'leaflet';
const L = (LeafletNS && LeafletNS.default) ? LeafletNS.default : LeafletNS;
window.L = L;

import Chart from 'chart.js/auto';
window.Chart = Chart;

// Leaflet CSS — Vite akan auto-bundle
import 'leaflet/dist/leaflet.css';

// Turbo (Hotwire) — navigasi instan tanpa full reload
// (side-effect import: langsung aktif; expose window.Turbo oleh Turbo sendiri)
import '@hotwired/turbo';
// Sekali render, handler SPA kita adalah Turbo; nonaktifkan yang duplikat
document.documentElement.setAttribute('data-turbo-progress-bar', 'false');

// Helper universal: jalankan fn setelah DOM siap, BAIK fresh load maupun
// navigasi Turbo (terpicu ulang tiap halaman).
window.ezOnReady = function (fn) {
    if (typeof fn !== 'function') return;
    if (document.readyState !== 'loading') {
        // Sudah siap: jalankan mikro-moment berikutnya
        requestAnimationFrame(fn);
        return;
    }
    document.addEventListener('DOMContentLoaded', fn, { once: true });
};

// Page transition (SPA-feel) — berjalan bersama Turbo
import './transition.js';

console.log('[E-Zakat] JS bundle: Turbo + Leaflet + Chart.js loaded');

