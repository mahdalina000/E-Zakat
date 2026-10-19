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

console.log('[E-Zakat] JS bundle: Leaflet + Chart.js loaded');

