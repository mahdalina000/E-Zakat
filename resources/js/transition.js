/* ============================================================
   E-Zakat — Smooth Page Transition (SPA-feel)
   Dipakai oleh SEMUA layout (app, welcome, guest, dashboard)
   Tidak butuh library eksternal.
   ============================================================ */
(function () {
    'use strict';

    // ---- 0. State & Util ----
    const isNav = sessionStorage.getItem('zy_nav') === '1';
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
        // Coba berbagai kemungkinan wrapper konten
        const candidates = [
            document.querySelector('main'),
            document.querySelector('[role="main"]'),
            document.querySelector('.anim-dashboard'),   // dashboard
            document.querySelector('[class*="flex-1"][class*="content"]'),
            document.querySelector('.max-w-7xl'),        // halaman publik
        ];
        for (const el of candidates) {
            if (el && el !== document.body) {
                el.setAttribute('data-page-transition', '');
                return el;
            }
        }
        // Fallback: body
        document.body.setAttribute('data-page-transition', '');
        return document.body;
    }

    // ---- 3. Interceptor klik link internal ----
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
        // Link rel="external" atau form submit
        if (a.closest('form')) return;

        // Tandai navigasi + animasi keluar
        sessionStorage.setItem('zy_nav', '1');
        document.body.classList.add('zy-nav-out');

        // Progress bar langsung tampil
        const bar = ensureProgress();
        bar.style.opacity = '1';
        setTimeout(() => { bar.style.width = '70%'; }, 30);
    }, false);

    // ---- 4. Saat halaman baru siap ----
    window.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('zy-progress');

        // Smooth scroll
        document.documentElement.classList.add('zy-smooth-scroll');

        // Mark konten utama
        markContent();

        if (isNav && !prefersReduced) {
            // Release overflow:hidden dari halaman sebelumnya (mis. welcome)
            document.body.style.overflow = '';

            document.body.classList.add('zy-nav-in');
            window.scrollTo(0, 0);

            // Fade out progress bar setelah konten masuk
            setTimeout(() => {
                if (bar) {
                    bar.style.width = '100%';
                    setTimeout(() => {
                        bar.style.opacity = '0';
                        setTimeout(() => { bar.style.width = '0%'; }, 250);
                    }, 150);
                }
            }, 80);

            // Bersihkan flag
            sessionStorage.removeItem('zy_nav');
            document.body.classList.remove('zy-nav-out');

            // Jalankan scroll reveal
            initReveal();
        } else {
            // Fresh load (bukan navigasi): biarkan animasi bawaan halaman
            // (anim-smooth, anim-welcome, anim-auth, anim-dashboard sudah handle)
        }
    });

    // ---- 5. Scroll Reveal (IntersectionObserver) ----
    function initReveal() {
        if (prefersReduced) return;

        // Elemen yang akan di-reveal — hanya yang BELUM punya animasi sendiri
        const targets = document.querySelectorAll(
            [
                'main > *',
                '.grid > *',
                '.space-y-6 > *',
                '.space-y-4 > *',
                '.space-y-3 > *',
                '.anim-dashboard > *',
            ].join(',')
        );
        if (!targets.length) return;

        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('zy-in');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });

        targets.forEach((el, i) => {
            // Lewati elemen yang sudah punya animasi sendiri
            if (el.classList.contains('anim-smooth') ||
                el.classList.contains('anim-welcome') ||
                el.classList.contains('anim-auth') ||
                el.classList.contains('anim-dashboard') ||
                el.hasAttribute('data-page-transition')) return;

            const delay = Math.min(i * 50, 450);
            el.style.setProperty('--zy-delay', delay + 'ms');
            el.classList.add('zy-reveal');
            io.observe(el);
        });
    }

})();
