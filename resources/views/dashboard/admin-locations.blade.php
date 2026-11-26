@extends('layouts.dashboard')
@section('title', __('Kelola Lokasi — E-Zakat'))
@section('page-title', __('Kelola Lokasi UPZ / BAZNAS'))
@section('page-sub', __('Semua admin dapat melihat dan mengubah seluruh lokasi'))
@section('content')
<div class="flex items-center justify-between mb-4">
    <div class="text-sm text-olive/60">{{ $locations->total() }} {{ __('lokasi') }}</div>
    <a href="{{ route('admin.locations.create') }}" class="bg-olive text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-olive2"><i class="fa-solid fa-plus mr-1"></i> {{ __('Tambah Lokasi') }}</a>
</div>

<div class="rounded-[20px] border border-cream3/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">{{ __('Nama') }}</th><th class="px-4 py-3">{{ __('Kelurahan') }}</th><th class="px-4 py-3">{{ __('Kecamatan') }}</th>
                <th class="px-4 py-3">{{ __('Tipe') }}</th><th class="px-4 py-3">{{ __('Status') }}</th><th class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
            </tr></thead>
            <tbody>
            @forelse($locations as $l)
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3">
                        <div class="font-semibold">{{ $l->name }}</div>
                        <div class="text-xs text-olive/70 mt-0.5 leading-snug">{{ mask_sensitive($l->address) }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $l->kelurahan }}</td>
                    <td class="px-4 py-3 text-xs">{{ $l->kecamatan }}</td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2.5 py-1 rounded-full text-white whitespace-nowrap" style="background: {{ $l->typeColor() }}">{{ $l->typeLabel() }}</span></td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap {{ $l->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $l->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.locations.edit', $l) }}" class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-cream text-olive hover:bg-cream3" title="{{ __('Edit') }}"><i class="fa-solid fa-pen text-xs"></i></a>
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminBaznas())
                        <form method="POST" action="{{ route('admin.locations.destroy', $l) }}" class="inline" onsubmit="event.preventDefault()">
                            @csrf @method('DELETE')
                            <button type="button" data-title="{{ __('Hapus') }}" data-message="{{ __('Hapus lokasi ini?') }}" data-action="{{ route('admin.locations.destroy', $l) }}" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100" title="{{ __('Hapus') }}" onclick="event.preventDefault(); confirmDelete({ title: this.dataset.title, message: this.dataset.message, action: this.dataset.action })"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                        @else
                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-cream2 text-olive/30" title="{{ __('Admin UPZ tidak dapat menghapus lokasi') }}"><i class="fa-solid fa-lock text-xs"></i></span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-olive/40">{{ __('Belum ada lokasi.') }} <a href="{{ route('admin.locations.create') }}" class="text-olive underline">{{ __('Tambah lokasi pertama') }}</a>.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $locations->links() }}</div>
@endsection
