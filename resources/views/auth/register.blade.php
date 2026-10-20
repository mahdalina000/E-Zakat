@extends('layouts.guest')
@section('title','Daftar — E-Zakat Banjarbaru')
@section('content')
<div class="w-full max-w-md">
    <div class="rounded-[24px] border border-cream3/40 p-7">
        <div class="text-center">
            <div class="w-14 h-14 bg-olive rounded-2xl flex items-center justify-center text-cream text-2xl mx-auto"><i class="fa-solid fa-user-plus"></i></div>
            <h1 class="mt-4 font-extrabold text-oliveDark text-xl">Daftar Akun Masyarakat</h1>
            <p class="text-xs text-olive/60 mt-1">Buat akun untuk mengakses fitur e-zakat.</p>
        </div>

        @if($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-oliveDark">Nama Lengkap</label>
                <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Nama Anda">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="nama@email.com">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Password</label>
                <input name="password" type="password" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Ulangi Password</label>
                <input name="password_confirmation" type="password" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Ulangi password">
            </div>
            <button class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2 transition">Daftar Sekarang</button>
        </form>

        <p class="text-center text-xs text-olive/60 mt-5">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-olive underline">Masuk</a></p>
    </div>
    <p class="text-center text-xs text-olive/50 mt-4"><a href="{{ url('/') }}" class="hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a></p>
</div>
@endsection
