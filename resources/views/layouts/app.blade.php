<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Zakat Banjarbaru')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F5EAD8',
                        cream2: '#FFF8EC',
                        cream3: '#EDE0CC',
                        olive: '#5A6B33',
                        olive2: '#4A5A2B',
                        olive3: '#6B7F3D',
                        oliveDark: '#3D4A24',
                        earth: '#C5A880',
                    },
                    fontFamily: {
                        poppins: ['Poppins','sans-serif'],
                        amiri: ['Amiri','serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body{font-family:'Poppins',sans-serif}
        .scrollbar-hide::-webkit-scrollbar{display:none}
        .scrollbar-hide{ -ms-overflow-style:none; scrollbar-width:none}
    </style>
    @yield('head')
</head>
<body class="bg-cream2 text-oliveDark min-h-screen">
    {{-- Top Nav --}}
    <header class="sticky top-0 z-50 bg-olive text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-[64px]">
                <a href="{{ url('/beranda') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-cream rounded-xl flex items-center justify-center text-olive text-xl">
                        <i class="fa-solid fa-mosque"></i>
                    </div>
                    <div class="leading-tight">
                        <div class="font-extrabold tracking-wide text-[18px]">E-ZAKAT</div>
                        <div class="text-[10px] tracking-[0.18em] text-cream/80 -mt-1">BANJARBARU</div>
                    </div>
                </a>
                {{-- Desktop Nav --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ url('/beranda') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request()->is('beranda') ? 'bg-white text-olive' : 'text-cream hover:bg-white/10' }}">Beranda</a>
                    <a href="{{ url('/kalkulator') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request()->is('kalkulator') ? 'bg-white text-olive' : 'text-cream hover:bg-white/10' }}">Kalkulator</a>
                    <a href="{{ url('/direktori') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request()->is('direktori') ? 'bg-white text-olive' : 'text-cream hover:bg-white/10' }}">Direktori</a>
                    <a href="{{ url('/panduan') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request()->is('panduan') ? 'bg-white text-olive' : 'text-cream hover:bg-white/10' }}">Panduan</a>
                </nav>
                <div class="hidden lg:flex items-center gap-3">
                    <span class="text-xs bg-white/15 px-3 py-1.5 rounded-full"><i class="fa-solid fa-location-dot mr-1"></i> Banjarbaru, Kalsel</span>
                    <a href="{{ url('/') }}" class="w-9 h-9 bg-cream text-olive rounded-full flex items-center justify-center hover:bg-white transition"><i class="fa-solid fa-house"></i></a>
                </div>
                {{-- Mobile hamburger --}}
                <button id="mobileBtn" class="lg:hidden w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
        {{-- Mobile menu --}}
        <div id="mobileNav" class="hidden lg:hidden border-t border-white/10 bg-olive2">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ url('/beranda') }}" class="block px-4 py-2.5 rounded-xl {{ request()->is('beranda') ? 'bg-white text-olive' : 'text-cream' }}">Beranda</a>
                <a href="{{ url('/kalkulator') }}" class="block px-4 py-2.5 rounded-xl {{ request()->is('kalkulator') ? 'bg-white text-olive' : 'text-cream' }}">Kalkulator Zakat & Fidyah</a>
                <a href="{{ url('/direktori') }}" class="block px-4 py-2.5 rounded-xl {{ request()->is('direktori') ? 'bg-white text-olive' : 'text-cream' }}">Direktori Maps</a>
                <a href="{{ url('/panduan') }}" class="block px-4 py-2.5 rounded-xl {{ request()->is('panduan') ? 'bg-white text-olive' : 'text-cream' }}">Panduan Zakat</a>
                <a href="{{ url('/') }}" class="block px-4 py-2.5 rounded-xl text-cream/80"><i class="fa-solid fa-right-from-bracket mr-2"></i> Halaman Selamat Datang</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-olive text-cream mt-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-6 py-8">
            <div class="flex flex-col lg:flex-row justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-cream rounded-lg flex items-center justify-center text-olive"><i class="fa-solid fa-mosque"></i></div>
                        <span class="font-bold">E-ZAKAT BANJARBARU</span>
                    </div>
                    <p class="text-sm text-cream/70 mt-3 max-w-md">Platform digital zakat terpercaya untuk warga Banjarbaru. Memudahkan perhitungan, penyaluran, dan edukasi zakat sesuai syariat.</p>
                </div>
                <div class="text-sm text-cream/70">
                    <div class="font-semibold text-cream mb-2">Kontak</div>
                    <div><i class="fa-solid fa-location-dot mr-2"></i> Jl. A. Yani KM 33, Banjarbaru</div>
                    <div class="mt-1"><i class="fa-solid fa-phone mr-2"></i> (0511) 123-4567</div>
                    <div class="mt-1"><i class="fa-brands fa-whatsapp mr-2"></i> 0821-xxxx-xxxx</div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-6 pt-6 text-xs text-cream/60 text-center">© {{ date('Y') }} E-Zakat Banjarbaru — Amanah, Transparan, Berkah</div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileBtn')?.addEventListener('click', ()=>{
            document.getElementById('mobileNav').classList.toggle('hidden');
        });
    </script>
    @yield('scripts')
</body>
</html>
