<!DOCTYPE html>
<html lang="id" data-turbo-progress-bar="false">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard — E-Zakat')</title>
    <!-- Polyfill awal untuk window.ezOnReady -->
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body{font-family:'Poppins',sans-serif}
        @keyframes slideUpSmooth {
            from { opacity: 0.6; transform: translateY(26px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-dashboard { animation: slideUpSmooth 1s cubic-bezier(0.22, 0.61, 0.36, 1) both; }

      .sidebar-ornament-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center; /* Memastikan bagian atas (rantai lampion) menempel sempurna di paling atas */
    pointer-events: none;
    z-index: 0;
    opacity: 0.5;
}
        /* ============================================================ */
        /* LAMPION DITURUNKAN + RANTAI GANTUNG KELIHATAN PENUH          */
        /* ============================================================ */
        .header-lantern-behind {
            position: fixed;
            top: 38px; /* Diturunkan lagi supaya rantai dan badan lampion kelihatan penuh */
            right: 16px;
            z-index: 10; /* Menimpa konten, seperti perilaku semula */
            pointer-events: none;
            filter: drop-shadow(0 0 12px rgba(245, 158, 11, 0.65));
        }

        .candle-flicker {
            animation: candlePulse 1.8s ease-in-out infinite alternate;
            transform-origin: center;
        }
        @keyframes candlePulse {
            0% { opacity: 0.7; transform: scale(0.94); }
            100% { opacity: 1; transform: scale(1.08); }
        }
    </style>
    @yield('head')

    <!-- REGISTER SERVICE WORKER -->
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
<body class="text-oliveDark relative overflow-hidden bg-zy-bg" style="height:100vh">

<!-- LATAR ORNAMEN ISLAMI UTAMA -->
<div class="absolute inset-0 w-full h-full pointer-events-none select-none z-0" aria-hidden="true">
    <div class="absolute inset-0 zy-zy-grad"></div>
    <svg class="absolute inset-0 w-full h-full zy-star" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
        <defs>
            <pattern id="zy-star-pat-db" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                <path d="M 40,0 L 48,16 L 64,8 L 56,24 L 72,32 L 56,40 L 72,48 L 56,56 L 64,72 L 48,64 L 40,80 L 32,64 L 16,72 L 24,56 L 8,48 L 24,40 L 8,32 L 24,24 L 16,8 L 32,16 Z" fill="none" stroke="currentColor" stroke-width="1.1"/>
                <path d="M 0,0 L 12,6 L 6,12 Z M 80,0 L 68,6 L 74,12 Z M 0,80 L 12,74 L 6,68 Z M 80,80 L 68,74 L 74,68 Z" fill="none" stroke="currentColor" stroke-width="0.8"/>
                <circle cx="40" cy="40" r="7" fill="none" stroke="currentColor" stroke-width="0.7"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#zy-star-pat-db)" />
    </svg>
</div>

<!-- LAMPION KANAN ATAS (disamakan dengan lampion beranda) -->
<div class="header-lantern-behind hidden sm:block">
<svg width="150" height="312" viewBox="0 0 260 540" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-md">
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

<div class="flex relative z-10" style="height:100vh">
    {{-- Sidebar Kiri --}}
    <aside id="sidebar" class="fixed lg:sticky top-0 z-50 w-[260px] h-screen bg-olive text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform relative overflow-hidden">
        
        <!-- GAMBAR ORNAMEN EMAS DENGAN OPASITI JELAS -->
        <img src="{{ asset('images/sidebar-ornament.png') }}" alt="Sidebar Ornament" class="sidebar-ornament-img">

        <div class="h-[64px] flex items-center gap-3 px-5 border-b border-white/10 relative z-10">
            <!-- Logo Baru E-Zakat -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cream p-1 flex items-center justify-center ring-2 ring-cream3 shadow-md overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="E-Zakat Logo" 
                         class="w-full h-full object-contain" fetchpriority="high" decoding="async">
                </div>
                <div class="leading-tight">
                    <div class="font-extrabold text-sm tracking-wide">E-ZAKAT</div>
                    <div class="text-[10px] tracking-[0.18em] text-cream/70 -mt-0.5">DASHBOARD</div>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-xmark text-sm"></i></button>
        </div>

        @php $u = auth()->user(); @endphp
        <div class="px-4 py-4 border-b border-white/10 relative z-10">
            <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-3 backdrop-blur-md border border-white/10">
                <span class="w-10 h-10 rounded-full bg-cream text-olive flex items-center justify-center font-bold shadow-inner">{{ strtoupper(substr($u->name,0,1)) }}</span>
                <div class="min-w-0">
                    <div class="text-sm font-semibold truncate">{{ $u->name }}</div>
                    <div class="text-[10px] text-cream/70 truncate">{{ $u->roleLabel() }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 relative z-10">
            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mb-2">MENU</div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('dashboard*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-gauge-high w-4"></i> Dashboard</a>

            @if($u->isSuperAdmin())
                <a href="{{ route('super.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.users') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-users w-4"></i> Manajemen User</a>
                <a href="{{ route('super.locations') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.locations') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-map-location-dot w-4"></i> Semua Lokasi</a>
                <a href="{{ route('super.activity') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.activity') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-clock-rotate-left w-4"></i> Aktivitas Login</a>
                <a href="{{ route('super.feedback') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.feedback') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-comment-dots w-4"></i> Masukan Warga</a>
            @endif

            @if($u->isAdmin())
                <a href="{{ route('admin.baznas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.baznas') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-users w-4"></i> Kelola Warga Zakat</a>
                <a href="{{ route('admin.locations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.locations.*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-map-location-dot w-4"></i> Kelola Lokasi</a>
                <a href="{{ route('admin.beras.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.beras.*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-wheat-awn w-4"></i> Harga Beras Banjar</a>
                <button type="button" onclick="document.getElementById('exportModalGlobal').classList.remove('hidden')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm w-full text-left text-cream hover:bg-white/10"><i class="fa-solid fa-file-excel w-4"></i> Export Catatan</button>
                <a href="{{ route('admin.feedback') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.feedback') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-comment-dots w-4"></i> Masukan Warga</a>
                <a href="{{ route('admin.zakat-requests') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.zakat-requests*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-paper-plane w-4"></i> Pengajuan Hitung Waris</a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.settings*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-gear w-4"></i> Pengaturan</a>
                <a href="{{ route('admin.holidays.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.holidays.*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-star-and-crescent w-4"></i> Banner Hari Raya</a>
            @endif

            @if($u->isUser())
                <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">WARGA</div>
                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.profile*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-id-card w-4"></i> Profil & Data Diri</a>
                <a href="{{ route('user.calculators') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.calculators*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-calculator w-4"></i> Kalkulator Zakat & Waris</a>
                <a href="{{ route('user.zakat-request') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.zakat-request*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-paper-plane w-4"></i> Ajukan Hitung Waris</a>
                <a href="{{ route('user.histories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.histories*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-clock-rotate-left w-4"></i> Riwayat Perhitungan</a>
                <a href="{{ route('user.feedback') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.feedback*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-comment-dots w-4"></i> Kritik & Saran</a>

                <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">INFORMASI</div>
                <a href="{{ url('/direktori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-map-location-dot w-4"></i> Lokasi Penyaluran</a>
                <a href="{{ url('/panduan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-book-open w-4"></i> Panduan Zakat</a>
            @endif

            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">PUBLIK</div>
            <a href="{{ url('/beranda') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-house w-4"></i> Beranda Situs</a>
        </nav>

        <div class="p-3 border-t border-white/10 relative z-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-200 hover:bg-red-500/20 transition"><i class="fa-solid fa-right-from-bracket w-4"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

    {{-- Main Content --}}
    <div class="flex-1" style="height:100vh;display:flex;flex-direction:column;min-width:0">
        <!-- HEADER ATAS KANAN -->
        <header class="sticky top-0 z-30 bg-olive/95 backdrop-blur border-b border-gold/30 shadow-sm" style="flex-shrink:0">
            <div class="px-4 lg:px-8 h-[64px] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 bg-white border border-cream3 rounded-xl flex items-center justify-center"><i class="fa-solid fa-bars"></i></button>
                    <div>
                        <div class="font-bold text-white text-sm lg:text-base">@yield('page-title','Dashboard')</div>
                        <div class="text-xs text-cream/70 hidden sm:block">@yield('page-sub','')</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs pr-6">
                    <button id="themeToggleDash" type="button" class="w-9 h-9 rounded-full bg-white/15 border border-white/20 text-white hover:bg-white/25 transition flex items-center justify-center" title="Mode gelap / terang"><i id="themeIconDash" class="fa-solid fa-moon"></i></button>
                    <span class="hidden sm:inline bg-white/15 border border-white/20 px-3 py-1.5 rounded-full text-white"><i class="fa-regular fa-calendar mr-1"></i> {{ now()->translatedFormat('d M Y') }}</span>
                    <span class="bg-gold2 text-oliveDark px-3 py-1.5 rounded-full font-bold shadow-sm relative z-20">{{ $u->roleLabel() }}</span>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 anim-dashboard" style="flex:1 1 0%;min-height:0;overflow-y:auto">
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3 text-sm flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3 text-sm flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3 text-sm">
                    <div class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Periksa kembali input Anda:</div>
                    <ul class="list-disc list-inside text-xs space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

{{-- MODAL EXPORT GLOBAL (dibuka dari sidebar) --}}
@if(auth()->user() && auth()->user()->isAdmin())
<div id="exportModalGlobal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-5 w-full max-w-sm shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-oliveDark text-sm flex items-center gap-2"><i class="fa-solid fa-file-excel text-olive"></i> Export Catatan Zakat</h3>
            <button type="button" onclick="document.getElementById('exportModalGlobal').classList.add('hidden')" class="text-olive/50 hover:text-olive text-lg leading-none">&times;</button>
        </div>
        <div class="space-y-2">
            <a href="{{ route('admin.export', ['kategori' => 'semuanya']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-list mr-2 text-olive"></i> Semua Catatan</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
            <a href="{{ route('admin.export', ['kategori' => 'gharimin']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-hands-holding-circle mr-2 text-teal-600"></i> Penerima Gharimin</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
            <a href="{{ route('admin.export', ['kategori' => 'kurang_mampu']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-hand-holding-heart mr-2 text-emerald-600"></i> Penerima Kurang Mampu (Fakir & Miskin)</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
            <a href="{{ route('admin.export', ['kategori' => 'pemberi']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-hand-holding-dollar mr-2 text-olive"></i> Pemberi (Muzaki)</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
        </div>
        <button type="button" onclick="document.getElementById('exportModalGlobal').classList.add('hidden')" class="mt-4 w-full bg-cream border border-cream3 text-olive font-semibold px-4 py-2 rounded-full text-xs">Tutup</button>
    </div>
</div>
@endif

<script>
    function toggleSidebar(){
        const s=document.getElementById('sidebar'), o=document.getElementById('overlay');
        s.classList.toggle('-translate-x-full'); o.classList.toggle('hidden');
    }
    (function(){
        const btn = document.getElementById('themeToggleDash'), icon = document.getElementById('themeIconDash');
        function applyTheme(){
            const dark = localStorage.getItem('theme') === 'dark';
            document.body.classList.toggle('dark-mode', dark);
            if (icon) icon.className = dark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }
        applyTheme();
        btn?.addEventListener('click', function(){
            localStorage.setItem('theme', localStorage.getItem('theme') === 'dark' ? 'light' : 'dark');
            applyTheme();
        });
    })();
</script>
@yield('scripts')
</body>
</html>