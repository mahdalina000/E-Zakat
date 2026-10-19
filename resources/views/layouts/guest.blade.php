<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','E-Zakat Banjarbaru')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body{font-family:'Poppins',sans-serif}

        /* Mencegah gambar logo/asset meluap besar */
        img { max-width: 100%; height: auto; }

        /* Animasi Zoom Smooth */
        @keyframes zoomInAuth {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .anim-auth { animation: zoomInAuth 0.4s ease-out forwards; }
    </style>
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
<body class="bg-cream min-h-screen flex flex-col">

<header class="bg-olive text-white shadow-sm anim-smooth delay-1">
    <div class="max-w-6xl mx-auto px-4 lg:px-6 h-[60px] flex items-center justify-between">
      {{-- Logo E-Zakat --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-cream p-1 flex items-center justify-center ring-2 ring-cream3 shadow-sm transition-transform group-hover:scale-105 overflow-hidden shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain" fetchpriority="high" decoding="async">
            </div>
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide text-white">E-ZAKAT</div>
                <div class="text-[10px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
            </div>
        </a>
        
        <a href="{{ url('/beranda') }}" class="text-xs bg-white/15 hover:bg-white/25 px-4 py-2 rounded-full text-white transition flex items-center gap-1.5 border border-white/10">
            <i class="fa-solid fa-house"></i> Beranda
        </a>
    </div>
</header>

<main class="flex-1 flex items-center justify-center p-4 py-10 anim-auth">
    @yield('content')
</main>

<footer class="bg-oliveDark text-cream/70 text-center text-xs py-3 border-t border-white/10 anim-smooth delay-3">
    © {{ date('Y') }} E-Zakat Banjarbaru
</footer>

@yield('scripts')
</body>
</html>