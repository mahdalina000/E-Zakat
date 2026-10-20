@extends('layouts.dashboard')
@section('title','Semua Lokasi — E-Zakat')
@section('page-title','Semua Lokasi Penyaluran')
@section('page-sub','Data lokasi dari seluruh admin UPZ/BAZNAS')
@section('content')
<div class="flex flex-wrap items-center gap-2 mb-4">
    @php $tabs=['all'=>'Semua','baznas'=>'BAZNAS','upz'=>'UPZ/Masjid','warga'=>'Rumah Warga']; @endphp
    @foreach($tabs as $k=>$v)
        <a href="{{ route('super.locations', $k==='all'?null:['type'=>$k]) }}"
           class="px-4 py-2 rounded-full text-xs font-semibold {{ ($type===$k || ($k==='all' && !$type)) ? 'bg-olive text-white' : 'border border-cream3 text-olive' }}">
            {{ $v }} <span class="opacity-60">({{ $counts[$k] }})</span>
        </a>
    @endforeach
</div>

<div class="rounded-[20px] border border-cream3/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">Nama</th><th class="px-4 py-3">Wilayah</th><th class="px-4 py-3">Tipe</th>
                <th class="px-4 py-3">Dikelola oleh</th><th class="px-4 py-3">Status</th>
            </tr></thead>
            <tbody>
            @forelse($locations as $l)
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3">
                        <div class="font-semibold">{{ $l->name }}</div>
                        <div class="text-[11px] text-olive/50">{{ $l->address }}</div>
                        <div class="text-[10px] text-olive/40 mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i>{{ $l->latitude }}, {{ $l->longitude }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $l->kelurahan }}<br><span class="text-olive/50">{{ $l->kecamatan }}</span></td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full text-white" style="background: {{ $l->typeColor() }}">{{ $l->typeLabel() }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $l->creator->name ?? '—' }}</td>
                    <td class="px-4 py-3"><span class="text-[11px] {{ $l->is_active ? 'text-emerald-600' : 'text-gray-400' }}"><i class="fa-solid fa-circle text-[7px] mr-1"></i>{{ $l->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">Belum ada data lokasi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $locations->links() }}</div>
@endsection
