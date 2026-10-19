<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Zakat Banjarbaru')</title>

    <!-- OPTIMASI PRECONNECT CDN AGAR LOADING INSTAN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @yield('head')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#EAEAEA',
                        cream2: '#F4F4F4',
                        cream3: '#D6D6D6',
                        olive: '#4B8B3B',
                        olive2: '#3D7330',
                        olive3: '#A8D5BA',
                        oliveDark: '#001F3F',
                        earth: '#F2C94C',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        amiri: ['Amiri', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            overflow-x: hidden;
            background-color: #EAEAEA;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

       /* DUKUNGAN MODE GELAP (DARK MODE) HARMONIS */
        body.dark-mode {
            background-color: #0b132b !important;
            color: #ffffff !important;
        }

        /* 1. KARTU UTAMA DAN CONTAINER GELAP */
        body.dark-mode .bg-cream2,
        body.dark-mode .bg-white\/90,
        body.dark-mode .bg-white { 
            background-color: #1e293b !important; 
            color: #ffffff !important; 
        }

        /* 2. PAKSA HANYA TEKS GELAP/HITAM MENJADI PUTIH (TEKS HIJAU TETAP HIJAU) */
        body.dark-mode .text-oliveDark,
        body.dark-mode h1:not(.text-olive), 
        body.dark-mode h2:not(.text-olive), 
        body.dark-mode h3:not(.text-olive),
        body.dark-mode p:not(.text-olive),
        body.dark-mode div:not(.text-olive) {
            color: #f8fafc !important;
        }

        /* PERTAHANKAN WARNA HIJAU UNTUK KELAS HIJAU KHUSUS */
        body.dark-mode .text-olive { color: #4B8B3B !important; }
        body.dark-mode .text-olive2 { color: #3D7330 !important; }

        /* 3. SUB-KARTU & STATISTIK (2.5kg, 3 Kat, 8, Beras, Fidyah, dll) */
        body.dark-mode div[class*="bg-cream2"],
        body.dark-mode button[class*="bg-cream2"],
        body.dark-mode .bg-cream2\/80,
        body.dark-mode .bg-cream2\/60 {
            background-color: #334155 !important;
            color: #ffffff !important;
            border-color: #475569 !important;
        }

        /* 4. NAVIGASI AKTIF HASIL KONTRAST */
        body.dark-mode nav a.bg-white {
            background-color: #ffffff !important;
            color: #001F3F !important;
            font-weight: 800 !important;
        }

        /* 5. INPUT FORM & BORDER HALUS */
        body.dark-mode .border-cream3 {
            border-color: #334155 !important;
        }
        body.dark-mode input {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #475569 !important;
        }

        /* =========================================================
           ANIMASI SMOOTH CINEMATIC (0.75s EASE-OUT APPLE STYLE)
        ========================================================= */
        /* ANIMASI FAST & SMOOTH REVEAL (DURASI OPTIMAL 0.4s) */
        @keyframes cinematicReveal {
            0% {
                opacity: 0;
                transform: translateY(14px);
                filter: blur(2px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        .anim-smooth {
            animation: cinematicReveal 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        /* Delay Singkat Instan */
        .delay-1 { animation-delay: 0.03s; }
        .delay-2 { animation-delay: 0.06s; }
        .delay-3 { animation-delay: 0.09s; }
        .delay-4 { animation-delay: 0.12s; }
        .delay-5 { animation-delay: 0.15s; }

        /* Hover Float Soft Effect */
        .hover-smooth {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-smooth:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -8px rgba(0, 31, 63, 0.12);
        }
    </style>
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

            // Prefetch Logic
            const prefetched = new Set();
            document.querySelectorAll('a[href]').forEach(link => {
                link.addEventListener('mouseenter', () => {
                    const href = link.getAttribute('href');
                    if (href && href.startsWith('/') && !prefetched.has(href)) {
                        prefetched.add(href);
                        const prefetchLink = document.createElement('link');
                        prefetchLink.rel = 'prefetch';
                        prefetchLink.href = href;
                        document.head.appendChild(prefetchLink);
                    }
                });
            });
        });
    </script>
</body>
</html>