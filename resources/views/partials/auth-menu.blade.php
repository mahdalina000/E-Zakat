{{-- User menu / auth area, dipakai di layout publik & dashboard --}}
@auth
    @php $u = auth()->user(); @endphp
    <div class="hidden lg:flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-white/15 hover:bg-white/25 transition px-3 py-1.5 rounded-full text-xs">
            <span class="w-6 h-6 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-[11px]">{{ strtoupper(substr($u->name,0,1)) }}</span>
            <span class="max-w-[120px] truncate">{{ $u->name }}</span>
            <span class="bg-cream text-olive px-2 py-0.5 rounded-full text-[10px] font-semibold">{{ $u->roleLabel() }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-9 h-9 bg-white/15 hover:bg-red-500 transition rounded-full flex items-center justify-center" title="Keluar"><i class="fa-solid fa-right-from-bracket text-sm"></i></button>
        </form>
    </div>
@else
    <div class="hidden lg:flex items-center gap-2">
        <a href="{{ route('login') }}" class="bg-white/15 hover:bg-white/25 transition px-4 py-2 rounded-full text-xs font-semibold"><i class="fa-solid fa-right-to-bracket mr-1"></i> Masuk</a>
        <a href="{{ route('register') }}" class="bg-cream text-olive hover:bg-white transition px-4 py-2 rounded-full text-xs font-semibold">Daftar</a>
    </div>
@endauth
