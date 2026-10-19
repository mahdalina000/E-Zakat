<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Zakat Banjarbaru')</title>

    <!-- OPTIMASI PRECONNECT CDN AGAR LOADING INSTAN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')

    <!-- REGISTER SERVICE WORKER (hanya jika produksi) -->
    @if(!env('APP_DEBUG'))
    <script>
        if('serviceWorker' in navigator && location.protocol !== 'file:'){
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('[SW] Registered:', reg.scope))
                    .catch(err => console.warn('[SW] Registration failed:', err));
            });
        }
    </script>
    @endif
</head>
<body class="min-h-screen flex flex-col justify-between relative overflow-x-hidden bg-cream2">

    <!-- ELEMEN BACKGROUND AESTHETIC GLOBAL (E-ZAKAT BLUR + AMBIENT LIGHTING GLOW) -->
    <div class="fixed inset-0 w-full h-full pointer-events-none z-0 overflow-hidden">
        <!-- Asset Gambar E-Zakat dengan Opacity Halus & Blur -->
       <img src="{{ asset('images/e-zakat.jpg') }}" alt="Background Aesthetic" class="w-full h-full object-cover opacity-15 blur-[12px] scale-105" loading="lazy">
        
        <!-- Ambient Glowing Orbs -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-olive/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -right-32 w-[500px] h-[500px] bg-earth/15 rounded-full blur-3xl"></div>
        
        <!-- Subtle Pattern Mesh Grid -->
        <div class="absolute inset-0 bg-[radial-gradient(#4B8B3B_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>
    </div>

    <!-- FLOATING TOP HEADER -->
    <header class="max-w-7xl mx-auto w-full px-4 pt-4 shrink-0 relative z-20 anim-smooth delay-1">
        <div class="bg-olive text-white rounded-full px-6 h-[56px] flex items-center justify-between shadow-lg border border-white/10 hover-smooth">
            <!-- LOGO BRANDING -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-full bg-white p-1 flex items-center justify-center shadow-sm transition-transform group-hover:scale-105 shrink-0 overflow-hidden">
                    <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain">
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

    <!-- INSTANT PREFETCH & DARK MODE TOGGLE SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // ============================
            // PREFETCH LOGIC (OPTIMASI)
            // ============================
            const prefetched = new Set();
            function prefetch(href) {
                if (!href || !href.startsWith('/') || prefetched.has(href)) return;
                prefetched.add(href);
                const l = document.createElement('link');
                l.rel = 'prefetch';
                l.href = href;
                document.head.appendChild(l);
            }

            // 1. Prefetch semua link saat hover (desktop)
            document.querySelectorAll('a[href]').forEach(link => {
                link.addEventListener('mouseenter', () => prefetch(link.getAttribute('href')));
                // 2. Prefetch saat touch start (mobile)
                link.addEventListener('touchstart', () => prefetch(link.getAttribute('href')), {passive: true});
            });

            // 3. Prefetch asset kritis (CSS utama) saat idle
            requestIdleCallback(() => {
                const mainCss = document.querySelector('link[rel="stylesheet"][href*="app-"]');
                if (mainCss) prefetch(mainCss.getAttribute('href'));
            }, {timeout: 2000});
        });
    </script>
</body>
</html>