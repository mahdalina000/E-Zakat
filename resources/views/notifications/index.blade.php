@extends('layouts.dashboard')
@section('title', __('Notifikasi — E-Zakat'))
@section('page-title', __('Notifikasi'))
@section('page-sub', __('Pemberitahuan aktivitas pengajuan Anda'))

@section('content')
<div class="p-5 lg:p-8 w-full space-y-5">

    <div class="rounded-2xl border border-cream3 bg-white p-5 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <div class="text-lg font-bold text-oliveDark"><i class="fa-solid fa-bell mr-2"></i>{{ __('Notifikasi') }}</div>
                <div class="text-xs text-olive/60 mt-1">{{ __('Total') }} <b class="text-oliveDark">{{ $notifications->count() }}</b> · <b class="text-oliveDark">{{ $unread }}</b> {{ __('belum dibaca') }}</div>
            </div>
            @if($unread > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button class="bg-olive text-white text-xs font-bold px-4 py-2 rounded-full hover:brightness-110 transition active:scale-[0.98]">{{ __('✓ Tandai semua sudah dibaca') }}</button>
                </form>
            @endif
        </div>

        <div class="flex flex-wrap gap-2 mt-4">
            @foreach(['all' => __('Semua'), 'unread' => __('Belum dibaca'), 'read' => __('Sudah dibaca')] as $f => $label)
                <a href="{{ route('notifications.index', ['filter' => $f]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $filter === $f ? 'bg-olive text-white' : 'bg-cream2 text-olive/70 hover:bg-cream3' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @forelse($notifications as $n)
        <div class="rounded-2xl border p-4 sm:p-5 flex items-start gap-3 transition {{ $n->read_at ? 'border-cream3 bg-white' : 'border-gold/60 bg-gold/5' }}">
            <span class="mt-1.5 w-2.5 h-2.5 rounded-full shrink-0 {{ $n->read_at ? 'bg-cream3' : 'bg-gold' }}"></span>
            <div class="min-w-0 flex-1">
                <div class="font-bold text-sm text-oliveDark leading-snug">{{ $n->localized_title }}</div>
                @if($n->message)
                    <p class="text-xs mt-1 text-olive/70 break-words">{{ $n->localized_message }}</p>
                @endif
                <div class="text-[11px] mt-2 text-olive/50">{{ $n->created_at->diffForHumans() }} · {{ $n->created_at->format('d M Y H:i') }}</div>
            </div>
            @if(!$n->read_at && $n->link)
                <a href="{{ $n->link }}" class="shrink-0 text-xs font-bold text-olive hover:underline mt-1">{{ __('Lihat →') }}</a>
            @endif
        </div>
    @empty
        <div class="rounded-2xl border border-dashed border-cream3 bg-white py-16 text-center">
            <div class="text-5xl text-olive/20 mb-4"><i class="fa-solid fa-bell-slash"></i></div>
            <div class="font-bold text-oliveDark">{{ __('Tidak ada notifikasi') }}</div>
            <div class="text-xs text-olive/50 mt-1">{{ __('Anda akan menerima pemberitahuan saat ada pembaruan pengajuan.') }}</div>
        </div>
    @endforelse
</div>
@endsection
