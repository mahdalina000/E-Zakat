/**
 * E-Zakat Service Worker — optimasi kecepatan navigasi
 *
 * Strategi:
 * - ASSET (CSS/JS/font/gambar dari /build & /images): cache-first
 *   -> setelah visit pertama, pindah halaman = instan (tidak download ulang)
 * - HALAMAN (navigate): selalu dari network (jangan cache, karena konten
 *   dinamis + session-based), kecuali offline -> fallback ke cache
 *
 * Hanya efektif setelah install (skipWaiting + claim langsung).
 */

const CACHE = 'ezakat-assets-v1';
const PAGE_CACHE = 'ezakat-pages-v1';

// Pola asset yang di-cache agresif
const ASSET_RE = /\/(build|images)\/.+|\.woff2?|\.ttf|\.eot/i;

self.addEventListener('install', (event) => {
    // Tidak pre-cache apa pun di install:
    // pre-cache halaman akan STALE (sesi/user beda) dan memblokir aktivasi.
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        (async () => {
            const keys = await caches.keys();
            await Promise.all(keys.filter(k => k !== CACHE && k !== PAGE_CACHE)
                .map(k => caches.delete(k)));
            await self.clients.claim();
        })()
    );
});

self.addEventListener('fetch', (event) => {
    const req = event.request;

    // Hanya GET same-origin
    if (req.method !== 'GET') return;
    const url = new URL(req.url);
    if (url.origin !== self.location.origin) return;

    // ============ 1. ASSET: cache-first ============
    if (ASSET_RE.test(url.pathname)) {
        event.respondWith(
            (async () => {
                const cached = await caches.match(req);
                if (cached) return cached;
                try {
                    const res = await fetch(req);
                    if (res.ok) {
                        const cache = await caches.open(CACHE);
                        await cache.put(req, res.clone());
                    }
                    return res;
                } catch (e) {
                    return new Response('', { status: 503 });
                }
            })()
        );
        return;
    }

    // ============ 2. HALAMAN: network-first, fallback offline ============
    if (req.mode === 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    const res = await fetch(req);
                    if (res.ok) {
                        const cache = await caches.open(PAGE_CACHE);
                        await cache.put(req, res.clone());
                    }
                    return res;
                } catch (e) {
                    const cached = await caches.match(req);
                    if (cached) return cached;
                    return new Response('<h1>Offline</h1><p>Terhubung ke internet untuk lanjut.</p>', {
                        status: 503,
                        headers: { 'Content-Type': 'text/html' },
                    });
                }
            })()
        );
    }
});
