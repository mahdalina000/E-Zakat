// E-Zakat Service Worker
// Strategi: cache ONLY static assets (Vite /build, fonts, images).
// TIDAK cache HTML halaman -> navigasi selalu fresh dari server,
// tanpa efek "stale" service worker.

const ASSET_CACHE = 'ezakat-assets-v2';
const ASSET_RE = /\/(build|images)\/|\.(woff2?|ttf|eot|otf|css|js|png|jpe?g|webp|svg|ico)(\?|$)/i;

self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(keys.filter((k) => k !== ASSET_CACHE).map((k) => caches.delete(k))))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;

  const url = new URL(req.url);
  if (url.origin !== self.location.origin) return;

  // Hanya cache asset statis; HTML & API tetap network-first tanpa cache.
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
