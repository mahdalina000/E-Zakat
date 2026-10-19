/* ============================================================
   E-Zakat — Smooth Page Transition (SPA-feel)
   Dipanggil oleh layouts/app.blade.php (dan welcome)
   Tidak butuh library eksternal.
   ============================================================ */
(function () {
    'use strict';

    // ---- 0. Util ----
    const isNav = sessionStorage.getItem('zy_nav') === '1';
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ---- 1. Progress bar ----
    let progress = null;
    function ensureProgress() {
        if (progress) return progress;
        progress = document.createElement('div');
        progress.id = 'zy-progress';
        document.body.appendChild(progress);
        return progress;
    }

    // ---- 2. Interceptor klik link internal ----
    document.addEventListener('click', function (e) {
        // Cegah: klik modifer, target=_blank, download, form, anchor
        const a = e.target.closest('a[href]');
        if (!a || e.defaultPrevented) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        if (a.target === '_blank' || a.hasAttribute('download')) return;
        const href = a.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto') ||
            href.startsWith('tel:') || href.startsWith('javascript:') ||
            href.startsWith('http') && !href.startsWith(location.origin)) return;

        // JANGAN intercept anchor in-page
        if (href.startsWith('#')) return;

        // Tandai navigasi & animasi keluar
        sessionStorage.setItem('zy_nav', '1');
        document.body.classList.add('zy-nav-out');

        // Progress bar langsung tampil
        const bar = ensureProgress();
        bar.style.opacity = '1';
        setTimeout(() => { bar.style.width = '70%'; }, 30);
    }, false);

    // ---- 3. Saat halaman baru siap ----
    window.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('zy-progress');

        // Mark scroll smooth
        document.documentElement.classList.add('zy-smooth-scroll');

        // Jika ini navigasi (bukan fresh load):
        if (isNav && !prefersReduced) {
            document.body.classList.add('zy-nav-in');

            // Scroll ke atas dulu
            window.scrollTo(0, 0);

            // Fade out progress bar
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
        }
    });

    // ---- 4. Scroll Reveal (IntersectionObserver) ----
    // Wrapper elemen utama untuk stagger muncul saat scroll / load
    function initReveal() {
        if (prefersReduced) return;

        // Elemen yang akan di-reveal (hanya yang belum punya animasi sendiri)
        const targets = document.querySelectorAll(
            [
                'main > *',                    // anak langsung <main> (header card, section)
                '.grid > *',                    // anak grid (kartu kalkulator, menu cards)
                '.space-y-6 > *',               // anak space-y (panduan sections)
                '.space-y-4 > *',
                '.space-y-3 > *',
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
            // Elemen yang sudah punya animasi (anim-smooth, anim-welcome) jangan di-reveal lagi
            if (el.classList.contains('anim-smooth') ||
                el.classList.contains('anim-welcome') ||
                el.hasAttribute('data-page-transition')) return;

            const delay = Math.min(i * 60, 500);
            el.style.setProperty('--zy-delay', delay + 'ms');
            el.classList.add('zy-reveal');
            io.observe(el);
        });
    }

    // ---- 5. Tambahkan wrapper [data-page-transition] ke konten utama ----
    function markContent() {
        const main = document.querySelector('main') ||
                     document.querySelector('[role="main"]') ||
                     document.body;
        main.setAttribute('data-page-transition', '');
    }

    // Init saat DOM siap
    document.addEventListener('DOMContentLoaded', function () {
        markContent();
        initReveal();
    });

})();
