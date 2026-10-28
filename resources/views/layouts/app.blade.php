<!DOCTYPE html>
<html lang="id" data-turbo-progress-bar="false">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'E-Zakat Banjarbaru')</title>

    <!-- Polyfill awal untuk window.ezOnReady — antri callback sampai bundle JS siap -->
    <script>
        window.ezOnReady = window.ezOnReady || (function () {
            var queue = [];
            function ready(fn) { if (typeof fn === 'function') queue.push(fn); }
            ready.flush = function () { while (queue.length) { requestAnimationFrame(queue.shift()); } };
            return ready;
        })();
    </script>

    <!-- OPTIMASI PRECONNECT CDN AGAR LOADING INSTAN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap">
    <link rel="preload" as="image" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')

    <!-- REGISTER SERVICE WORKER (hanya jika produksi) -->
    <script>
        if('serviceWorker' in navigator && location.protocol !== 'file:'){
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('[SW] Registered:', reg.scope))
                    .catch(err => console.warn('[SW] Registration failed:', err));
            });
        }
    </script>
</head>
<body class="min-h-screen flex flex-col justify-between relative overflow-x-hidden bg-zy-bg">

    <!-- LATAR ORNAMEN ISLAMI (mandala + lentera + pola bintang) — hiasan, tidak menghalangi konten -->
    <div class="absolute inset-0 w-full h-full pointer-events-none select-none z-0" aria-hidden="true">
        <!-- GRADIENT HANGAT (hijau lembut, bukan cream) -->
        <div class="absolute inset-0 zy-zy-grad"></div>
        <!-- POLA BINTANG ISLAMI (GIRIH) -->
        <svg class="absolute inset-0 w-full h-full zy-star" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="zy-star-pat" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M 40,0 L 48,16 L 64,8 L 56,24 L 72,32 L 56,40 L 72,48 L 56,56 L 64,72 L 48,64 L 40,80 L 32,64 L 16,72 L 24,56 L 8,48 L 24,40 L 8,32 L 24,24 L 16,8 L 32,16 Z" fill="none" stroke="currentColor" stroke-width="1.1"/>
                    <path d="M 0,0 L 12,6 L 6,12 Z M 80,0 L 68,6 L 74,12 Z M 0,80 L 12,74 L 6,68 Z M 80,80 L 68,74 L 74,68 Z" fill="none" stroke="currentColor" stroke-width="0.8"/>
                    <circle cx="40" cy="40" r="7" fill="none" stroke="currentColor" stroke-width="0.7"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#zy-star-pat)" />
        </svg>
        <!-- LENTERA KIRI (1 lampion, berayun) -->
        <div class="absolute top-0 left-6 sm:left-12 md:left-20 lg:left-28 xl:left-36 zy-lantern zy-lantern-left">
            <svg width="135" height="430" viewBox="0 0 135 430" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-md">
                <defs>
                    <radialGradient id="zy-glow-l" cx="50%" cy="48%" r="48%">
                        <stop offset="0%" stop-color="#fffcf0" stop-opacity="0.95"/>
                        <stop offset="42%" stop-color="#f5c74e" stop-opacity="0.75"/>
                        <stop offset="85%" stop-color="#bf801a" stop-opacity="0.2"/>
                        <stop offset="100%" stop-color="#8a5606" stop-opacity="0"/>
                    </radialGradient>
                    <linearGradient id="zy-brass" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#8c661c"/>
                        <stop offset="25%" stop-color="#d4a742"/>
                        <stop offset="50%" stop-color="#fadb82"/>
                        <stop offset="75%" stop-color="#c99732"/>
                        <stop offset="100%" stop-color="#7a5512"/>
                    </linearGradient>
                </defs>
                <line x1="67" y1="0" x2="67" y2="110" class="zy-lantern-line" stroke-width="1.6" stroke-dasharray="3.5 3.5"/>
                <g transform="translate(67, 52)">
                    <polygon points="0,-13 3.8,-3.8 13,-3.8 5.5,2.5 8.5,12 0,6.5 -8.5,12 -5.5,2.5 -13,-3.8 -3.8,-3.8" fill="url(#zy-brass)"/>
                    <circle cx="0" cy="0" r="2.5" fill="#fff8e7"/>
                </g>
                <circle cx="67" cy="110" r="7.5" stroke="url(#zy-brass)" stroke-width="2.2" fill="none"/>
                <circle cx="67" cy="118" r="3" fill="#69460a"/>
                <path d="M 44 133 C 44 119, 90 119, 90 133 L 86 145 L 48 145 Z" fill="url(#zy-brass)"/>
                <path d="M 66 117 C 69 115, 69 111, 65 109 C 70 109, 72 114, 68 118 Z" fill="#ffe494"/>
                <ellipse cx="67" cy="205" rx="30" ry="48" fill="url(#zy-glow-l)"/>
                <path d="M 48 145 L 28 193 L 38 257 L 67 279 L 96 257 L 106 193 L 86 145 Z" fill="none" stroke="url(#zy-brass)" stroke-width="2.5"/>
                <line x1="67" y1="145" x2="67" y2="279" stroke="url(#zy-brass)" stroke-width="2.2"/>
                <path d="M 35 180 Q 67 195 99 180 M 32 220 Q 67 239 102 220 M 36 245 Q 67 259 98 245" stroke="#fadb82" stroke-width="1.2" fill="none" opacity="0.9"/>
                <g transform="translate(67, 205)">
                    <polygon points="0,-8 2,-2 8,-2 3,1 5,7 0,4 -5,7 -3,1 -8,-2 -2,-2" fill="#ffffff" opacity="0.85"/>
                </g>
                <path d="M 38 257 L 48 285 L 86 285 L 96 257 Z" fill="url(#zy-brass)"/>
                <path d="M 67 285 L 67 310 M 67 310 C 63 320, 71 320, 67 330 C 63 320, 71 320, 67 310" stroke="url(#zy-brass)" stroke-width="2" fill="#f5ce62"/>
            </svg>
        </div>
        <!-- LENTERA KANAN (2 lampion, berayun) -->
        <div class="hidden sm:block absolute top-0 right-0 sm:right-2 md:right-4 lg:right-6 xl:right-10 zy-lantern zy-lantern-right">
            <svg width="260" height="540" viewBox="0 0 260 540" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-md">
                <defs>
                    <radialGradient id="zy-glow-r" cx="50%" cy="48%" r="48%">
                        <stop offset="0%" stop-color="#fffcf0" stop-opacity="0.98"/>
                        <stop offset="42%" stop-color="#f5c74e" stop-opacity="0.8"/>
                        <stop offset="88%" stop-color="#bf801a" stop-opacity="0.2"/>
                        <stop offset="100%" stop-color="#8a5606" stop-opacity="0"/>
                    </radialGradient>
                    <linearGradient id="zy-brass2" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#8c661c"/>
                        <stop offset="25%" stop-color="#d4a742"/>
                        <stop offset="50%" stop-color="#fadb82"/>
                        <stop offset="75%" stop-color="#c99732"/>
                        <stop offset="100%" stop-color="#7a5512"/>
                    </linearGradient>
                </defs>
                <!-- LANTERN 1 (atas) -->
                <line x1="65" y1="0" x2="65" y2="95" class="zy-lantern-line" stroke-width="1.6" stroke-dasharray="3.5 3.5"/>
                <g transform="translate(65, 45)">
                    <polygon points="0,-13 3.8,-3.8 13,-3.8 5.5,2.5 8.5,12 0,6.5 -8.5,12 -5.5,2.5 -13,-3.8 -3.8,-3.8" fill="url(#zy-brass2)"/>
                    <circle cx="0" cy="0" r="2.5" fill="#fff8e7"/>
                </g>
                <circle cx="65" cy="95" r="7" stroke="url(#zy-brass2)" stroke-width="2.2" fill="none"/>
                <path d="M 42 118 C 42 104, 88 104, 88 118 L 84 130 L 46 130 Z" fill="url(#zy-brass2)"/>
                <ellipse cx="65" cy="190" rx="30" ry="48" fill="url(#zy-glow-r)"/>
                <path d="M 46 130 L 26 178 L 36 242 L 65 264 L 94 242 L 104 178 L 84 130 Z" fill="none" stroke="url(#zy-brass2)" stroke-width="2.5"/>
                <line x1="65" y1="130" x2="65" y2="264" stroke="url(#zy-brass2)" stroke-width="2.2"/>
                <path d="M 33 165 Q 65 180 97 165 M 30 205 Q 65 224 100 205 M 34 230 Q 65 244 96 230" stroke="#fadb82" stroke-width="1.2" fill="none" opacity="0.9"/>
                <g transform="translate(65, 190)">
                    <polygon points="0,-8 2,-2 8,-2 3,1 5,7 0,4 -5,7 -3,1 -8,-2 -2,-2" fill="#ffffff" opacity="0.85"/>
                </g>
                <path d="M 36 242 L 46 270 L 84 270 L 94 242 Z" fill="url(#zy-brass2)"/>
                <!-- LANTERN 2 (bawah) -->
                <line x1="185" y1="0" x2="185" y2="230" class="zy-lantern-line" stroke-width="1.6" stroke-dasharray="3.5 3.5"/>
                <g transform="translate(185, 75)">
                    <polygon points="0,-14 4,-4 14,-4 6,3 9,13 0,7 -9,13 -6,3 -14,-4 -4,-4" fill="url(#zy-brass2)"/>
                    <circle cx="0" cy="0" r="3" fill="#fff8e7"/>
                </g>
                <g transform="translate(185, 160)">
                    <polygon points="0,-12 3.5,-3.5 12,-3.5 5,2.5 8,11 0,6 -8,11 -5,2.5 -12,-3.5 -3.5,-3.5" fill="url(#zy-brass2)"/>
                    <circle cx="0" cy="0" r="2.5" fill="#fff8e7"/>
                </g>
                <circle cx="185" cy="230" r="7.5" stroke="url(#zy-brass2)" stroke-width="2.2" fill="none"/>
                <path d="M 160 254 C 160 238, 210 238, 210 254 L 205 268 L 165 268 Z" fill="url(#zy-brass2)"/>
                <ellipse cx="185" cy="335" rx="34" ry="54" fill="url(#zy-glow-r)"/>
                <path d="M 165 268 L 142 320 L 153 392 L 185 416 L 217 392 L 228 320 L 205 268 Z" fill="none" stroke="url(#zy-brass2)" stroke-width="2.6"/>
                <line x1="185" y1="268" x2="185" y2="416" stroke="url(#zy-brass2)" stroke-width="2.2"/>
                <path d="M 150 305 Q 185 322 220 305 M 146 350 Q 185 370 224 350 M 151 380 Q 185 395 219 380" stroke="#fadb82" stroke-width="1.2" fill="none" opacity="0.9"/>
                <g transform="translate(185, 335)">
                    <polygon points="0,-9 2.5,-2.5 9,-2.5 4,1.5 6,8 0,4.5 -6,8 -4,1.5 -9,-2.5 -2.5,-2.5" fill="#ffffff" opacity="0.9"/>
                </g>
                <path d="M 153 392 L 164 424 L 206 424 L 217 392 Z" fill="url(#zy-brass2)"/>
                <path d="M 185 424 L 185 452 M 185 452 C 180 464, 190 464, 185 476 C 180 464, 190 464, 185 452" stroke="url(#zy-brass2)" stroke-width="2.2" fill="#f5ce62"/>
            </svg>
        </div>
    </div>

    <header class="max-w-7xl mx-auto w-full px-4 pt-4 shrink-0 relative z-20 anim-smooth delay-1">
        <div class="bg-olive text-white rounded-full px-6 h-[56px] flex items-center justify-between shadow-lg border border-white/10 hover-smooth">
            <!-- LOGO BRANDING -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-cream p-1 flex items-center justify-center shadow-sm transition-transform group-hover:scale-105 shrink-0 overflow-hidden">
                    <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain" fetchpriority="high" decoding="async">
                </div>
                <div class="leading-tight">
                    <div class="font-extrabold text-sm tracking-wide text-white">E-ZAKAT</div>
                    <div class="text-[9px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
                </div>
            </a>

            <!-- NAVIGATION LINKS (LOKASI PENYALURAN DIUPDATE) -->
            <nav class="hidden md:flex items-center gap-1 bg-white/10 p-1 rounded-full text-xs font-semibold">
                <a href="{{ url('/beranda') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('beranda') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Beranda</a>
                <a href="{{ url('/kalkulator') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('kalkulator') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Kalkulator</a>
                <a href="{{ url('/direktori') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('direktori') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Lokasi Penyaluran</a>
                <a href="{{ url('/panduan') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('panduan') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Panduan</a>
            </nav>

            <!-- AUTH BUTTONS & TOGGLE MODE -->
            <div class="flex items-center gap-2">
                <span class="hidden lg:inline-flex items-center gap-1 text-[11px] text-cream/80 bg-white/10 px-3 py-1 rounded-full"><i class="fa-solid fa-location-dot text-earth"></i> Banjarbaru, Kalsel</span>
                
                <!-- TOGGLE DARK/LIGHT MODE -->
                <button id="themeToggle" type="button" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition text-xs shadow-sm active:scale-95" title="Mode Gelap/Terang">
                    <i id="themeIcon" class="fa-solid fa-moon"></i>
                </button>

                <a href="{{ route('login') }}" class="bg-earth hover:bg-yellow-400 text-oliveDark text-xs font-bold px-4 py-1.5 rounded-full transition shadow flex items-center gap-1.5 active:scale-95">
                    <i class="fa-solid fa-right-to-bracket text-[10px]"></i> Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-center">
    
        @yield('content')
    </div>

    <!-- FULL-WIDTH SOLID GREEN FOOTER -->
    <footer class="w-full bg-olive text-white py-2.5 px-4 lg:px-8 mt-auto shrink-0 border-t border-white/10 shadow-inner relative z-20 anim-smooth delay-5">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs">
            <div class="flex items-center gap-2">
                <span class="font-extrabold tracking-wide text-white">E-ZAKAT</span>
                <span class="text-white/40">•</span>
                <span class="text-cream/90 text-[11px]"><i class="fa-solid fa-location-dot text-earth mr-1"></i> Banjarbaru, Kalsel</span>
            </div>
            <p class="text-cream/80 text-[11px]">© {{ date('Y') }} E-Zakat Banjarbaru — Amanah, Transparan, Berkah</p>
        </div>
    </footer>

    @yield('scripts')

    <!-- DARK MODE + PREFETCH (transition.js handle progress bar & smooth reveal) -->
    <script>
        window.ezOnReady(function () {
            // Dark Mode Logic
            const toggleBtn = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');

            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                if(themeIcon) themeIcon.className = 'fa-solid fa-sun text-earth';
            }

            toggleBtn?.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                const isDark = document.body.classList.contains('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                if(themeIcon) themeIcon.className = isDark ? 'fa-solid fa-sun text-earth' : 'fa-solid fa-moon';
            });

            // Prefetch saat hover (page + CSS idle)
            const prefetched = new Set();
            function prefetch(href) {
                if (!href || !href.startsWith('/') || prefetched.has(href)) return;
                prefetched.add(href);
                const l = document.createElement('link');
                l.rel = 'prefetch';
                l.href = href;
                document.head.appendChild(l);
            }
            document.querySelectorAll('a[href]').forEach(link => {
                link.addEventListener('mouseenter', () => prefetch(link.getAttribute('href')));
                link.addEventListener('touchstart', () => prefetch(link.getAttribute('href')), {passive: true});
            });
            requestIdleCallback(() => {
                const mainCss = document.querySelector('link[rel="stylesheet"][href*="app-"]');
                if (mainCss) prefetch(mainCss.getAttribute('href'));
            }, {timeout: 2000});
        });
    </script>
</body>
</html>