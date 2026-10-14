<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','E-Zakat Banjarbaru')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config={theme:{extend:{colors:{cream:'#F5EAD8',cream2:'#FFF8EC',cream3:'#EDE0CC',olive:'#5A6B33',olive2:'#4A5A2B',olive3:'#6B7F3D',oliveDark:'#3D4A24',earth:'#C5A880'},fontFamily:{poppins:['Poppins','sans-serif'],amiri:['Amiri','serif']}}}}
    </script>
    <style>body{font-family:'Poppins',sans-serif}</style>
</head>
<body class="bg-cream min-h-screen flex flex-col">

<header class="bg-olive text-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 lg:px-6 h-[60px] flex items-center justify-between">
      {{-- Logo E-Zakat --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-white p-1 flex items-center justify-center ring-2 ring-white/80 shadow-sm transition-transform group-hover:scale-105 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="E-Zakat Logo" 
                     class="w-full h-full object-contain">
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

<main class="flex-1 flex items-center justify-center p-4 py-10">
    @yield('content')
</main>

<footer class="bg-oliveDark text-cream/70 text-center text-xs py-3 border-t border-white/10">
    © {{ date('Y') }} E-Zakat Banjarbaru
</footer>

@yield('scripts')
</body>
</html>