@extends('layouts.dashboard')
@section('title', 'Masukan Warga — E-Zakat')
@section('page-title', 'Masukan Warga')
@section('page-sub', 'Kritik & saran yang dikirim warga')
@section('content')

@php
    // deteksi role agar form pakai rute yang benar
    $prefix = request()->routeIs('admin.*') ? 'admin' : 'super';
@endphp

<div class="flex flex-wrap items-center gap-3 mb-5">
    <div class="stat-card sc-olive !p-4 !min-w-0 flex-1">
        <div class="flex items-center gap-3">
            <div class="sc-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
            <div>
                <div class="sc-num text-2xl">{{ $unread }}</div>
                <div class="sc-sub">Masukan belum dibaca</div>
            </div>
        </div>
    </div>
    <div class="stat-card sc-gold !p-4 !min-w-0 flex-1">
        <div class="flex items-center gap-3">
            <div class="sc-icon"><i class="fa-solid fa-comment-dots"></i></div>
            <div>
                <div class="sc-num text-2xl">{{ $feedbacks->total() }}</div>
                <div class="sc-sub">Total masukan</div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-100 text-emerald-800 text-sm border border-emerald-200">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border border-olive/10 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-olive/10 flex items-center justify-between">
        <h2 class="text-sm font-bold text-oliveDark">Daftar Masukan Warga</h2>
        <span class="text-xs text-olive/60">Paling baru di atas</span>
    </div>

    <div class="divide-y divide-olive/10">
        @forelse($feedbacks as $fb)
            <div class="px-5 py-4 {{ $fb->is_read ? 'opacity-70 bg-cream/30' : 'bg-amber-50/40' }}">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if(!$fb->is_read)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[11px] font-semibold">
                                    <i class="fa-solid fa-circle text-[6px]"></i> Baru
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-olive/10 text-oliveDark text-[11px] font-semibold">
                                {{ $fb->category }}
                            </span>
                            <span class="text-xs text-olive/60">{{ $fb->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <h3 class="mt-2 text-sm font-bold text-oliveDark">{{ $fb->subject }}</h3>
                        <p class="mt-1 text-sm text-olive/80 leading-relaxed">{{ $fb->message }}</p>
                        <div class="mt-2 flex items-center gap-2 text-xs text-olive/60">
                            <i class="fa-solid fa-user"></i>
                            @if($fb->user)
                                <span>{{ $fb->user->name }} ({{ $fb->user->email }})</span>
                            @else
                                <span>Warga (sudah dihapus)</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if(!$fb->is_read)
                            <form method="POST" action="{{ route($prefix . '.feedback.read', $fb) }}">
                                @csrf
                                <button type="submit" title="Tandai dibaca"
                                        class="px-3 py-2 rounded-xl bg-olive text-cream text-xs font-semibold hover:bg-oliveDark transition">
                                    <i class="fa-solid fa-check"></i> <span class="hidden sm:inline">Tandai dibaca</span>
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route($prefix . '.feedback.destroy', $fb) }}"
                              onsubmit="return confirm('Hapus masukan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus"
                                    class="px-3 py-2 rounded-xl bg-rose-50 text-rose-600 text-xs font-semibold hover:bg-rose-100 transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-5 py-14 text-center">
                <div class="text-3xl text-olive/30 mb-2"><i class="fa-solid fa-inbox"></i></div>
                <p class="text-sm text-olive/60">Belum ada masukan dari warga.</p>
            </div>
        @endforelse
    </div>

    <div class="px-5 py-3 border-t border-olive/10">
        {{ $feedbacks->links() }}
    </div>
</div>

@endsection
