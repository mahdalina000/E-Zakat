@extends('layouts.guest')
@section('title','Autentikasi — E-Zakat Banjarbaru')

@section('head')
<style>
    /* UTAMA SLIDING CONTAINER NEUMORPHISM */
    .neu-container {
        box-shadow: 0 20px 50px -15px rgba(14, 42, 28, 0.25), 0 0 0 1px rgba(226, 179, 86, 0.3);
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 768px; /* max-w-3xl */
        min-height: 450px;
        border-radius: 28px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    /* DARK MODE RULES CONTAINER LOGIN */
    body.dark-mode .neu-container {
        background-color: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-color: rgba(245, 158, 11, 0.35) !important;
    }
    body.dark-mode .form-container {
        background-color: transparent !important;
    }
    body.dark-mode .text-oliveDark {
        color: #f8fafc !important;
    }
    body.dark-mode .text-olive\/70,
    body.dark-mode .text-olive\/50 {
        color: #cbd5e1 !important;
    }

    /* DIHILANGKAN PEKATNYA: INPUT MODE GELAP TRANSPARAN TOTAL & TANPA SHADOW GELAP */
    body.dark-mode .neu-input {
        background-color: transparent !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        box-shadow: none !important;
    }
    body.dark-mode .neu-input input {
        color: #ffffff !important;
        background: transparent !important;
    }
    body.dark-mode .neu-input input::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }
    body.dark-mode .demo {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    
    .neu-input {
        box-shadow: inset 2px 2px 5px rgba(0,0,0,0.06), inset -2px -2px 5px rgba(255,255,255,0.8);
        transition: all 0.25s ease;
    }
    .neu-input:focus-within {
        transform: translateY(-1px);
        border-color: rgba(212, 175, 55, 0.8) !important;
    }

    .neu-btn {
        box-shadow: 0 4px 12px rgba(29, 91, 55, 0.2);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .neu-btn:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 16px rgba(29, 91, 55, 0.3);
    }

    /* KONTROL SLIDING FORM LAYER */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
        opacity: 1;
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    /* POSISI SAAT SLIDE KE REGISTER */
    .neu-container.right-panel-active .sign-in-container {
        transform: translateX(100%);
        opacity: 0;
        z-index: 1;
    }

    .neu-container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% { opacity: 0; z-index: 1; }
        50%, 100% { opacity: 1; z-index: 5; }
    }

    /* OVERLAY PANEL HIJAU BERGESER */
    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s cubic-bezier(0.65, 0, 0.35, 1);
        z-index: 100;
    }

    .neu-container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: linear-gradient(135deg, #1d5b37 0%, #246c42 50%, #0e2a1c 100%);
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s cubic-bezier(0.65, 0, 0.35, 1);
    }

    /* PANEL HIJAU MODE GELAP (HANGAT & BERSIH) */
    body.dark-mode .overlay {
        background: linear-gradient(135deg, #144729 0%, #1e5e37 50%, #0c331c 100%) !important;
    }

    .neu-container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 30px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .neu-container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .neu-container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .overlay-stars {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            radial-gradient(circle at 15% 25%, rgba(226,179,86,0.6) 1.2px, transparent 1.8px),
            radial-gradient(circle at 75% 65%, rgba(255,255,255,0.5) 1px, transparent 1.6px),
            radial-gradient(circle at 45% 85%, rgba(226,179,86,0.5) 1.4px, transparent 2px);
        background-size: 110px 110px;
        opacity: 0.6;
    }

    /* ANIMASI BERAYUN PADA LAMPION */
    @keyframes swing {
        0%, 100% { transform: rotate(-2.5deg); }
        50% { transform: rotate(2.5deg); }
    }
    .panel-lantern {
        transform-origin: top center;
        animation: swing 4s ease-in-out infinite;
    }

    /* POSISI CAHAYA BULAT MEMUDAR PRESISI */
    .glow-lantern-spot {
        position: absolute;
        top: 52px;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 252, 235, 0.95) 0%, rgba(245, 199, 78, 0.7) 35%, rgba(245, 199, 78, 0) 70%);
        filter: blur(6px);
        pointer-events: none;
        z-index: 5;
    }
    .overlay-left .glow-lantern-spot { left: 19px; }
    .overlay-right .glow-lantern-spot { right: 19px; }

    .glow-moon-spot {
        position: absolute;
        top: 6px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(250, 220, 130, 0.9) 0%, rgba(245, 197, 78, 0.5) 45%, rgba(245, 197, 78, 0) 75%);
        filter: blur(5px);
        pointer-events: none;
        z-index: 5;
    }
    .overlay-left .glow-moon-spot { right: 18px; }
    .overlay-right .glow-moon-spot { left: 18px; }

    /* SAAT MODE GELAP — PENDAR CAHAYA LEBIH MENYALA */
    body.dark-mode .glow-lantern-spot {
        background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(245, 199, 78, 0.9) 30%, rgba(245, 199, 78, 0) 75%) !important;
        filter: blur(8px) !important;
        transform: scale(1.25);
    }
    body.dark-mode .glow-moon-spot {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.95) 0%, rgba(245, 197, 78, 0.8) 40%, rgba(245, 197, 78, 0) 80%) !important;
        filter: blur(8px) !important;
        transform: scale(1.25);
    }

    /* TEKS TOMBOL AKSI DI PANEL HIJAU TAJAM & JELAS */
    .btn-overlay-action {
        background-color: #f5c74e !important;
        color: #0d2417 !important;
        font-weight: 900 !important;
        letter-spacing: 0.05em !important;
    }
</style>
@endsection

@section('content')
<!-- BACKGROUND ISLAMI SAMA DENGAN BERANDA -->
<div class="fixed inset-0 w-full h-full pointer-events-none select-none z-0" aria-hidden="true">
    <div class="absolute inset-0 zy-zy-grad"></div>
    <svg class="absolute inset-0 w-full h-full zy-star" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
        <defs>
            <pattern id="zy-star-pat-login" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                <path d="M 40,0 L 48,16 L 64,8 L 56,24 L 72,32 L 56,40 L 72,48 L 56,56 L 64,72 L 48,64 L 40,80 L 32,64 L 16,72 L 24,56 L 8,48 L 24,40 L 8,32 L 24,24 L 16,8 L 32,16 Z" fill="none" stroke="currentColor" stroke-width="1.1"/>
                <path d="M 0,0 L 12,6 L 6,12 Z M 80,0 L 68,6 L 74,12 Z M 0,80 L 68,6 L 74,12 Z M 0,80 L 12,74 L 6,68 Z M 80,80 L 68,74 L 74,68 Z" fill="none" stroke="currentColor" stroke-width="0.8"/>
                <circle cx="40" cy="40" r="7" fill="none" stroke="currentColor" stroke-width="0.7"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#zy-star-pat-login)" />
    </svg>
</div>

<div class="w-full max-w-3xl mx-auto px-4 py-3 flex flex-col justify-center items-center my-auto relative z-10">

    <!-- TOMBOL TOGGLE DARK MODE (HIJAU SAAT LIGHT MODE, ORANGE SAAT DARK MODE) -->
    <div class="w-full flex justify-end mb-1.5 max-w-3xl">
        <button id="themeToggleAuth" type="button" class="bg-white/60 dark:bg-white/10 text-oliveDark dark:text-orange-400 px-3.5 py-1.5 rounded-full text-xs font-bold transition flex items-center gap-1.5 border border-gold/40 dark:border-orange-500/40 shadow-sm active:scale-95" title="Mode Gelap/Terang">
            <i id="themeIconAuth" class="fa-solid fa-moon text-oliveDark dark:text-orange-400"></i>
            <span id="themeTextAuth">Mode Gelap</span>
        </button>
    </div>
    
    <!-- CARD UTAMA -->
    <div class="neu-container bg-panel backdrop-blur-md border border-panel-border relative" id="authContainer">
        
        <!-- ================= FORM MASUK (LOGIN) ================= -->
        <div class="form-container sign-in-container p-5 sm:p-6 flex flex-col justify-between bg-cream2/60">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm border border-cream3 overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="font-black text-oliveDark text-base tracking-tight leading-tight">Masuk ke Website</h1>
                        <p class="text-[10px] text-olive/70">Masukkan akun Anda atau pilih akun demo.</p>
                    </div>
                </div>

                @if($errors->any() && !old('is_register'))
                    <div class="mt-2 bg-red-50 border border-red-200 text-red-700 rounded-xl px-3 py-1 text-[10px]">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-2.5 space-y-2">
                    @csrf
                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Email</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-envelope text-olive/50 text-xs"></i>
                            <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Kata Sandi</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-lock text-olive/50 text-xs"></i>
                            <input name="password" type="password" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-0.5">
                        <label class="flex items-center gap-1.5 text-oliveDark/80 cursor-pointer font-medium text-[10px]">
                            <input type="checkbox" name="remember" class="accent-olive rounded">
                            <span>Ingat saya</span>
                        </label>
                        <button type="submit" class="neu-btn bg-olive hover:bg-olive2 text-white font-bold px-4 py-1.5 rounded-xl text-xs flex items-center gap-1.5 border border-gold/30">
                            MASUK <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </form>

                <!-- AKUN DEMO RINGKAS -->
                <div class="mt-2.5 pt-2 border-t border-cream3/80">
                    <div class="text-[9px] tracking-[0.12em] font-extrabold text-olive/60 mb-1 uppercase">— Akun Demo (Klik untuk Isi) —</div>
                    <div class="grid grid-cols-2 gap-1.5" id="demoAccounts">
                        <button type="button" data-email="superadmin@banjarbaru.go.id" data-pass="superadmin123" class="demo text-left bg-white/80 border border-cream3/80 rounded-lg p-1.5 hover:bg-olive/10 transition group">
                            <div class="text-[10px] font-bold text-oliveDark group-hover:text-olive truncate">Super Admin</div>
                        </button>
                        <button type="button" data-email="admin@baznas-banjarbaru.id" data-pass="admin123" class="demo text-left bg-white/80 border border-cream3/80 rounded-lg p-1.5 hover:bg-olive/10 transition group">
                            <div class="text-[10px] font-bold text-oliveDark group-hover:text-olive truncate">Admin BAZNAS</div>
                        </button>
                        <button type="button" data-email="admin@upz-banjarbaru.id" data-pass="admin123" class="demo text-left bg-white/80 border border-cream3/80 rounded-lg p-1.5 hover:bg-olive/10 transition group">
                            <div class="text-[10px] font-bold text-oliveDark group-hover:text-olive truncate">Admin UPZ Masjid</div>
                        </button>
                        <button type="button" data-email="user@gmail.com" data-pass="user123" class="demo text-left bg-white/80 border border-cream3/80 rounded-lg p-1.5 hover:bg-olive/10 transition group">
                            <div class="text-[10px] font-bold text-oliveDark group-hover:text-olive truncate">User Warga</div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="pb-3 px-5 sm:px-6">
                <a href="{{ url('/') }}" class="text-[10px] text-olive/70 hover:text-oliveDark font-semibold transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[9px]"></i> Kembali ke beranda
                </a>
            </div>
        </div>

        <!-- ================= FORM DAFTAR (REGISTER) ================= -->
        <div class="form-container sign-up-container p-5 sm:p-6 flex flex-col justify-between bg-cream2/60">
            <div>
                <h1 class="font-black text-oliveDark text-base tracking-tight leading-tight">Buat Akun Baru</h1>
                <p class="text-[10px] text-olive/70 mt-0.5">Buat akun masyarakat untuk mengakses e-zakat.</p>

                @if($errors->any() && old('is_register'))
                    <div class="mt-2 bg-red-50 border border-red-200 text-red-700 rounded-xl px-3 py-1 text-[10px]">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-2.5 space-y-2">
                    @csrf
                    <input type="hidden" name="is_register" value="1">
                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-user text-olive/50 text-xs"></i>
                            <input name="name" type="text" value="{{ old('name') }}" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="Nama Anda">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Email</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-envelope text-olive/50 text-xs"></i>
                            <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Kata Sandi</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-lock text-olive/50 text-xs"></i>
                            <input name="password" type="password" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="Min. 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-extrabold text-oliveDark block mb-0.5 uppercase tracking-wider">Ulangi Kata Sandi</label>
                        <div class="neu-input flex items-center border border-cream3/80 rounded-xl px-3 py-1.5 bg-white/80">
                            <i class="fa-solid fa-shield-halved text-olive/50 text-xs"></i>
                            <input name="password_confirmation" type="password" required class="w-full bg-transparent outline-none text-xs ml-2 text-oliveDark font-semibold" placeholder="Ulangi kata sandi">
                        </div>
                    </div>

                    <div class="pt-1.5">
                        <button type="submit" class="neu-btn w-full bg-olive hover:bg-olive2 text-white font-bold py-1.5 rounded-xl text-xs border border-gold/30">
                            DAFTAR SEKARANG
                        </button>
                    </div>
                </form>
            </div>

            <div class="pb-3">
                <a href="{{ url('/') }}" class="text-[10px] text-olive/70 hover:text-oliveDark font-semibold transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[9px]"></i> Kembali ke beranda
                </a>
            </div>
        </div>

        <!-- ================= SLIDING OVERLAY CONTAINER ================= -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-stars"></div>
                
                <!-- OVERLAY KIRI (SLIDE TO REGISTER) -->
                <div class="overlay-panel overlay-left relative overflow-hidden">
                    <!-- SPOT CAHAYA RADIAL -->
                    <div class="glow-lantern-spot"></div>
                    <div class="glow-moon-spot"></div>

                    <!-- LAMPION SVG BERAYUN -->
                    <div class="absolute top-0 left-6 panel-lantern pointer-events-none opacity-95 z-10">
                        <svg width="42" height="130" viewBox="0 0 60 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="30" y1="0" x2="30" y2="50" stroke="#fadb82" stroke-width="1.8" stroke-dasharray="3 3"/>
                            <circle cx="30" cy="50" r="4" stroke="#fadb82" stroke-width="1.5" fill="none"/>
                            <path d="M 20 60 C 20 54, 40 54, 40 60 L 37 66 L 23 66 Z" fill="#d4a742"/>
                            <ellipse cx="30" cy="92" rx="14" ry="22" fill="#fffcf0" opacity="0.95"/>
                            <path d="M 23 66 L 12 88 L 18 118 L 30 128 L 42 118 L 48 88 L 37 66 Z" fill="none" stroke="#d4a742" stroke-width="1.8"/>
                            <path d="M 18 118 L 23 130 L 37 130 L 42 118 Z" fill="#d4a742"/>
                            <path d="M 30 130 L 30 145" stroke="#fadb82" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <!-- BULAN SABIT SVG -->
                    <div class="absolute top-2.5 right-6 pointer-events-none opacity-80 z-10">
                        <svg width="32" height="32" viewBox="0 0 100 100" fill="#fadb82"><path d="M62 8a46 46 0 1 0 0 84 52 52 0 0 1 0-84z"/></svg>
                    </div>

                    <div class="relative z-20">
                        <h2 class="font-black text-xl lg:text-2xl text-white tracking-tight">Selamat Datang Kembali!</h2>
                        <p class="text-[11px] text-white/80 leading-relaxed font-medium mt-1.5">
                            Untuk tetap terhubung dengan kami, silakan masuk menggunakan akun pribadi Anda.
                        </p>
                        <button type="button" class="neu-btn btn-overlay-action px-6 py-2 rounded-full text-xs mt-3.5 shadow-md transition active:scale-95 border border-amber-300/40" id="signInBtn">
                            MASUK
                        </button>
                    </div>
                </div>

                <!-- OVERLAY KANAN (MODE LOGIN) -->
                <div class="overlay-panel overlay-right relative overflow-hidden">
                    <!-- SPOT CAHAYA RADIAL -->
                    <div class="glow-lantern-spot"></div>
                    <div class="glow-moon-spot"></div>

                    <!-- LAMPION SVG BERAYUN -->
                    <div class="absolute top-0 right-6 panel-lantern pointer-events-none opacity-95 z-10">
                        <svg width="42" height="130" viewBox="0 0 60 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="30" y1="0" x2="30" y2="45" stroke="#fadb82" stroke-width="1.8" stroke-dasharray="3 3"/>
                            <circle cx="30" cy="45" r="4" stroke="#fadb82" stroke-width="1.5" fill="none"/>
                            <path d="M 20 55 C 20 49, 40 49, 40 55 L 37 61 L 23 61 Z" fill="#d4a742"/>
                            <ellipse cx="30" cy="87" rx="14" ry="22" fill="#fffcf0" opacity="0.95"/>
                            <path d="M 23 61 L 12 83 L 18 113 L 30 123 L 42 113 L 48 83 L 37 61 Z" fill="none" stroke="#d4a742" stroke-width="1.8"/>
                            <path d="M 18 113 L 23 125 L 37 125 L 42 113 Z" fill="#d4a742"/>
                            <path d="M 30 125 L 30 140" stroke="#fadb82" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <!-- BULAN SABIT SVG -->
                    <div class="absolute top-2.5 left-6 pointer-events-none opacity-80 z-10">
                        <svg width="32" height="32" viewBox="0 0 100 100" fill="#fadb82"><path d="M62 8a46 46 0 1 0 0 84 52 52 0 0 1 0-84z"/></svg>
                    </div>

                    <div class="relative z-20">
                        <h2 class="font-black text-xl lg:text-2xl text-white tracking-tight">Halo, Sahabat!</h2>
                        <p class="text-[11px] text-white/80 leading-relaxed font-medium mt-1.5">
                            Masukkan data pribadi Anda dan mulailah perjalanan keberkahan bersama E-Zakat Banjarbaru.
                        </p>
                        <button type="button" class="neu-btn btn-overlay-action px-6 py-2 rounded-full text-xs mt-3.5 shadow-md transition active:scale-95 border border-amber-300/40" id="signUpBtn">
                            DAFTAR
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('authContainer');
    const signUpBtn = document.getElementById('signUpBtn');
    const signInBtn = document.getElementById('signInBtn');
    const toggleBtn = document.getElementById('themeToggleAuth');
    const themeIcon = document.getElementById('themeIconAuth');
    const themeText = document.getElementById('themeTextAuth');

    function updateThemeUI(isDark) {
        if(isDark) {
            document.body.classList.add('dark-mode');
            if(themeIcon) themeIcon.className = 'fa-solid fa-sun text-orange-400';
            if(themeText) themeText.textContent = 'Mode Terang';
        } else {
            document.body.classList.remove('dark-mode');
            if(themeIcon) themeIcon.className = 'fa-solid fa-moon text-oliveDark';
            if(themeText) themeText.textContent = 'Mode Gelap';
        }
    }

    // CEK TEMA SAAT INI
    const isDarkCurrent = localStorage.getItem('theme') === 'dark';
    updateThemeUI(isDarkCurrent);

    toggleBtn?.addEventListener('click', () => {
        const isDark = !document.body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateThemeUI(isDark);
    });

    if (signUpBtn && container) {
        signUpBtn.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });
    }

    if (signInBtn && container) {
        signInBtn.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });
    }

    document.querySelectorAll('.demo').forEach(b => {
        b.addEventListener('click', () => {
            const emailInp = document.querySelector('.sign-in-container input[name=email]');
            const passInp = document.querySelector('.sign-in-container input[name=password]');
            if (emailInp) emailInp.value = b.dataset.email;
            if (passInp) passInp.value = b.dataset.pass;
            if (emailInp) emailInp.focus();
        });
    });

    @if(old('is_register'))
        if (container) container.classList.add('right-panel-active');
    @endif
});
</script>
@endsection