@extends('layouts.dashboard')
@section('title', __('Survei Kepuasan Masyarakat — E-Zakat'))
@section('page-title', __('Survei Kepuasan Masyarakat'))
@section('page-sub', __('Bantu kami meningkatkan kualitas layanan'))

@section('head')
<style>
    .skm-q { border:1px solid rgba(255,255,255,0.12); background:rgba(255,255,255,0.05); }
    body.dark-mode .skm-q { background:rgba(255,255,255,0.07); }
    .rating-label input { display:none; }
    .rating-label span {
        display:inline-flex; width:34px; height:34px; align-items:center; justify-content:center;
        border-radius:999px; font-weight:700; font-size:13px; color:#cfe0d4;
        background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15);
        cursor:pointer; transition:all .15s ease;
    }
    .rating-label input:checked + span { background:#e2b356; color:#12301f; border-color:#e2b356; transform:scale(1.08); box-shadow:0 4px 14px -4px rgba(226,179,86,.6); }
    .rating-label:hover span { border-color:rgba(226,179,86,.6); }
</style>
@endsection

@section('content')
<div class="p-5 lg:p-8 max-w-3xl">
    @if($errors->any())
        <div class="mb-4 rounded-xl border border-red-400/50 bg-red-500/10 text-red-200 px-4 py-3 text-sm">
            {{ __('Mohon isi penilaian untuk semua pertanyaan.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('skm.store') }}">
        @csrf
        @foreach($questions as $i => $q)
            <div class="skm-q rounded-xl p-4 mb-3">
                <div class="font-semibold text-sm text-white mb-3">{{ $q }}</div>
                <div class="flex items-center gap-2 flex-wrap">
                    @for($v = 1; $v <= 5; $v++)
                        <label class="rating-label">
                            <input type="radio" name="answers[{{ $i }}]" value="{{ $v }}" required>
                            <span>{{ $v }}</span>
                        </label>
                    @endfor
                    <span class="ml-2 text-[11px] text-cream/50">{{ __('1 = Sangat buruk · 5 = Sangat baik') }}</span>
                </div>
            </div>
        @endforeach

        <div class="skm-q rounded-xl p-4 mb-4">
            <label class="block text-sm font-semibold text-white mb-2">{{ __('Komentar / Saran (opsional)') }}</label>
            <textarea name="comment" rows="4" placeholder="{{ __('Tulis saran atau masukan Anda...') }}" class="w-full rounded-xl bg-white/10 border border-white/15 text-white placeholder:text-cream/40 px-4 py-3 text-sm outline-none focus:border-gold/60"></textarea>
        </div>

        <button class="bg-gold text-oliveDark font-bold text-sm px-7 py-3 rounded-full shadow hover:brightness-110 transition active:scale-[0.98]">{{ __('Kirim Survei') }}</button>
    </form>
</div>
@endsection
