@extends('layouts.dashboard')
@section('title','Lokasi Saya — E-Zakat')
@section('page-title','Kelola Lokasi UPZ / BAZNAS')
@section('page-sub', auth()->user()->isAdminBaznas() ? 'Anda dapat mengelola seluruh lokasi' : 'Anda mengelola lokasi UPZ milik Anda')
@section('content')
<div class="flex items-center justify-between mb-4">
    <div class="text-sm text-olive/60">{{ $locations->total() }} lokasi</div>
    <a href="{{ route('admin.locations.create') }}" class="bg-olive text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-olive2"><i class="fa-solid fa-plus mr-1"></i> Tambah Lokasi</a>
</div>

<div class="rounded-[20px] border border-cream3/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kelurahan</th><th class="px-4 py-3">Kecamatan</th>
                <th class="px-4 py-3">Tipe</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($locations as $l)
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3">
                        <div class="font-semibold">{{ $l->name }}</div>
                        <div class="text-[11px] text-olive/50">{{ $l->address }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $l->kelurahan }}</td>
                    <td class="px-4 py-3 text-xs">{{ $l->kecamatan }}</td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full text-white" style="background: {{ $l->typeColor() }}">{{ $l->typeLabel() }}</span></td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full {{ $l->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $l->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.locations.edit', $l) }}" class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-cream text-olive hover:bg-cream3" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
                        <form method="POST" action="{{ route('admin.locations.destroy', $l) }}" class="inline" onsubmit="return confirm('Yakin hapus lokasi {{ $l->name }}?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-olive/40">Belum ada lokasi. <a href="{{ route('admin.locations.create') }}" class="text-olive underline">Tambah lokasi pertama</a>.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $locations->links() }}</div>
@endsection
