@extends('layouts.dashboard')
@section('title', __('Rekap SKM — E-Zakat'))
@section('page-title', __('Rekapitulasi SKM'))
@section('page-sub', $count . ' ' . __('responden survei'))

@section('content')
<div class="p-5 lg:p-8">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl border border-gold/30 bg-gold/10 p-5">
            <div class="text-3xl font-extrabold text-gold">{{ $count }}</div>
            <div class="text-xs text-cream/70 font-semibold mt-1">{{ __('Total responden') }}</div>
        </div>
    </div>

    <div class="mb-6 rounded-xl border border-white/10 bg-white/5 p-5">
        <div class="font-bold text-white text-sm mb-4">{{ __('Rata-rata skor per pertanyaan (1–5)') }}</div>
        @forelse($averages as $i => $avg)
            <div class="flex items-center gap-3 mb-3">
                <div class="flex-1 text-xs text-cream/80">{{ $questions[$i] }}</div>
                <div class="w-10 text-right text-sm font-extrabold {{ $avg >= 4 ? 'text-gold' : 'text-white' }}">{{ number_format($avg, 2, ',', '.') }}</div>
            </div>
        @empty
            <div class="text-xs text-cream/50">{{ __('Belum ada data.') }}</div>
        @endforelse
    </div>

    <div class="text-xs text-cream/60 font-semibold mb-3">{{ __('Daftar jawaban responden') }}</div>
    @forelse($responses as $rsp)
        <div class="rounded-xl border border-white/10 bg-white/5 p-4 mb-3">
            <div class="flex justify-between text-xs mb-2">
                <span class="text-white font-bold">{{ $rsp->user ? $rsp->user->name : __('Tamu / anonim') }}</span>
                <span class="text-cream/50">{{ $rsp->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="flex gap-1 flex-wrap">
                @foreach($rsp->answers as $a)
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold {{ $a >= 4 ? 'bg-gold text-oliveDark' : 'bg-white/10 text-cream/70' }}">{{ $a }}</span>
                @endforeach
            </div>
            @if($rsp->comment)
                <p class="mt-3 text-xs text-cream/70 italic">“{{ $rsp->comment }}”</p>
            @endif
        </div>
    @empty
        <div class="text-center py-12 text-cream/50 text-sm">{{ __('Belum ada jawaban survei.') }}</div>
    @endforelse
</div>
@endsection
