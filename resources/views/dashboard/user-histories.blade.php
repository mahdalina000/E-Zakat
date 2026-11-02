@extends('layouts.dashboard')
@section('title','Riwayat Perhitungan — E-Zakat')
@section('page-title','Riwayat Perhitungan Zakat')
@section('page-sub','Semua perhitungan yang pernah Anda lakukan')

@section('head')
<style>
    /* KHUSUS DARK MODE (AGAR TIDAK TABRAK WARNA DI DARK MODE) */
    body.dark-mode .history-card {
        background-color: rgba(255, 255, 255, 0.07) !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(10px);
    }
    body.dark-mode .history-card .text-oliveDark,
    body.dark-mode .history-card summary {
        color: #f8fafc !important;
    }
    body.dark-mode .history-card .text-olive\/50,
    body.dark-mode .history-card .text-olive\/60,
    body.dark-mode .history-card .text-olive\/70 {
        color: #cbd5e1 !important;
    }
    body.dark-mode .history-card .bg-cream2 {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
</style>
@endsection

@section('content')

<div class="space-y-4">
    @forelse($histories as $h)
    <div class="history-card bg-white rounded-[20px] border border-cream3 p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between gap-4 mb-3">
            {{-- KIRI: Icon & Jenis Perhitungan --}}
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-9 h-9 rounded-full bg-olive/10 text-olive flex items-center justify-center shrink-0">
                    <i class="fa-solid {{ $h->calcTypeIcon() }}"></i>
                </span>
                <div class="truncate">
                    <div class="font-bold text-oliveDark text-sm truncate">{{ $h->calcTypeLabel() }}</div>
                    <div class="text-[11px] text-olive/50">{{ $h->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>

            {{-- KANAN: Total Nilai Rapat di Samping Tombol Hapus --}}
            <div class="flex items-center gap-4 shrink-0 ml-auto">
                @if(($h->result_data['total'] ?? null) !== null)
                <div class="text-right">
                    <div class="text-[10px] text-olive/50 uppercase tracking-wider font-semibold">Total Nilai</div>
                    <div class="font-black text-oliveDark text-base sm:text-lg">Rp {{ number_format($h->result_data['total'], 0, ',', '.') }}</div>
                </div>
                @endif

                <div>
                    <form action="{{ route('user.histories.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat perhitungan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus riwayat" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Detail input --}}
        @if($h->input_data)
        <details class="mt-2">
            <summary class="text-xs font-semibold text-olive cursor-pointer hover:underline">Lihat Input Data</summary>
            <div class="mt-2 bg-cream2 rounded-xl p-3 text-xs">
                @foreach($h->input_data as $key => $val)
                <div class="flex justify-between py-1 border-b border-cream3/50 last:border-0">
                    <span class="text-olive/60">{{ str_replace('_', ' ', $key) }}</span>
                    <span class="font-bold text-oliveDark">{{ is_bool($val) ? ($val ? 'Ya' : 'Tidak') : (is_numeric($val) ? number_format($val, 0, ',', '.') : $val) }}</span>
                </div>
                @endforeach
            </div>
        </details>
        @endif

        {{-- Detail hasil --}}
        @if($h->result_data)
        <details class="mt-2">
            <summary class="text-xs font-semibold text-olive cursor-pointer hover:underline">Lihat Hasil Perhitungan</summary>
            <div class="mt-2 bg-cream2 rounded-xl p-3 text-xs">
                @if(isset($h->result_data['hasil']))
                <table class="w-full text-left">
                    <thead><tr class="border-b border-cream3">
                        <th class="py-1.5 text-olive/60 font-semibold">Ahli Waris</th>
                        <th class="py-1.5 text-olive/60 text-right font-semibold">Persentase</th>
                        <th class="py-1.5 text-olive/60 text-right font-semibold">Nilai</th>
                    </tr></thead>
                    <tbody>
                    @foreach($h->result_data['hasil'] as $item)
                    <tr class="border-b border-cream2 last:border-0">
                        <td class="py-1.5 font-semibold text-oliveDark">{{ $item['ahli'] ?? ($item['name'] ?? '-') }}</td>
                        <td class="py-1.5 text-right text-olive/70">{{ $item['persen'] ?? ($item['porsiPersen'] ?? ($item['share_percentage'] ?? 0)) }}%</td>
                        <td class="py-1.5 text-right font-bold text-oliveDark">Rp {{ number_format($item['nilai'] ?? ($item['share_value'] ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @elseif(isset($h->result_data['total']))
                <div class="space-y-1">
                    @foreach($h->result_data as $key => $val)
                    @if(is_string($key) && $key !== 'hasil' && $key !== 'keterangan')
                    <div class="flex justify-between">
                        <span class="text-olive/60">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                        <span class="font-bold text-oliveDark">{{ is_numeric($val) ? 'Rp ' . number_format($val, 0, ',', '.') : $val }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
        </details>
        @endif
    </div>
    @empty
    <div class="history-card bg-white rounded-[20px] border border-cream3 p-10 text-center">
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