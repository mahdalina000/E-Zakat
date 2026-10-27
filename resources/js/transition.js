/* ============================================================
   E-Zakat — Smooth Page Transition (SPA-feel)
   Dipakai oleh SEMUA layout (app, welcome, guest, dashboard)
   Tidak butuh library eksternal.
   Prinsip: CEPAT — konten tampil langsung, reveal hanya untuk
   konten di bawah layar (agar scroll tetap smooth).
   ============================================================ */
(function () {
    'use strict';

    // ---- 0. State & Util ----
    const isNav = sessionStorage.getItem('zy_nav') === '1';
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hasTurbo = !!(window.Turbo);

    // ---- 1. Progress bar ----
    let progressEl = null;
    function ensureProgress() {
        if (progressEl) return progressEl;
        progressEl = document.createElement('div');
        progressEl.id = 'zy-progress';
        document.body.appendChild(progressEl);
        return progressEl;
    }

    // ---- 2. Deteksi konten utama (robust untuk semua layout) ----
    function markContent() {
        const candidates = [
            document.querySelector('main'),
            document.querySelector('[role="main"]'),
            document.querySelector('.anim-dashboard'),   // dashboard
            document.querySelector('.max-w-7xl'),         // halaman publik
        ];
        for (const el of candidates) {
            if (el && el !== document.body) {
                el.setAttribute('data-page-transition', '');
                return el;
            }
        }
        document.body.setAttribute('data-page-transition', '');
        return document.body;
    }

    // ---- 3. Interceptor klik link internal (HANYA tanpa Turbo) ----
    // Jika Turbo aktif, Turbo-lah yang menangani klik & navigasi; interceptor
    // ini dinonaktifkan agar tidak duplikat dengan Turbo.
    // Simpan arah navigasi agar animasi masuk bisa disesuaikan
    // (maju: slide dari kanan; kembali: slide dari kiri).
    function markNav(dir) {
        sessionStorage.setItem('zy_dir', dir);
    }

    if (!hasTurbo) {
        document.addEventListener('click', function (e) {
            const a = e.target.closest('a[href]');
            if (!a || e.defaultPrevented) return;
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            if (a.target === '_blank' || a.hasAttribute('download')) return;
            const href = a.getAttribute('href');
            if (!href) return;
            // Skip anchor, mailto, tel, javascript
            if (href.startsWith('#') || href.startsWith('mailto') ||
                href.startsWith('tel:') || href.startsWith('javascript:')) return;
            // Skip eksternal (non-origin)
            if (href.startsWith('http')) {
                try {
                    const u = new URL(href, location.href);
                    if (u.origin !== location.origin) return;
                } catch (_) { return; }
            }
            // Link dalam form
            if (a.closest('form')) return;

            // Tandai navigasi maju + animasi keluar (cepat: 0.14s)
            markNav('f');
            sessionStorage.setItem('zy_nav', '1');
            document.body.classList.add('zy-nav-out');

            // Progress bar langsung tampil
            const bar = ensureProgress();
            bar.style.opacity = '1';
            setTimeout(() => { bar.style.width = '70%'; }, 20);
        }, false);
    } else {
        // Turbo: tandai arah maju saat Turbo mulai navigate
        document.addEventListener('turbo:click', function () {
            markNav('f');
            sessionStorage.setItem('zy_nav', '1');
        });
    }

    // Deteksi tombol kembali/maju browser (popstate)
    window.addEventListener('popstate', function () {
        markNav('b');
        sessionStorage.setItem('zy_nav', '1');
    });

    // ---- 4. Saat halaman baru siap ----
    // Dengan Turbo, pemicunya adalah turbo:load / turbo:render (bukan
    // DOMContentLoaded). Tanpa Turbo, tetap DOMContentLoaded.
    function onPageReady() {
        const bar = document.getElementById('zy-progress');

        // Smooth scroll
        document.documentElement.classList.add('zy-smooth-scroll');

        // Mark konten utama
        markContent();

        // Pasang arah navigasi agar animasi slide masuk sesuai arah
        if (sessionStorage.getItem('zy_nav') === '1') {
            const dir = sessionStorage.getItem('zy_dir');
            document.body.classList.remove('zy-dir-f', 'zy-dir-b');
            if (dir === 'b') {
                document.body.classList.add('zy-dir-b');
            } else {
                document.body.classList.add('zy-dir-f');
            }
        }

        if (!prefersReduced) {
            // Release overflow:hidden dari halaman sebelumnya (mis. welcome)
            document.body.style.overflow = '';

            document.body.classList.add('zy-nav-in');

            // Fade out progress bar SETELAH konten masuk (cepat)
            if (bar) {
                bar.style.width = '100%';
                setTimeout(() => {
                    bar.style.opacity = '0';
                    setTimeout(() => { bar.style.width = '0%'; }, 200);
                }, 120);
            }

            // Bersihkan flag
            sessionStorage.removeItem('zy_nav');

            // Reveal HANYA konten di bawah layar (biar scroll smooth)
            initBelowFoldReveal();
        }
        // Fresh load: tidak perlu reveal — animasi CSS bawaan (anim-smooth,
        // anim-welcome, anim-auth, anim-dashboard) sudah handle tampil.
    }

    if (hasTurbo) {
        // Jalankan saat halaman dirender oleh Turbo
        document.addEventListener('turbo:render', onPageReady);
        // Fallback untuk kunjungan pertama (full load) sebelum Turbo aktif
        window.addEventListener('DOMContentLoaded', onPageReady);
    } else {
        window.addEventListener('DOMContentLoaded', onPageReady);
    }

    // ---- 5. Reveal KONTEN DI BAWAH LAYAR SAJA ----
    // Tidak ada elemen yang di-hide sampai di-scroll — konten di atas
    // layar langsung tampil. Ini yang bikin navigasi terasa CEPAT.
    function initBelowFoldReveal() {
        if (prefersReduced) return;

        const targets = document.querySelectorAll(
            ['.grid > *', '.space-y-6 > *', '.anim-dashboard > *'].join(',')
        );
        if (!targets.length) return;

        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('zy-in');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px -40px 0px' });

        targets.forEach((el, i) => {
            // Lewati elemen yang sudah punya animasi sendiri
            if (el.classList.contains('anim-smooth') ||
                el.classList.contains('anim-welcome') ||
                el.classList.contains('anim-auth') ||
                el.classList.contains('anim-dashboard') ||
                el.hasAttribute('data-page-transition')) return;

            // Elemen yang SUDAH terlihat di viewport: langsung reveal,
            // tanpa jeda — biar tidak ada "lambat muncul"
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('zy-reveal', 'zy-in');
                return;
            }

            const delay = Math.min(i * 40, 300);
            el.style.setProperty('--zy-delay', delay + 'ms');
            el.classList.add('zy-reveal');
            io.observe(el);
        });
    }

})();
