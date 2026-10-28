@extends('layouts.dashboard')
@section('title','Riwayat Perhitungan — E-Zakat')
@section('page-title','Riwayat Perhitungan Zakat')
@section('page-sub','Semua perhitungan yang pernah Anda lakukan')
@section('content')

<div class="space-y-4">
    @forelse($histories as $h)
    <div class="bg-white rounded-[20px] border border-cream3 p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-olive/10 text-olive flex items-center justify-center">
                    <i class="fa-solid {{ $h->calcTypeIcon() }}"></i>
                </span>
                <div>
                    <div class="font-bold text-oliveDark text-sm">{{ $h->calcTypeLabel() }}</div>
                    <div class="text-[11px] text-olive/50">{{ $h->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
            @if(($h->result_data['total'] ?? null) !== null)
            <div class="text-right">
                <div class="text-[10px] text-olive/50 uppercase">Total Nilai</div>
                <div class="font-black text-oliveDark text-lg">Rp {{ number_format($h->result_data['total'], 0, ',', '.') }}</div>
            </div>
            @endif
        </div>

        {{-- Detail input --}}
        @if($h->input_data)
        <details class="mt-2">
            <summary class="text-xs font-semibold text-olive cursor-pointer">Lihat Input Data</summary>
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
            <summary class="text-xs font-semibold text-olive cursor-pointer">Lihat Hasil Perhitungan</summary>
            <div class="mt-2 bg-cream2 rounded-xl p-3 text-xs">
                @if(isset($h->result_data['hasil']))
                <table class="w-full">
                    <thead><tr class="text-left border-b border-cream3">
                        <th class="py-1.5 text-olive/60">Ahli Waris</th>
                        <th class="py-1.5 text-olive/60 text-right">Persentase</th>
                        <th class="py-1.5 text-olive/60 text-right">Nilai</th>
                    </tr></thead>
                    <tbody>
                    @foreach($h->result_data['hasil'] as $item)
                    <tr class="border-b border-cream2 last:border-0">
                        <td class="py-1.5 font-semibold">{{ $item['ahli'] ?? ($item['name'] ?? '-') }}</td>
                        <td class="py-1.5 text-right text-olive/70">{{ $item['persen'] ?? ($item['porsiPersen'] ?? ($item['share_percentage'] ?? 0)) }}%</td>
                        <td class="py-1.5 text-right font-bold">Rp {{ number_format($item['nilai'] ?? ($item['share_value'] ?? 0), 0, ',', '.') }}</td>
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
                        <span class="font-bold">{{ is_numeric($val) ? 'Rp ' . number_format($val, 0, ',', '.') : $val }}</span>
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
    <div class="bg-white rounded-[20px] border border-cream3 p-10 text-center">
        <div class="text-olive/40 text-sm">Belum ada riwayat perhitungan. <a href="{{ route('user.calculators') }}" class="text-olive underline">Mulai hitung sekarang</a>.</div>
    </div>
    @endforelse
</div>

@if($histories->hasPages())
<div class="mt-4">
    {{ $histories->links() }}
</div>
@endif
@endsection
