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
            z-index: 10; /* Di belakang tombol/badge User */
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
<body class="min-h-screen text-oliveDark relative overflow-x-hidden bg-zy-bg">

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

<!-- LAMPION DENGAN POSISI LEBIH TURUN & RANTAI GANTUNG KELIHATAN PENUH -->
<div class="header-lantern-behind hidden sm:block">
    <svg width="48" height="135" viewBox="0 0 60 160" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Rantai Panjang Dari Atas -->
        <line x1="30" y1="0" x2="30" y2="45" stroke="#d97706" stroke-width="2.2" stroke-dasharray="4 2"/>
        <circle cx="30" cy="48" r="4" stroke="#fbbf24" stroke-width="2" fill="none"/>
        
        <!-- Bintang Kilau Atas Ring -->
        <path d="M30 38 L32 41 L35 41 L33 43 L34 46 L30 44 L26 46 L27 43 L25 41 L28 41 Z" fill="#fef08a"/>

        <!-- Kubah Atas Lampion -->
        <path d="M30 52 C22 60, 16 68, 14 72 H46 C44 68, 38 60, 30 52 Z" fill="url(#goldDomeGrad5)" stroke="#f59e0b" stroke-width="1"/>
        <rect x="25" y="51" width="10" height="2" rx="1" fill="#fbbf24"/>

        <!-- Badan Utama Lampion -->
        <rect x="13" y="72" width="34" height="34" rx="2" fill="url(#bodyGoldGrad5)" stroke="#d97706" stroke-width="1.5"/>
        
        <!-- Inti Cahaya Lilin Bersinar -->
        <circle cx="30" cy="89" r="12" fill="url(#candleLightGrad5)" class="candle-flicker"/>
        
        <!-- Tingkap Lengkung Islam -->
        <path d="M16 75 C16 73, 22 73, 22 75 V102 H16 Z" fill="url(#windowGlass5)" stroke="#b45309" stroke-width="1"/>
        <path d="M25 74 C25 70, 35 70, 35 74 V102 H25 Z" fill="url(#windowGlass5)" stroke="#b45309" stroke-width="1.2"/>
        <path d="M38 75 C38 73, 44 73, 44 75 V102 H38 Z" fill="url(#windowGlass5)" stroke="#b45309" stroke-width="1"/>

        <!-- Tapak Bawah Lampion -->
        <path d="M12 106 H48 L42 112 H18 Z" fill="url(#goldDomeGrad5)" stroke="#d97706" stroke-width="1"/>
        <path d="M18 112 C20 124, 40 124, 42 112 Z" fill="url(#goldDomeGrad5)" stroke="#d97706" stroke-width="1"/>
        
        <!-- Gantungan Rumbai Bawah -->
        <circle cx="30" cy="126" r="3" stroke="#fbbf24" stroke-width="1.5" fill="none"/>

        <defs>
            <linearGradient id="goldDomeGrad5" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#fef08a"/>
                <stop offset="40%" stop-color="#f59e0b"/>
                <stop offset="100%" stop-color="#78350f"/>
            </linearGradient>
            <linearGradient id="bodyGoldGrad5" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#fbbf24"/>
                <stop offset="50%" stop-color="#d97706"/>
                <stop offset="100%" stop-color="#92400e"/>
            </linearGradient>
            <radialGradient id="candleLightGrad5" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#ffffff"/>
                <stop offset="40%" stop-color="#fef08a"/>
                <stop offset="80%" stop-color="#f59e0b" stop-opacity="0.95"/>
                <stop offset="100%" stop-color="#d97706" stop-opacity="0"/>
            </radialGradient>
            <linearGradient id="windowGlass5" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95"/>
                <stop offset="60%" stop-color="#fef08a" stop-opacity="0.75"/>
                <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.85"/>
            </linearGradient>
        </defs>
    </svg>
</div>

<div class="flex min-h-screen relative z-10">
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
            @endif

            @if($u->isAdmin())
                <a href="{{ route('admin.baznas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.baznas') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-users w-4"></i> Kelola Warga Zakat</a>
                <a href="{{ route('admin.locations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.locations.*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-map-location-dot w-4"></i> Lokasi Saya</a>
                <a href="{{ route('admin.beras.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.beras.*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-wheat-awn w-4"></i> Harga Beras Banjar</a>
                <a href="{{ route('admin.export') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.export') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-file-excel w-4"></i> Export Catatan</a>
            @endif

            @if($u->isUser())
                <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">WARGA</div>
                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.profile*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-id-card w-4"></i> Profil & Data Diri</a>
                <a href="{{ route('user.calculators') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.calculators*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-calculator w-4"></i> Kalkulator Zakat & Waris</a>
                <a href="{{ route('user.histories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('user.histories*') ? 'bg-white text-olive font-semibold shadow' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-clock-rotate-left w-4"></i> Riwayat Perhitungan</a>

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
    <div class="flex-1 min-w-0">
        <!-- HEADER ATAS KANAN -->
        <header class="sticky top-0 z-30 bg-olive/95 backdrop-blur border-b border-gold/30 shadow-sm">
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

        <div class="p-4 lg:p-8 anim-dashboard">
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