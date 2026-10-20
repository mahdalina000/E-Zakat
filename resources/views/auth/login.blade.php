@extends('layouts.guest')
@section('title','Masuk — E-Zakat Banjarbaru')

@section('content')
<div class="w-full max-w-lg mx-auto">
    <!-- CARD UTAMA LOGIN -->
    <div class="rounded-[28px] border border-cream3/40 p-6 sm:p-7">
        
        <!-- HEADER LOGIN -->
        <div class="text-center">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center p-1.5 mx-auto shadow-md ring-2 ring-olive/20 border border-cream3 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="E-Zakat Logo" 
                     class="w-full h-full object-contain">
            </div>
            <h1 class="mt-3 font-extrabold text-oliveDark text-xl">Masuk ke E-Zakat</h1>
            <p class="text-[11px] text-olive/70 mt-0.5">Pilih akun demo atau gunakan akun Anda.</p>
        </div>

        <!-- ERROR ALERT -->
        @if($errors->any())
            <div class="mt-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-3.5 py-2 text-xs">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-3">
            @csrf
            <div>
                <label class="text-xs font-bold text-oliveDark block mb-1">Email</label>
                <div class="flex items-center border border-cream3 rounded-xl px-3.5 py-2 bg-cream2 focus-within:ring-2 focus-within:ring-olive/40 transition">
                    <i class="fa-solid fa-envelope text-olive/50 text-xs"></i>
                    <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-transparent outline-none text-xs ml-2.5 text-oliveDark" placeholder="nama@email.com">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-oliveDark block mb-1">Password</label>
                <div class="flex items-center border border-cream3 rounded-xl px-3.5 py-2 bg-cream2 focus-within:ring-2 focus-within:ring-olive/40 transition">
                    <i class="fa-solid fa-lock text-olive/50 text-xs"></i>
                    <input name="password" type="password" required class="w-full bg-transparent outline-none text-xs ml-2.5 text-oliveDark" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-0.5">
                <label class="flex items-center gap-2 text-oliveDark/80 cursor-pointer">
                    <input type="checkbox" name="remember" class="accent-olive rounded">
                    <span>Ingat saya</span>
                </label>
                <button type="submit" class="bg-olive hover:bg-olive2 text-white font-bold px-6 py-2 rounded-xl transition shadow flex items-center gap-2 active:scale-95">
                    Masuk <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>

        <!-- AKUN DEMO RINGKAS 2 KOLOM -->
        <div class="mt-4 pt-3 border-t border-cream3/60">
            <div class="text-[10px] tracking-[0.14em] font-bold text-olive/60 text-center mb-2 uppercase">— Akun Demo (Klik untuk Isi) —</div>
            <div class="grid sm:grid-cols-2 gap-2" id="demoAccounts">
                
                <button type="button" data-email="superadmin@banjarbaru.go.id" data-pass="superadmin123" class="demo text-left bg-cream2 border border-cream3/80 rounded-xl p-2 hover:bg-olive/10 hover:border-olive/30 transition leading-tight group">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-violet-500 shrink-0"></span>
                        <span class="text-[11px] font-bold text-oliveDark group-hover:text-olive truncate">Super Admin</span>
                    </div>
                    <div class="text-[9px] text-olive/60 mt-0.5 truncate">superadmin@banjarbaru.go.id</div>
                </button>

                <button type="button" data-email="admin@baznas-banjarbaru.id" data-pass="admin123" class="demo text-left bg-cream2 border border-cream3/80 rounded-xl p-2 hover:bg-olive/10 hover:border-olive/30 transition leading-tight group">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                        <span class="text-[11px] font-bold text-oliveDark group-hover:text-olive truncate">Admin BAZNAS</span>
                    </div>
                    <div class="text-[9px] text-olive/60 mt-0.5 truncate">admin@baznas-banjarbaru.id</div>
                </button>

                <button type="button" data-email="admin@upz-banjarbaru.id" data-pass="admin123" class="demo text-left bg-cream2 border border-cream3/80 rounded-xl p-2 hover:bg-olive/10 hover:border-olive/30 transition leading-tight group">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500 shrink-0"></span>
                        <span class="text-[11px] font-bold text-oliveDark group-hover:text-olive truncate">Admin UPZ Masjid</span>
                    </div>
                    <div class="text-[9px] text-olive/60 mt-0.5 truncate">admin@upz-banjarbaru.id</div>
                </button>

                <button type="button" data-email="user@gmail.com" data-pass="user123" class="demo text-left bg-cream2 border border-cream3/80 rounded-xl p-2 hover:bg-olive/10 hover:border-olive/30 transition leading-tight group">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500 shrink-0"></span>
                        <span class="text-[11px] font-bold text-oliveDark group-hover:text-olive truncate">User Warga</span>
                    </div>
                    <div class="text-[9px] text-olive/60 mt-0.5 truncate">user@gmail.com</div>
                </button>

            </div>
        </div>

        <p class="text-center text-xs text-olive/70 mt-4">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-olive hover:underline">Daftar di sini</a></p>
    </div>

    <p class="text-center text-xs text-olive/60 mt-3 font-medium">
        <a href="{{ url('/') }}" class="hover:text-olive transition"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a>
    </p>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.demo').forEach(b=>{
    b.addEventListener('click', ()=>{
        document.querySelector('input[name=email]').value = b.dataset.email;
        document.querySelector('input[name=password]').value = b.dataset.pass;
        document.querySelector('input[name=email]').focus();
    });
});
</script>
@endsection