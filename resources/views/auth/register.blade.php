@extends('layouts.guest')
@section('title','Daftar — E-Zakat Banjarbaru')

@section('head')
<style>
    /* Styling khusus Neumorphism & Soft Shadows dengan Transisi Ultra Smooth */
    .neu-container {
        box-shadow: 20px 20px 60px #c5c8c5, -20px -20px 60px #ffffff;
        transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        will-change: transform;
    }
    .neu-input {
        box-shadow: inset 3px 3px 6px rgba(0,0,0,0.06), inset -3px -3px 6px rgba(255,255,255,0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .neu-input:focus-within {
        transform: translateY(-1px);
        box-shadow: inset 2px 2px 4px rgba(0,0,0,0.08), inset -2px -2px 4px rgba(255,255,255,0.9);
    }
    .neu-btn {
        box-shadow: 5px 5px 12px rgba(0,0,0,0.15), -3px -3px 8px rgba(255,255,255,0.5);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        will-change: transform;
    }
    .neu-btn:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 7px 7px 16px rgba(0,0,0,0.18), -4px -4px 10px rgba(255,255,255,0.7);
    }
    .neu-btn:active {
        transform: translateY(1px) scale(0.98);
        box-shadow: 2px 2px 6px rgba(0,0,0,0.12), -1px -1px 4px rgba(255,255,255,0.4);
    }
    .neu-panel {
        background: linear-gradient(145deg, rgba(75, 139, 59, 0.08), rgba(75, 139, 59, 0.18));
        transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Animasi Kemunculan Mulus Ala Video */
    @keyframes smoothFadeIn {
        0% {
            opacity: 0;
            transform: translateY(12px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .page-smooth-enter {
        animation: smoothFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 py-6 page-smooth-enter">
    <!-- CONTAINER UTAMA SPLIT 2 KOLOM ALA VIDEO (POSISI TERBALIK) -->
    <div class="neu-container bg-cream2 rounded-[36px] overflow-hidden grid lg:grid-cols-12 min-h-[550px] border border-cream3/60 relative">
        
        <!-- KOLOM KIRI (PANEL SAMBUTAN / WELCOME BACK ALA VIDEO) -->
        <div class="lg:col-span-5 neu-panel p-8 flex flex-col items-center justify-center text-center relative overflow-hidden order-2 lg:order-1 border-t lg:border-t-0 lg:border-r border-cream3/40">
            <div class="absolute -top-16 -left-16 w-56 h-56 rounded-full border-8 border-white/30 pointer-events-none transition-transform duration-700 hover:scale-110"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full border-8 border-white/20 pointer-events-none transition-transform duration-700 hover:scale-110"></div>

            <div class="relative z-10 space-y-4 max-w-xs">
                <h2 class="font-black text-oliveDark text-2xl lg:text-3xl tracking-tight">Welcome Back !</h2>
                <p class="text-xs text-oliveDark/80 leading-relaxed font-medium">
                    Untuk tetap terhubung dengan kami, silakan masuk menggunakan akun pribadi Anda.
                </p>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="neu-btn inline-block bg-white hover:bg-cream text-oliveDark font-extrabold px-8 py-3 rounded-full text-xs border border-cream3/60">
                        SIGN IN
                    </a>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (FORM CREATE ACCOUNT / REGISTER) -->
        <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between order-1 lg:order-2">
            <div>
                <!-- HEADER REGISTER -->
                <div class="text-center sm:text-left">
                    <h1 class="font-black text-oliveDark text-2xl tracking-tight">Create Account</h1>
                    <p class="text-[11px] text-olive/70 mt-0.5">Buat akun masyarakat untuk mengakses fitur e-zakat.</p>
                </div>

                <!-- ERROR ALERT -->
                @if($errors->any())
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-2.5 text-xs">
                        <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <!-- FORM REGISTER -->
                <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-3.5">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-oliveDark block mb-1">Nama Lengkap</label>
                        <div class="neu-input flex items-center border border-cream3/60 rounded-2xl px-4 py-2.5 bg-cream2">
                            <i class="fa-solid fa-user text-olive/50 text-xs"></i>
                            <input name="name" type="text" value="{{ old('name') }}" required class="w-full bg-transparent outline-none text-xs ml-3 text-oliveDark font-medium" placeholder="Nama Anda">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-oliveDark block mb-1">Email</label>
                        <div class="neu-input flex items-center border border-cream3/60 rounded-2xl px-4 py-2.5 bg-cream2">
                            <i class="fa-solid fa-envelope text-olive/50 text-xs"></i>
                            <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-transparent outline-none text-xs ml-3 text-oliveDark font-medium" placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-oliveDark block mb-1">Password</label>
                        <div class="neu-input flex items-center border border-cream3/60 rounded-2xl px-4 py-2.5 bg-cream2">
                            <i class="fa-solid fa-lock text-olive/50 text-xs"></i>
                            <input name="password" type="password" required class="w-full bg-transparent outline-none text-xs ml-3 text-oliveDark font-medium" placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-oliveDark block mb-1">Ulangi Password</label>
                        <div class="neu-input flex items-center border border-cream3/60 rounded-2xl px-4 py-2.5 bg-cream2">
                            <i class="fa-solid fa-shield-halved text-olive/50 text-xs"></i>
                            <input name="password_confirmation" type="password" required class="w-full bg-transparent outline-none text-xs ml-3 text-oliveDark font-medium" placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="neu-btn w-full sm:w-auto bg-olive hover:bg-olive2 text-white font-extrabold px-8 py-3 rounded-2xl text-xs">
                            SIGN UP NOW
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center sm:text-left text-xs text-olive/60 mt-5 font-medium">
                <a href="{{ url('/') }}" class="hover:text-olive transition-colors"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a>
            </p>
        </div>

    </div>
</div>
@endsection