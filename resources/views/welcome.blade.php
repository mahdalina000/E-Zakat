<!DOCTYPE html>
<html lang="id" data-turbo-progress-bar="false">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Zakat Banjarbaru — Selamat Datang</title>

    <!-- Polyfill awal untuk window.ezOnReady — antri callback sampai bundle JS siap -->
    <script>
        window.ezOnReady = window.ezOnReady || (function () {
            var queue = [];
            function ready(fn) { if (typeof fn === 'function') queue.push(fn); }
            ready.flush = function () { while (queue.length) { requestAnimationFrame(queue.shift()); } };
            return ready;
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #EAEAEA;
        }
        
        img { max-width: 100%; height: auto; }

        /* KONSISTENSI PANEL PADA LIGHT MODE */
        .bg-panel-welcome {
            background-color: rgba(75, 139, 59, 0.12) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-color: rgba(75, 139, 59, 0.25) !important;
        }

        /* Styles khusus Dark Mode sesuai kustomisasi warna e-zakat banjarbaru */
        body.dark-mode {
            background-color: #121816 !important;
            color: #FFFFFF !important;
        }

        body.dark-mode .text-black,
        body.dark-mode .text-oliveDark {
            color: #f8fafc !important;
        }

        body.dark-mode .text-gold,
        body.dark-mode .text-gold2 {
            color: #D4AF37 !important;
        }

        body.dark-mode .text-oliveDark\/90,
        body.dark-mode .text-oliveDark\/80,
        body.dark-mode .text-oliveDark\/70,
        body.dark-mode .text-oliveDark\/60 {
            color: #cbd5e1 !important;
        }

        body.dark-mode .bg-white\/80,
        body.dark-mode .bg-white\/90,
        body.dark-mode .quick-action-bar,
        body.dark-mode .bg-panel-welcome {
            background-color: rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        body.dark-mode .quick-action-bar .border-cream3 {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        /* HILANGKAN SEMUA CAHAYA ORANYE/AMBER DI DARK MODE */
        body.dark-mode [class*="bg-amber"],
        body.dark-mode [class*="from-amber"] {
            display: none !important;
        }

        .quick-card-gold { border-left: 3px solid #D4AF37 !important; }
        .quick-card-blue { border-left: 3px solid #2563EB !important; }
        .quick-card-emerald { border-left: 3px solid #10B981 !important; }

        /* Animasi Ultra Smooth Reveal — mengalir, seamless (seperti video) */
        @keyframes zyraSmoothWelcome {
            0% {
                opacity: 0.72;
                transform: translateY(18px) scale(0.995);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes welcomeSlideForward {
            0% {
                opacity: 0.55;
                transform: translateX(46px) scale(0.99);
            }
            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes welcomeSlideBack {
            0% {
                opacity: 0.55;
                transform: translateX(-46px) scale(0.99);
            }
            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .anim-welcome { opacity: 1; }

        .turbolinks-progress-bar { display: none !important; }

        /* ===== HIASAN DEKORATIF — animasi masuk & hidup ===== */
        @keyframes zyLanternIn {
            0% { opacity: 0; transform: translateY(-70px) rotate(-4deg) scale(0.94); }
            55% { opacity: 1; transform: translateY(6px) rotate(2deg) scale(1.02); }
            100% { opacity: 1; transform: translateY(0) rotate(0deg) scale(1); }
        }
        @keyframes zyLanternSway {
            0% { transform: rotate(0deg) translateX(0px); }
            50% { transform: rotate(2.2deg) translateX(6px); }
            100% { transform: rotate(-1.8deg) translateX(-4px); }
        }
        @keyframes zyStarFadeIn { 0% { opacity: 0; } 100% { opacity: 0.6; } }
        @keyframes zyGlowPulse {
            0%, 100% { opacity: 0.55; transform: scale(1); }
            50% { opacity: 0.95; transform: scale(1.07); }
        }
        @keyframes zyCardFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .zy-star { animation: zyStarFadeIn 1.4s ease-out 0.15s both; }
        .zy-lantern-left {
            transform-origin: 50% 0%;
            animation: zyLanternIn 1s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both,
                       zyLanternSway 7s ease-in-out 1.4s infinite;
        }
        .zy-lantern-right {
            transform-origin: 50% 0%;
            animation: zyLanternIn 1s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both,
                       zyLanternSway 8s ease-in-out 1.8s infinite;
        }
        main.anim-welcome .eze-col-right { animation: zyCardFloat 6s ease-in-out 1.3s infinite; }

    </style>
</head>
<body class="min-h-screen w-full flex flex-col justify-between p-3 lg:p-5 box-border relative bg-zy-bg">



    <!-- LATAR ORNAMEN ISLAMI (mandala + lentera + pola bintang) — hiasan, di belakang konten -->
    <div class="absolute inset-0 w-full h-full pointer-events-none select-none z-0" aria-hidden="true">
        <!-- GRADIENT HANGAT -->
        <div class="absolute inset-0 zy-zy-grad"></div>
        <!-- POLA BINTANG ISLAMI -->
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
        <!-- LENTERA KIRI -->
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
        <!-- LENTERA KANAN -->
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

    <!-- FLOATING HEADER -->
    <header class="bg-olive text-white rounded-full max-w-7xl mx-auto w-full px-6 h-[56px] flex items-center justify-between shadow-md shrink-0 border border-white/10 relative z-10">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-full bg-cream p-1 flex items-center justify-center shadow-sm transition-transform group-hover:scale-105 shrink-0 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain" fetchpriority="high" decoding="async">
            </div>
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide text-white">E-ZAKAT</div>
                <div class="text-[9px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
            </div>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ url('/beranda') }}" class="bg-gold2 hover:bg-gold text-oliveDark text-xs font-extrabold px-5 py-2 rounded-full transition shadow-md flex items-center gap-1.5 active:scale-95">
                <span>Masuk Web</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
            <button id="themeToggle" type="button" title="Mode Gelap/Terang" class="w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition shadow-sm active:scale-95">
                <i id="themeIcon" class="fa-solid fa-moon text-xs"></i>
            </button>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto w-full my-auto space-y-4 flex-1 flex flex-col justify-center anim-welcome relative z-10 px-2">

        <!-- HERO SECTION 2 KOLOM -->
        <div class="grid lg:grid-cols-12 gap-8 items-center w-full my-auto">
            
            <!-- KOLOM KIRI: UCAPAN SELAMAT DATANG -->
            <div class="lg:col-span-7 space-y-4 eze-col-left">
                <div class="inline-flex items-center gap-2 bg-panel-welcome border border-gold/40 px-3.5 py-1 rounded-full text-xs font-bold text-oliveDark shadow-sm">
                    <i class="fa-solid fa-sparkles text-gold2"></i> PLATFORM ZAKAT DIGITAL TERPERCAYA
                </div>

                <h1 class="font-black text-oliveDark leading-[0.98] text-[36px] sm:text-[48px] lg:text-[58px] tracking-tight drop-shadow-sm">
                    Selamat Datang<br>
                    <span class="text-gold2">di E-Zakat</span>
                </h1>

                <p class="text-oliveDark/90 text-xs sm:text-sm lg:text-base max-w-lg leading-relaxed font-semibold drop-shadow-sm">
                    Tunaikan kewajiban, raih keberkahan. Platform digital untuk menghitung, menyalurkan, dan memahami zakat sesuai syariat — khusus warga Banjarbaru.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ url('/beranda') }}" class="bg-olive hover:bg-olive2 text-white font-bold px-7 py-3 rounded-full text-xs lg:text-sm shadow-md transition flex items-center gap-2 active:scale-95 border border-gold/30">
                        Mulai Sekarang <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <span class="text-xs text-oliveDark font-semibold bg-panel-welcome border border-gold/40 px-4 py-2.5 rounded-full shadow-sm">
                        <i class="fa-solid fa-shield-halved text-gold2 mr-1"></i> 100% Sesuai Syariat
                    </span>
                </div>
            </div>

            <!-- KOLOM KANAN: HADIS SLIDER (HIJAU OLIVE CARD) -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end eze-col-right">
                <div class="w-full bg-olive text-white p-6 rounded-3xl shadow-2xl relative border border-white/20 flex flex-col justify-between min-h-[260px] backdrop-blur-sm border-l-4 border-l-gold2">
                    
                    <!-- Badge Hadis -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-gold2 text-oliveDark text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            <i class="fa-solid fa-quote-left mr-1"></i> Hadis Zakat
                        </span>
                        <div class="flex items-center gap-2">
                            <button id="speakBtn" type="button" title="Putar bacaan hadis & artinya" class="bg-white/20 hover:bg-gold2 hover:text-oliveDark text-white transition w-7 h-7 rounded-full flex items-center justify-center text-xs active:scale-95">
                                <i class="fa-solid fa-volume-high"></i>
                            </button>
                            <span class="text-xs text-white/90 font-bold"><span id="idxLabel">1</span> / 20</span>
                        </div>
                    </div>

                    <!-- Content Hadis -->
                    <div id="hadithCard" class="my-auto py-2"></div>

                    <!-- Navigasi Slider -->
                    <div class="flex items-center justify-between pt-3 border-t border-white/20">
                        <div class="flex items-center gap-2">
                            <button id="prevBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-gold2 hover:text-oliveDark text-white transition flex items-center justify-center text-xs"><i class="fa-solid fa-chevron-left"></i></button>
                            <button id="nextBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-gold2 hover:text-oliveDark text-white transition flex items-center justify-center text-xs"><i class="fa-solid fa-chevron-right"></i></button>
                            <button id="pauseBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-gold2 hover:text-oliveDark text-white transition flex items-center justify-center text-xs ml-1"><i id="pauseIcon" class="fa-solid fa-pause"></i></button>
                        </div>
                        <div id="dots" class="flex gap-1"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- QUICK ACTION FLOATING BAR (BAGIAN BAWAH) -->
        <div class="quick-action-bar bg-panel-welcome rounded-2xl p-3 border border-panel-border shadow-lg grid md:grid-cols-3 gap-3 items-center shrink-0 eze-up">
            <div class="flex items-center gap-3 px-3 py-1 md:border-r border-panel-border quick-card-gold">
                <i class="fa-solid fa-calculator text-gold2 text-lg shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-oliveDark">Kalkulator Zakat</div>
                    <div class="text-[10px] text-oliveDark/70">Hitung Fitrah, Maal & Fidyah</div>
                </div>
            </div>
            <div class="flex items-center gap-3 px-3 py-1 md:border-r border-panel-border quick-card-blue">
                <i class="fa-solid fa-map-location-dot text-blue-600 text-lg shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-oliveDark">Lokasi Penyaluran</div>
                    <div class="text-[10px] text-oliveDark/70">Peta amil zakat Banjarbaru</div>
                </div>
            </div>
            <div class="flex items-center justify-between px-3 py-1 quick-card-emerald">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-book-quran text-emerald-600 text-lg shrink-0"></i>
                    <div>
                        <div class="text-xs font-bold text-oliveDark">Panduan Syariat</div>
                        <div class="text-[10px] text-oliveDark/70">Nisab, syarat & 8 asnaf</div>
                    </div>
                </div>
                <a href="{{ url('/panduan') }}" class="bg-emerald-500/20 hover:bg-emerald-600 hover:text-white text-emerald-700 w-7 h-7 rounded-full flex items-center justify-center transition shrink-0 active:scale-95">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="max-w-7xl mx-auto w-full text-center text-[11px] text-oliveDark/70 py-1 shrink-0 relative z-10 font-medium">
        © {{ date('Y') }} E-Zakat Banjarbaru — Amanah, Transparan, Berkah
    </footer>

    <!-- SCRIPT DARK MODE TOGGLE -->
    <script>
    window.ezOnReady(function(){
        const toggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        if(localStorage.getItem('theme') === 'dark'){
            document.body.classList.add('dark-mode');
            if(themeIcon) themeIcon.className = 'fa-solid fa-sun text-xs text-gold2';
        }
        toggleBtn?.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            if(themeIcon) themeIcon.className = isDark ? 'fa-solid fa-sun text-xs text-gold2' : 'fa-solid fa-moon text-xs';
        });
    });
    </script>

    <!-- SCRIPT HADIS SLIDER -->
    <script>
    const hadiths = [
        {arab:"بُنِيَ الْإِسْلَامُ عَلَى خَمْسٍ ... وَإِيتَاءِ الزَّكَاةِ", indo:"Islam dibangun di atas lima perkara: syahadat, shalat, zakat, puasa Ramadhan, dan haji.", sumber:"HR. Bukhari & Muslim"},
        {arab:"مَا نَقَصَتْ صَدَقَةٌ مِنْ مَالٍ", indo:"Sedekah tidak akan mengurangi harta.", sumber:"HR. Muslim No. 2588"},
        {arab:"حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ", indo:"Bentengilah hartamu dengan zakat.", sumber:"HR. Thabrani — Hasan"},
        {arab:"مَنْ أَدَّى زَكَاةَ مَالِهِ فَقَدْ ذَهَبَ عَنْهُ شَرُّهُ", indo:"Barangsiapa menunaikan zakat hartanya, maka hilanglah keburukan hartanya.", sumber:"HR. Thabrani"},
        {arab:"إِنَّ اللَّهَ فَرَضَ عَلَيْهِمْ صَدَقَةً تُؤْخَذُ مِنْ أَغْنِيَائِهِمْ", indo:"Sesungguhnya Allah mewajibkan sedekah (zakat) yang diambil dari orang kaya mereka.", sumber:"HR. Bukhari"},
        {arab:"وَفِي أَمْوَالِهِمْ حَقٌّ لِلسَّائِلِ وَالْمَحْرُومِ", indo:"Dan pada harta mereka ada hak untuk orang miskin yang meminta dan yang tidak meminta.", sumber:"QS. Adz-Dzariyat: 19"},
        {arab:"خُذْ مِنْ أَمْوَالِهِمْ صَدَقَةً تُطَهِّرُهُمْ", indo:"Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan mereka.", sumber:"QS. At-Taubah: 103"},
        {arab:"مَا مَنَعَ قَوْمٌ الزَّكَاةَ إِلَّا ابْتَلَاهُمُ اللَّهُ بِالسِّنِينَ", indo:"Tidaklah suatu kaum enggan membayar zakat melainkan Allah akan menimpakan paceklik.", sumber:"HR. Thabrani"},
        {arab:"تَهَادَوْا وَتَصَدَّقُوا", indo:"Saling memberi hadiahlah dan bersedekahlah.", sumber:"HR. Bukhari (Adabul Mufrad)"},
        {arab:"الصَّدَقَةُ تُطْفِئُ الْخَطِيئَةَ كَمَا يُطْفِئُ الْمَاءُ النَّارَ", indo:"Sedekah memadamkan kesalahan sebagaimana air memadamkan api.", sumber:"HR. Tirmidzi No. 614"},
        {arab:"دَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", indo:"Obatilah orang sakit di antara kalian dengan sedekah.", sumber:"HR. Baihaqi — Hasan"},
        {arab:"إِنَّ الصَّدَقَةَ لَتُطْفِئُ غَضَبَ الرَّبِّ", indo:"Sesungguhnya sedekah benar-benar memadamkan kemurkaan Allah.", sumber:"HR. Tirmidzi"},
        {arab:"مَا مِنْ يَوْمٍ يُصْبِحُ الْعِبَادُ فِيهِ إِلَّا مَلَكَانِ يَنْزِلَانِ", indo:"Tidak ada hari kecuali dua malaikat turun dan mendoakan orang yang berinfak.", sumber:"HR. Bukhari & Muslim"},
        {arab:"أَنْفِقْ يَا ابْنَ آدَمَ أُنْفِقْ عَلَيْكَ", indo:"Berinfaklah wahai anak Adam, niscaya Aku akan berinfak kepadamu.", sumber:"HR. Bukhari & Muslim"},
        {arab:"الْيَدُ الْعُلْيَا خَيْرٌ مِنَ الْيَدِ السُّفْلَى", indo:"Tangan di atas lebih baik daripada tangan di bawah.", sumber:"HR. Bukhari & Muslim"},
        {arab:"اتَّقُوا النَّارَ وَلَوْ بِشِقِّ تَمْرَةٍ", indo:"Jagalah diri kalian dari api neraka walau dengan separuh kurma.", sumber:"HR. Bukhari & Muslim"},
        {arab:"كُلُّ امْرِئٍ فِي ظِلِّ صَدَقَتِهِ حَتَّى يُفْصَلَ بَيْنَ النَّاسِ", indo:"Setiap orang berada di bawah naungan sedekahnya hingga diputuskan perkara manusia.", sumber:"HR. Ahmad"},
        {arab:"إِذَا مَاتَ ابْنُ آدَمَ انْقَطَعَ عَمَلُهُ إِلَّا مِنْ ثَلَاثٍ ... صَدَقَةٍ جَارِيَةٍ", indo:"Jika anak Adam meninggal, terputus amalnya kecuali tiga: sedekah jariyah...", sumber:"HR. Muslim"},
        {arab:"حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ وَدَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", indo:"Jagalah hartamu dengan zakat dan obati sakitmu dengan sedekah.", sumber:"HR. Abu Dawud"},
        {arab:"لَنْ تَنَالُوا الْبِرَّ حَتَّى تُنْفِقُوا مِمَّا تُحِبُّونَ", indo:"Kamu tidak akan memperoleh kebajikan hingga kamu menginfakkan sebagian harta yang kamu cintai.", sumber:"QS. Ali Imran: 92"},
    ];
    let idx=0,timer=null,paused=false;
    const card=document.getElementById('hadithCard'), idxLabel=document.getElementById('idxLabel'), dots=document.getElementById('dots');
    function render(){
        if(!card) return;
        const h=hadiths[idx];
        card.innerHTML=`<div class="zy-hadith text-left space-y-1"><div class="font-amiri text-gold2 text-base lg:text-lg font-bold leading-snug">${h.arab}</div><p class="text-white/95 text-xs leading-relaxed font-normal">"${h.indo}"</p><div class="text-[10px] text-gold2 font-semibold pt-1"><i class="fa-solid fa-book-open mr-1 text-gold2"></i> ${h.sumber}</div></div>`;
        card.querySelectorAll('.zy-hadith > *').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            el.style.transition = `opacity .5s ease ${i * 120}ms, transform .5s cubic-bezier(.16,1,.3,1) ${i * 120}ms`;
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
            });
        });
        idxLabel.textContent=idx+1;
        [...dots.children].forEach((d,i)=> d.className=i===idx?'w-4 h-1 rounded-full bg-gold2 transition-all':'w-1 h-1 rounded-full bg-white/30 transition-all');
    }
    function next(){idx=(idx+1)%hadiths.length;render();}
    function prev(){idx=(idx-1+hadiths.length)%hadiths.length;render();}
    function startTimer(){clearInterval(timer);timer=setInterval(()=>{if(!paused)next();},4200);}
    hadiths.forEach((_,i)=>{const b=document.createElement('button');b.addEventListener('click',()=>{idx=i;render();startTimer();});dots.appendChild(b);});
    document.getElementById('nextBtn')?.addEventListener('click',()=>{next();startTimer();});
    document.getElementById('prevBtn')?.addEventListener('click',()=>{prev();startTimer();});
    document.getElementById('pauseBtn')?.addEventListener('click',()=>{paused=!paused;document.getElementById('pauseIcon').className=paused?'fa-solid fa-play text-[10px]':'fa-solid fa-pause text-[10px]';});
    render();startTimer();
    document.addEventListener('keydown',e=>{if(e.key==='ArrowRight'){next();startTimer();} if(e.key==='ArrowLeft'){prev();startTimer();}});
    </script>

    <!-- TOMBOL SUARA HADIS & TTS (robust: selalu keluar suara, dengan fallback voice default) -->
    <script>
    (function(){
        const speakBtn = document.getElementById('speakBtn');
        if(!speakBtn || !('speechSynthesis' in window)) return;

        let speaking = false;
        const synth = window.speechSynthesis;

        // ---- Muat daftar voice di awal (Chrome/Edge sering kosong saat script jalan) ----
        let voices = [];
        const loadVoices = () => { voices = synth.getVoices() || []; };
        loadVoices();
        synth.onvoiceschanged = loadVoices;

        // Cari voice Arab & Indonesia, dengan fallback ke voice default
        function pickVoices(){
            const v = voices.length ? voices : synth.getVoices();
            const idVoice = v.find(x => /id[-_]?id/i.test(x.lang))
                         || v.find(x => /indonesia/i.test(x.name));
            const arVoice = v.find(x => /ar[-_]?sa/i.test(x.lang))
                         || v.find(x => /ar[-_]?eg/i.test(x.lang))
                         || v.find(x => /arabic/i.test(x.name));
            return {id: idVoice || null, ar: arVoice || null, any: v[0] || null};
        }

        function resetIcon(){
            const i = speakBtn.querySelector('i');
            if(i) i.className = 'fa-solid fa-volume-high';
            speakBtn.classList.remove('bg-gold2','text-oliveDark');
        }
        function showStop(){
            const i = speakBtn.querySelector('i');
            if(i) i.className = 'fa-solid fa-stop';
            speakBtn.classList.add('bg-gold2','text-oliveDark');
        }

        function speakHadith(){
            synth.cancel();
            const h = hadiths[idx];
            const {id, ar, any} = pickVoices();

            // Pilih voice terbaik untuk arti (prioritas: id-ID, lalu fallback ke default)
            const chosenVoice = id || any; // pakai suara default bila tak ada id-ID

            const uId = new SpeechSynthesisUtterance('Artinya: ' + h.indo + '. ' + h.sumber + '.');
            uId.lang = 'id-ID';
            if(chosenVoice) uId.voice = chosenVoice;
            uId.rate = 0.95;
            uId.pitch = 1.0;
            uId.volume = 1.0;

            uId.onend = () => { speaking = false; resetIcon(); };
            uId.onerror = (e) => {
                // Jika masih error, coba lagi dengan voice default
                speaking = false;
                resetIcon();
            };

            synth.speak(uId);
            speaking = true;
            showStop();
        }

        // Klik tombol: putar / hentikan
        speakBtn.addEventListener('click', () => {
            if(speaking){
                synth.cancel();
                speaking = false;
                resetIcon();
            } else {
                speakHadith();
            }
        });

        // Berhenti saat pindah hadis (next/prev/dots/keyboard)
        const stopAll = () => {
            if(speaking){ synth.cancel(); speaking = false; resetIcon(); }
        };
        document.getElementById('nextBtn')?.addEventListener('click', stopAll);
        document.getElementById('prevBtn')?.addEventListener('click', stopAll);
        document.getElementById('dots')?.addEventListener('click', stopAll);
        document.addEventListener('keydown', e => {
            if(e.key === 'ArrowRight' || e.key === 'ArrowLeft') stopAll();
        });
        window.addEventListener('pagehide', () => synth.cancel());
    })();

    </script>
</body>
</html>