<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Zakat Banjarbaru')</title>
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
        }

        /* PROTEKSI ASET GAMBAR */
        img {
            max-width: 100% !important;
            height: auto;
        }

        /* =========================================================
           ANIMASI SMOOTH CINEMATIC (0.75s EASE-OUT APPLE STYLE)
        ========================================================= */
        @keyframes cinematicReveal {
            0% {
                opacity: 0;
                transform: translateY(28px) scale(0.985);
                filter: blur(6px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        .anim-smooth {
            animation: cinematicReveal 0.75s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        /* Delay Halus Beruntun */
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.16s; }
        .delay-3 { animation-delay: 0.24s; }
        .delay-4 { animation-delay: 0.32s; }
        .delay-5 { animation-delay: 0.40s; }

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
        <img src="{{ asset('images/e-zakat.jpg') }}" alt="Background Aesthetic" class="w-full h-full object-cover opacity-15 blur-[12px] scale-105">
        
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

            <!-- NAVIGATION LINKS -->
            <nav class="hidden md:flex items-center gap-1 bg-white/10 p-1 rounded-full text-xs font-semibold">
                <a href="{{ url('/beranda') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('beranda') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Beranda</a>
                <a href="{{ url('/kalkulator') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('kalkulator') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Kalkulator</a>
                <a href="{{ url('/direktori') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('direktori') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Direktori</a>
                <a href="{{ url('/panduan') }}" class="px-4 py-1.5 rounded-full transition {{ Request::is('panduan') ? 'bg-white text-oliveDark font-bold shadow' : 'hover:bg-white/15 text-white' }}">Panduan</a>
            </nav>

            <!-- AUTH BUTTONS -->
            <div class="flex items-center gap-2">
                <span class="hidden lg:inline-flex items-center gap-1 text-[11px] text-cream/80 bg-white/10 px-3 py-1 rounded-full"><i class="fa-solid fa-location-dot text-earth"></i> Banjarbaru, Kalsel</span>
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

    <!-- PREFETCH SCRIPT DENGAN INSTANT RESPONSE -->
    <script>
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('mouseenter', () => {
                const href = link.getAttribute('href');
                if (href && href.startsWith('/')) {
                    const prefetchLink = document.createElement('link');
                    prefetchLink.rel = 'prefetch';
                    prefetchLink.href = href;
                    document.head.appendChild(prefetchLink);
                }
            });
        });
    </script>
</body>
</html>