// E-Zakat Service Worker
// Strategi cache:
//  - Aset statis (Vite /build, fonts, images, audio): cache-first.
//  - Navigasi halaman (HTML): stale-while-revalidate -> halaman langsung tampil
//    dari cache (instan), lalu di-refresh di latar belakang agar tetap segar.
//  - API: network-only (tidak pernah di-cache).

const ASSET_CACHE = 'ezakat-assets-v5';
const NAV_CACHE = 'ezakat-nav-v5';

// Aset statis yang di-cache-first
const ASSET_RE = /\/(build|images|audio)\/|\\.(woff2?|ttf|eot|otf|css|js|png|jpe?g|webp|svg|ico|mp3|m4a|aac)(\?|$)/i;

// Halaman inti yang di-precache saat install agar navigasi pertama pun instan
const PRECACHE_ROUTES = [
  '/',
  '/beranda',
  '/kalkulator',
  '/direktori',
  '/panduan',
  '/login',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(NAV_CACHE).then((cache) =>
      // Ignore kegagalan fetch (mis. belum ada server) — jangan gagalkan install
      Promise.allSettled(PRECACHE_ROUTES.map((route) =>
        cache.add(route).catch(() => null)
      ))
    ).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys
          .filter((k) => k !== ASSET_CACHE && k !== NAV_CACHE)
          .map((k) => caches.delete(k))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;

  const url = new URL(req.url);
  if (url.origin !== self.location.origin) return;

  // ---- Navigasi halaman (HTML): stale-while-revalidate ----
  if (req.mode === 'navigate') {
    event.respondWith(
      caches.match(req).then((cached) => {
        // Refetch di belakang untuk refresh cache
        const refreshPromise = fetch(req)
          .then((res) => {
            if (res.ok && res.type === 'basic') {
              const copy = res.clone();
              caches.open(NAV_CACHE).then((cache) => cache.put(req, copy));
            }
            return res;
          })
          .catch(() => null);

        if (cached) {
          // Tampilkan langsung dari cache, refresh di background
          refreshPromise;
          return cached;
        }
        return refreshPromise;
      })
    );
    return;
  }

  // ---- Aset statis: cache-first ----
  if (!ASSET_RE.test(url.pathname)) return;

  event.respondWith(
    caches.match(req).then((cached) => {
      if (cached) return cached;
      return fetch(req).then((res) => {
        if (res.ok && res.type === 'basic') {
          const copy = res.clone();
          caches.open(ASSET_CACHE).then((cache) => cache.put(req, copy));
        }
        return res;
      });
    })
  );
});
