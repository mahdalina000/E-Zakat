@extends('layouts.dashboard')
@section('title', __('Banner Hari Raya — E-Zakat'))
@section('page-title', __('Kelola Banner Hari Raya & Pengingat Zakat'))
@section('page-sub', __('Atur teks ucapan, tanggal countdown, dan daftar hari raya yang tampil di beranda'))
@section('content')

{{-- FORM TAMBAH --}}
<div class="rounded-[20px] border border-cream3/30 p-5 mb-6">
    <div class="font-bold text-oliveDark text-sm mb-4 flex items-center gap-2"><i class="fa-solid fa-plus text-olive"></i> {{ __('Tambah Banner Hari Raya Baru') }}</div>
    <form method="POST" action="{{ route('admin.holidays.store') }}" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @csrf
        <div class="sm:col-span-2 lg:col-span-1">
            <label class="text-xs font-semibold text-oliveDark">{{ __('Nama Hari Raya') }} *</label>
            <input name="name" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2" placeholder="{{ __('mis. Idul Fitri 1449H') }}">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Key (slug unik)') }} <span class="text-olive/40 font-normal">{{ __('· opsional') }}</span></label>
            <input name="key" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2" placeholder="{{ __('auto dari nama') }}">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Tanggal Hari Raya') }} *</label>
            <input name="event_date" id="event_date" type="date" required value="{{ old('event_date', now()->toDateString()) }}" onclick="this.showPicker && this.showPicker()" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Mulai tampil') }} <span class="text-olive/40 font-normal">{{ __('· hari sebelum (opsional)') }}</span></label>
            <input name="before_days" type="number" min="0" max="90" value="15" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Bertahan') }} <span class="text-olive/40 font-normal">{{ __('· hari sesudah (opsional)') }}</span></label>
            <input name="after_days" type="number" min="0" max="90" value="3" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Ikon') }} <span class="text-olive/40 font-normal">{{ __('· opsional') }}</span></label>
            <input name="icon" placeholder="{{ __('fa-solid fa-mosque (contoh)') }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Warna') }} <span class="text-olive/40 font-normal">{{ __('· opsional') }}</span></label>
            <select name="color" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                @foreach(['olive','teal','blue','emerald','rose','gold'] as $c)
                <option value="{{ $c }}" @selected((old('color') ?? 'olive') === $c)>{{ ucfirst($c) }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2 lg:col-span-1">
            <label class="text-xs font-semibold text-oliveDark">{{ __('Judul Banner') }} *</label>
            <input name="title" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2" placeholder="{{ __('mis. Idul Fitri Mendekat!') }}">
        </div>
        <div class="sm:col-span-2 lg:col-span-3">
            <label class="text-xs font-semibold text-oliveDark">{{ __('Isi Ucapan') }} *</label>
            <textarea name="text" rows="2" required class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2 text-xs bg-cream2" placeholder="{{ __('Pesan yang tampil di banner...') }}"></textarea>
        </div>
        <div class="sm:col-span-2 lg:col-span-3 flex items-center justify-end">
            <button class="bg-olive text-white font-semibold px-5 py-2 rounded-full text-xs hover:bg-olive2"><i class="fa-solid fa-plus mr-1"></i> {{ __('Tambah Banner') }}</button>
        </div>
    </form>
</div>

{{-- DAFTAR BANNER --}}
<div class="rounded-[20px] border border-cream3/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">{{ __('Nama / Tanggal') }}</th>
                <th class="px-4 py-3">{{ __('Kehadir') }}</th>
                <th class="px-4 py-3">{{ __('Warna') }}</th>
                <th class="px-4 py-3">{{ __('Status') }}</th>
                <th class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
            </tr></thead>
            <tbody>
            @forelse($banners as $b)
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-oliveDark">{{ $b->name }}</div>
                        <div class="text-[11px] text-olive/50">{{ $b->event_date->translatedFormat('d M Y') }} · H-{{ $b->before_days }} s/d H+{{ $b->after_days }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ \Illuminate\Support\Str::limit($b->text, 40) }}</td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full text-white" style="background: {{ match($b->color){'teal'=>'#0f766e','blue'=>'#1d4ed8','emerald'=>'#047857','rose'=>'#be123c','gold'=>'#926c1a',default=>'#3f5f43'} }}">{{ ucfirst($b->color) }}</span></td>
                    <td class="px-4 py-3">
                        <span class="text-[11px] px-2 py-1 rounded-full {{ $b->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $b->is_active ? __('Aktif') : __('Nonaktif') }}</span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <form method="POST" action="{{ route('admin.holidays.toggle', $b) }}" class="inline">@csrf<button class="w-8 h-8 rounded-lg {{ $b->is_active ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}" title="{{ __('Aktif/Nonaktifkan') }}"><i class="fa-solid {{ $b->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i></button></form>
                        <form method="POST" action="{{ route('admin.holidays.destroy', $b) }}" class="inline" onsubmit="event.preventDefault()">@csrf @method('DELETE')<button type="button" data-title="{{ __('Hapus') }}" data-message="{{ __('Hapus banner ini?') }}" data-action="{{ route('admin.holidays.destroy', $b) }}" class="w-8 h-8 rounded-lg bg-red-50 text-red-500" onclick="event.preventDefault(); confirmDelete({ title: this.dataset.title, message: this.dataset.message, action: this.dataset.action })"><i class="fa-solid fa-trash text-xs"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">{{ __('Belum ada banner. Tambah di form atas.') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-cream2">{{ $banners->links() }}</div>
</div>

@endsection
