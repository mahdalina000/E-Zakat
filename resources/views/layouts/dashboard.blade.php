<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard — E-Zakat')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    // Pemetaan Palet Warna Baru
                    cream: '#EAEAEA',       // Background dasar / light gray
                    cream2: '#F4F4F4',      // Background secondary / off-white
                    cream3: '#D6D6D6',      // Border & divider
                    olive: '#4B8B3B',       // Hijau utama (Header, Button, Accent)
                    olive2: '#3D7330',      // Hijau gelap (Hover states)
                    olive3: '#A8D5BA',      // Hijau mint (Highlight / Badge)
                    oliveDark: '#001F3F',   // Navy gelap (Teks utama, Footer)
                    earth: '#F2C94C',       // Kuning emas (Aksen khusus, Quote, Icon)
                },
                fontFamily: {
                    poppins: ['Poppins', 'sans-serif'],
                    amiri: ['Amiri', 'serif'],
                }
            }
        }
    }
</script>
    <style>body{font-family:'Poppins',sans-serif}</style>
    <style>
    @keyframes slideUpSmooth {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .anim-dashboard { animation: slideUpSmooth 0.4s ease-out forwards; }
</style>
    @yield('head')
</head>
<body class="bg-cream2 text-oliveDark min-h-screen">
<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed lg:sticky top-0 z-50 w-[260px] h-screen bg-olive text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform">
        <div class="h-[64px] flex items-center gap-3 px-5 border-b border-white/10">
            <!-- Logo Baru E-Zakat -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white p-1 flex items-center justify-center ring-2 ring-white/80 shadow-md overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="E-Zakat Logo" 
                         class="w-full h-full object-contain">
                </div>
                <div class="leading-tight">
                    <div class="font-extrabold text-sm tracking-wide">E-ZAKAT</div>
                    <div class="text-[10px] tracking-[0.18em] text-cream/70 -mt-0.5">DASHBOARD</div>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-xmark text-sm"></i></button>
        </div>

        @php $u = auth()->user(); @endphp
        <div class="px-4 py-4 border-b border-white/10">
            <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-3">
                <span class="w-10 h-10 rounded-full bg-cream text-olive flex items-center justify-center font-bold">{{ strtoupper(substr($u->name,0,1)) }}</span>
                <div class="min-w-0">
                    <div class="text-sm font-semibold truncate">{{ $u->name }}</div>
                    <div class="text-[10px] text-cream/70 truncate">{{ $u->roleLabel() }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mb-2">MENU</div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('dashboard*') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-gauge-high w-4"></i> Dashboard</a>

            @if($u->isSuperAdmin())
                <a href="{{ route('super.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.users') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-users w-4"></i> Manajemen User</a>
                <a href="{{ route('super.locations') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.locations') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-map-location-dot w-4"></i> Semua Lokasi</a>
                <a href="{{ route('super.activity') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('super.activity') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-clock-rotate-left w-4"></i> Aktivitas Login</a>
            @endif

            @if($u->isAdmin())
                <a href="{{ route('admin.locations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.locations.*') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-map-location-dot w-4"></i> Lokasi Saya</a>
                <a href="{{ route('admin.beras.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.beras.*') ? 'bg-white text-olive font-semibold' : 'text-cream hover:bg-white/10' }}"><i class="fa-solid fa-wheat-awn w-4"></i> Harga Beras Banjar</a>
            @endif

            @if($u->isUser())
                <a href="{{ url('/kalkulator') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-calculator w-4"></i> Kalkulator Zakat</a>
                <a href="{{ url('/direktori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-map-location-dot w-4"></i> Lokasi Penyaluran</a>
                <a href="{{ url('/panduan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-book-open w-4"></i> Panduan Zakat</a>
            @endif

            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">PUBLIK</div>
            <a href="{{ url('/beranda') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-house w-4"></i> Beranda Situs</a>
        </nav>

        <div class="p-3 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-200 hover:bg-red-500/20 transition"><i class="fa-solid fa-right-from-bracket w-4"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

    {{-- Main --}}
    <div class="flex-1 min-w-0">
        <header class="sticky top-0 z-30 bg-cream2/90 backdrop-blur border-b border-cream3">
            <div class="px-4 lg:px-8 h-[64px] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 bg-white border border-cream3 rounded-xl flex items-center justify-center"><i class="fa-solid fa-bars"></i></button>
                    <div>
                        <div class="font-bold text-oliveDark text-sm lg:text-base">@yield('page-title','Dashboard')</div>
                        <div class="text-xs text-olive/50 hidden sm:block">@yield('page-sub','')</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="hidden sm:inline bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive"><i class="fa-regular fa-calendar mr-1"></i> {{ now()->translatedFormat('d M Y') }}</span>
                    <span class="bg-olive text-cream px-3 py-1.5 rounded-full">{{ $u->roleLabel() }}</span>
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
</script>
@yield('scripts')
</body>
</html>