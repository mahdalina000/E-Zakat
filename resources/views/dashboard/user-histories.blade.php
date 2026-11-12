@extends('layouts.dashboard')
@section('title','Riwayat Perhitungan — E-Zakat')
@section('page-title','Riwayat Perhitungan Zakat')
@section('page-sub','Semua perhitungan yang pernah Anda lakukan')

@section('head')
<style>
    body.dark-mode .history-card {
        background-color: rgba(255, 255, 255, 0.07) !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(10px);
    }
    body.dark-mode .history-card .text-oliveDark,
    body.dark-mode .history-card .text-emerald-900,
    body.dark-mode .history-card .text-slate-800 {
        color: #f8fafc !important;
    }
    body.dark-mode .history-card .text-olive\/40,
    body.dark-mode .history-card .text-olive\/50,
    body.dark-mode .history-card .text-olive\/60,
    body.dark-mode .history-card .text-olive\/70 {
        color: #cbd5e1 !important;
    }
    body.dark-mode .history-card .bg-cream2,
    body.dark-mode .history-card .bg-emerald-50,
    body.dark-mode .history-card .bg-amber-50 {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    body.dark-mode .history-card .border-cream3,
    body.dark-mode .history-card .border-emerald-100,
    body.dark-mode .history-card .border-amber-100 {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
</style>
@endsection

@section('content')

<div class="space-y-4">
    @forelse($histories as $h)
    <div class="history-card bg-white rounded-[20px] border border-cream3 shadow-sm hover:shadow-md transition overflow-hidden">

        {{-- HEADER: badge jenis + tanggal + ikon + tombol hapus --}}
        <div class="flex items-center justify-between gap-3 px-4 py-3 bg-gradient-to-r from-olive/10 to-transparent border-b border-cream3">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-10 h-10 rounded-2xl bg-olive text-white flex items-center justify-center shrink-0 shadow-sm">
                    <i class="fa-solid {{ $h->calcTypeIcon() }}"></i>
                </span>
                <div class="min-w-0">
                    <div class="font-extrabold text-oliveDark text-sm truncate">{{ $h->calcTypeLabel() }}</div>
                    <div class="text-[11px] text-olive/50 flex items-center gap-1.5 mt-0.5">
                        <i class="fa-regular fa-calendar"></i>{{ $h->created_at->translatedFormat('d M Y') }}
                        <span class="text-olive/30">·</span>
                        <i class="fa-regular fa-clock"></i>{{ $h->created_at->translatedFormat('H:i') }}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @if(($h->result_data['total'] ?? null) !== null)
                <div class="text-right">
                    <div class="text-[9px] text-olive/50 uppercase tracking-wider font-semibold">Total Nilai</div>
                    <div class="font-black text-oliveDark text-base sm:text-lg leading-none">Rp {{ number_format($h->result_data['total'], 0, ',', '.') }}</div>
                </div>
                @endif
                <form action="{{ route('user.histories.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat perhitungan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Hapus riwayat" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- BADGE STATUS / KETERANGAN (bisa berupa string atau array) --}}
        @php
            $ket = $h->result_data['keterangan'] ?? null;
            $ketArr = is_array($ket) ? $ket : ($ket !== null ? [$ket] : []);
        @endphp
        @if($ketArr)
        <div class="px-4 pt-3">
            <div class="rounded-xl bg-amber-50 border border-amber-100 px-3 py-2 text-xs text-amber-800 font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-amber-500"></i>
                <div class="space-y-1">
                    @foreach($ketArr as $kline)
                    <div>{{ $kline }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="p-4 space-y-3">

            {{-- Detail input: grid 2 kolom --}}
            @if($h->input_data)
            <details class="group rounded-xl border border-cream3 bg-cream2/50 open:bg-white transition">
                <summary class="flex items-center justify-between px-3 py-2.5 text-xs font-bold text-olive cursor-pointer select-none">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-sliders text-[11px]"></i> Input Data</span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition group-open:rotate-180"></i>
                </summary>
                <div class="px-3 pb-3 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5">
                    @foreach($h->input_data as $key => $val)
                    <div class="flex justify-between items-baseline border-b border-cream3/50 pb-1">
                        <span class="text-[11px] text-olive/60 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="text-xs font-bold text-oliveDark text-right ml-2">
                            {{ is_bool($val) ? ($val ? 'Ya' : 'Tidak') : (is_numeric($val) ? number_format($val, 0, ',', '.') : $val) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </details>
            @endif

            {{-- Detail hasil --}}
            @if($h->result_data)
            <details class="group rounded-xl border border-cream3 bg-cream2/50 open:bg-white transition">
                <summary class="flex items-center justify-between px-3 py-2.5 text-xs font-bold text-olive cursor-pointer select-none">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-calculator text-[11px]"></i> Hasil Perhitungan</span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition group-open:rotate-180"></i>
                </summary>
                <div class="px-3 pb-3">
                    @if(isset($h->result_data['hasil']))
                    <div class="rounded-xl overflow-hidden border border-emerald-100">
                        <div class="bg-olive text-white px-3 py-2 text-[11px] font-extrabold tracking-wide uppercase">Daftar Pembagian</div>
                        <table class="w-full text-left text-xs">
                            <tbody>
                            @foreach($h->result_data['hasil'] as $item)
                            <tr class="border-b border-emerald-100 last:border-0 bg-white/60">
                                <td class="py-2 px-3 font-semibold text-oliveDark">{{ $item['ahli'] ?? ($item['name'] ?? '-') }}</td>
                                <td class="py-2 text-right text-olive/70">{{ $item['persen'] ?? ($item['porsiPersen'] ?? ($item['share_percentage'] ?? 0)) }}%</td>
                                <td class="py-2 px-3 text-right font-black text-oliveDark whitespace-nowrap">Rp {{ number_format($item['nilai'] ?? ($item['share_value'] ?? 0), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif(isset($h->result_data['total']))
                    <div class="space-y-1.5">
                        @foreach($h->result_data as $key => $val)
                        @if(is_string($key) && $key !== 'hasil' && $key !== 'keterangan' && !is_array($val))
                        <div class="flex justify-between items-baseline border-b border-cream3/50 pb-1.5">
                            <span class="text-[11px] text-olive/60 capitalize">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                            <span class="text-xs font-bold text-oliveDark">{{ is_numeric($val) ? 'Rp ' . number_format($val, 0, ',', '.') : $val }}</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </details>
            @endif

        </div>
    </div>
    @empty
    <div class="history-card bg-white rounded-[20px] border border-cream3 p-10 text-center">
        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-olive/10 text-olive flex items-center justify-center">
            <i class="fa-solid fa-chart-column"></i>
        </div>
        <div class="text-olive/40 text-sm">Belum ada riwayat perhitungan. <a href="{{ route('user.calculators') }}" class="text-olive underline font-semibold">Mulai hitung sekarang</a>.</div>
    </div>
    @endforelse
</div>

@if($histories->hasPages())
<div class="mt-4">
    {{ $histories->links() }}
</div>
@endif
@endsection
