/**
 * E-Zakat Service Worker
 * Cache-first for static assets, network-first for pages
 * 
 * Cache strategy:
 * - Public static assets (CSS, JS, fonts, images): cache-first, long-lived
 * - HTML pages: network-first, fall back to cache on offline
 * - API / dynamic: no cache
 */

const CACHE_NAME = 'ezakat-v1';
const STATIC_CACHE = [
  '/',
  '/beranda',
  '/kalkulator',
  '/direktori',
  '/panduan',
  '/login',
];

// Assets that should always be cached aggressively
const ASSET_PATTERNS = [
  /\.(css|js|woff2?|ttf|eot|svg|png|jpg|jpeg|webp|ico)$/i,
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_CACHE);
    })
  );
});

self.addEventListener('activate', (event) => {
  // Remove old caches
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys
          .filter((key) => key !== CACHE_NAME)
          .map((key) => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Only handle same-origin GET requests
  if (request.method !== 'GET' || url.origin !== location.origin) {
    return;
  }

  // Static assets: cache-first
  if (ASSET_PATTERNS.some((p) => p.test(url.pathname))) {
    event.respondWith(
      caches.match(request).then((cached) => {
        if (cached) return cached;
        return fetch(request).then((response) => {
          const clone = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
          return response;
        });
      })
    );
    return;
  }

  // HTML pages: network-first, fall back to cache
  if (request.mode === 'navigate' || url.pathname.startsWith('/')) {
    event.respondWith(
      fetch(request)
        .then((response) => {
          const clone = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
          return response;
        })
        .catch(() => caches.match(request).then((cached) => cached || new Response('Offline', { status: 503, statusText: 'Offline' })))
    );
  }
});
