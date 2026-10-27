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

console.log('[E-Zakat] JS bundle: Turbo + Leaflet + Chart.js + Transition loaded');

