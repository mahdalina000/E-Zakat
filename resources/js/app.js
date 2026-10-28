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

// NOTE: Navigasi SPA (Turbo) DINONAKTIFKAN — kembali ke navigasi penuh
// standar (satu full-load per klik) agar andal & tanpa refresh ganda.

// Helper universal: jalankan fn setelah DOM siap, BAIK fresh load maupun
// navigasi Turbo (terpicu ulang tiap halaman).
// Jika inline polyfill <head> sudah mengantri callback (window.ezOnReady),
// flush antrian tersebut begitu implementasi asli siap.
(function () {
    const polyfillQueue = window.ezOnReady; // stub antrian dari <head>
    window.ezOnReady = function (fn) {
        if (typeof fn !== 'function') return;
        if (document.readyState !== 'loading') {
            // Sudah siap: jalankan mikro-moment berikutnya
            requestAnimationFrame(fn);
            return;
        }
        document.addEventListener('DOMContentLoaded', fn, { once: true });
    };
    if (polyfillQueue && typeof polyfillQueue.flush === 'function') {
        polyfillQueue.flush();
    }
})();

// Page transition (SPA-feel) — berjalan bersama Turbo
import './transition.js';

console.log('[E-Zakat] JS bundle: Turbo + Leaflet + Chart.js loaded');

