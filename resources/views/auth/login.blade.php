@extends('layouts.guest')
@section('title','Masuk — E-Zakat Banjarbaru')
@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-[24px] shadow-xl border border-cream3 p-7">
        <div class="text-center">
            <!-- Logo E-Zakat dengan Container Putih Menyatu -->
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center p-1.5 mx-auto shadow-md ring-2 ring-olive/20 border border-cream3 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="E-Zakat Logo" 
                     class="w-full h-full object-contain">
            </div>
            <h1 class="mt-4 font-extrabold text-oliveDark text-xl">Masuk ke E-Zakat</h1>
            <p class="text-xs text-olive/60 mt-1">Pilih akun demo atau gunakan akun Anda.</p>
        </div>

        @if($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-oliveDark">Email</label>
                <div class="mt-1 flex items-center border border-cream3 rounded-full px-4 py-2.5 bg-cream2">
                    <i class="fa-solid fa-envelope text-olive/50 text-sm"></i>
                    <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="nama@email.com">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Password</label>
                <div class="mt-1 flex items-center border border-cream3 rounded-full px-4 py-2.5 bg-cream2">
                    <i class="fa-solid fa-lock text-olive/50 text-sm"></i>
                    <input name="password" type="password" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="••••••••">
                </div>
            </div>
            <label class="flex items-center gap-2 text-xs text-olive/70">
                <input type="checkbox" name="remember" class="accent-olive"> Ingat saya
            </label>
            <button class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition shadow-md flex items-center justify-center gap-2">
                Masuk <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="mt-5">
            <div class="text-[11px] tracking-[0.14em] font-semibold text-olive/50 text-center mb-2">— AKUN DEMO (KLIK UNTUK ISI OTOMATIS) —</div>
            <div class="grid gap-2" id="demoAccounts">
                <button type="button" data-email="superadmin@banjarbaru.go.id" data-pass="superadmin123" class="demo w-full text-left bg-cream border border-cream3 rounded-xl px-3 py-2 hover:bg-cream3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-violet-500"></span><span class="text-xs font-bold text-oliveDark">Super Admin — Pemko Banjarbaru</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">superadmin@banjarbaru.go.id / superadmin123</div>
                </button>
                <button type="button" data-email="admin@baznas-banjarbaru.id" data-pass="admin123" class="demo w-full text-left bg-cream border border-cream3 rounded-xl px-3 py-2 hover:bg-cream3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span><span class="text-xs font-bold text-oliveDark">Admin BAZNAS</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">admin@baznas-banjarbaru.id / admin123</div>
                </button>
                <button type="button" data-email="admin@upz-banjarbaru.id" data-pass="admin123" class="demo w-full text-left bg-cream border border-cream3 rounded-xl px-3 py-2 hover:bg-cream3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span><span class="text-xs font-bold text-oliveDark">Admin UPZ — Masjid Al-Munawwarah</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">admin@upz-banjarbaru.id / admin123</div>
                </button>
                <button type="button" data-email="user@gmail.com" data-pass="user123" class="demo w-full text-left bg-cream border border-cream3 rounded-xl px-3 py-2 hover:bg-cream3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span><span class="text-xs font-bold text-oliveDark">User — Warga Banjarbaru</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">user@gmail.com / user123</div>
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-olive/60 mt-5">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-olive underline">Daftar di sini</a></p>
    </div>
    <p class="text-center text-xs text-olive/50 mt-4"><a href="{{ url('/') }}" class="hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a></p>
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