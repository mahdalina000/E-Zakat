@extends('layouts.dashboard')
@section('title', __('Kelola Penerima Zakat — E-Zakat'))
@section('page-title', __('Kelola Penerima Zakat') . ' — ' . auth()->user()->name)
@section('page-sub', __('Tambah, kelola, dan pantau warga penerima zakat'))
@section('content')

{{-- STAT --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-xs text-olive/60">{{ __('Total Warga Terdaftar') }}</div>
        <div class="text-3xl font-black text-oliveDark mt-1">{{ $warga->total() }}</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-xs text-olive/60">{{ __('Penerima Zakat') }}</div>
        <div class="text-3xl font-black text-emerald-600 mt-1">{{ $totalPenerima }}</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-xs text-olive/60">{{ __('Pemberi Zakat') }}</div>
        <div class="text-3xl font-black text-olive mt-1">{{ $totalPemberi }}</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white">
        <div class="text-xs text-cream/70">{{ __('Catatan Zakat Total') }}</div>
        <div class="text-3xl font-black mt-1">{{ $totalRecords }}</div>
    </div>
</div>

{{-- AKSI --}}
<div class="mt-4 bg-white rounded-[20px] border border-cream3 p-4">
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-oliveDark">{{ __('Aksi:') }}</span>
        <button onclick="document.getElementById('wargaModal').classList.remove('hidden')" class="bg-olive text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-olive2">
            <i class="fa-solid fa-user-plus mr-1"></i> {{ __('Tambah Warga') }}
        </button>
        <button onclick="document.getElementById('exportModal').classList.remove('hidden')" class="bg-cream border border-cream3 text-olive text-xs font-semibold px-4 py-2 rounded-full hover:bg-cream3">
            <i class="fa-solid fa-file-excel mr-1"></i> {{ __('Export Excel') }}
        </button>
    </div>
</div>

{{-- MODAL EXPORT BERDASARKAN KATEGORI --}}
<div id="exportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-5 w-full max-w-sm">
        <h3 class="font-bold text-oliveDark text-sm mb-4 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-olive"></i> {{ __('Export Catatan Zakat') }}
        </h3>
        <div class="space-y-2">
            <a href="{{ route('admin.export', ['kategori' => 'semuanya']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-list mr-2 text-olive"></i> {{ __('Semua Catatan') }}</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
            <a href="{{ route('admin.export', ['kategori' => 'penerima']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-hand-holding-heart mr-2 text-emerald-600"></i> {{ __('Khusus Penerima') }}</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
            <a href="{{ route('admin.export', ['kategori' => 'pemberi']) }}" class="flex items-center justify-between w-full border border-cream3 rounded-xl px-4 py-3 text-xs font-semibold text-oliveDark hover:bg-cream2">
                <span><i class="fa-solid fa-hand-holding-dollar mr-2 text-olive"></i> {{ __('Khusus Pemberi') }}</span>
                <i class="fa-solid fa-chevron-right text-olive/40"></i>
            </a>
        </div>
        <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="mt-4 w-full bg-cream border border-cream3 text-olive font-semibold px-4 py-2 rounded-full text-xs">{{ __('Tutup') }}</button>
    </div>
</div>

{{-- WARGA BARU MENUNGGU VERIFIKASI --}}
@if($pendingWarga->isNotEmpty())
<div class="mt-4 bg-white rounded-[20px] border border-cream3 overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-cream2 bg-amber-50/60">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center"><i class="fa-solid fa-clock-rotate-left text-xs"></i></span>
            <span class="font-bold text-oliveDark text-sm">{{ __('Warga Baru — Menunggu Verifikasi') }}</span>
            <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingWarga->count() }}</span>
        </div>
        <span class="text-[11px] text-olive/50">{{ __('Verifikasi status agar masuk ke peta') }}</span>
    </div>
    <div class="divide-y divide-cream2">
        @foreach($pendingWarga as $pw)
        <div class="flex items-center gap-3 px-4 py-3">
            <span class="w-9 h-9 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-xs shrink-0">{{ strtoupper(substr($pw->name,0,1)) }}</span>
            <div class="min-w-0 flex-1">
                <div class="font-semibold text-oliveDark text-sm truncate">{{ $pw->name }}</div>
                <div class="text-[11px] text-olive/50 truncate">
                    {{ $pw->wargaProfile?->kategoriLabel() ?? __('Belum ada kategori') }}
                    <span class="text-red-500 font-semibold"> {{ __('· belum terverifikasi') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.warga.show', $pw) }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-cream text-olive hover:bg-cream3" title="{{ __('Detail') }}"><i class="fa-solid fa-eye text-xs"></i></a>
                <form action="{{ route('admin.warga.verify', $pw) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 bg-olive text-white text-xs font-semibold px-3 py-2 rounded-full hover:bg-olive2"><i class="fa-solid fa-check"></i> {{ __('Verifikasi') }}</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- LIST WARGA --}}
<div class="mt-4 bg-white rounded-[20px] border border-cream3 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="text-left text-xs text-olive/50 bg-cream">
            <th class="px-4 py-3">{{ __('Warga') }}</th>
            <th class="px-4 py-3">{{ __('Kategori') }}</th>
            <th class="px-4 py-3">{{ __('Penghasilan/Bulan') }}</th>
            <th class="px-4 py-3">{{ __('Tanggungan') }}</th>
            <th class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
        </tr></thead>
        <tbody>
        @forelse($warga as $user)
            <tr class="border-t border-cream2 hover:bg-cream2/50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-xs shrink-0">{{ strtoupper(substr($user->name,0,1)) }}</span>
                        <div class="min-w-0">
                            <div class="font-semibold text-oliveDark truncate">{{ $user->name }}</div>
                            <div class="text-[11px] text-olive/50 truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    @if($user->wargaProfile?->zakat_category)
                        @if($user->wargaProfile->category_approved)
                        <span class="text-[11px] px-2 py-1 rounded-full {{ $user->wargaProfile->zakat_category === 'pemberi' ? 'bg-olive/10 text-olive' : 'bg-emerald-100 text-emerald-700' }}">{{ $user->wargaProfile->kategoriLabel() }}</span>
                        @else
                        <div class="flex flex-col items-start gap-1">
                            <span class="text-[11px] px-2 py-1 rounded-full bg-amber-100 text-amber-700">{{ $user->wargaProfile->kategoriLabel() }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-50 text-red-500 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-0.5"></i>{{ __('Belum Terverifikasi') }}</span>
                        </div>
                        @endif
                    @else
                    <span class="text-[11px] text-olive/40">{{ __('Belum') }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-xs font-semibold text-oliveDark">
                    Rp {{ number_format($user->wargaProfile->monthly_income ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-xs">{{ $user->wargaProfile->dependents_count ?? 0 }} {{ __('jiwa') }}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <a href="{{ route('admin.warga.show', $user) }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-cream text-olive hover:bg-cream3" title="{{ __('Detail') }}"><i class="fa-solid fa-eye text-xs"></i></a>
                    @unless($user->wargaProfile?->category_approved)
                    <form action="{{ route('admin.warga.verify', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-olive text-white hover:bg-olive2" title="Verifikasi status"><i class="fa-solid fa-check text-xs"></i></button>
                    </form>
                    @endunless
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">{{ __('Belum ada warga terdaftar.') }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-cream2">{{ $warga->withQueryString()->links() }}</div>
</div>

{{-- MODAL TAMBAH WARGA --}}
<div id="wargaModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-5 w-full max-w-lg max-h-[90vh] overflow-auto">
        <h3 class="font-bold text-oliveDark text-sm mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-olive"></i> {{ __('Tambah Warga Penerima Zakat') }}
        </h3>
        <form method="POST" action="{{ route('admin.warga.store') }}" class="space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Nama Lengkap') }} *</label>
                    <input name="name" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Email') }} *</label>
                    <input name="email" type="email" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Password') }} *</label>
                <input name="password" type="password" required minlength="8" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                <p class="text-[10px] text-olive/50 mt-0.5">{{ __('Warga dapat login dengan email & password ini.') }}</p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('NIK') }} <span class="text-red-500">*</span></label>
                    <input name="nik" maxlength="16" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Jenis Kelamin') }} <span class="text-red-500">*</span></label>
                    <select name="gender" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                        <option value="">{{ __('Pilih...') }}</option>
                        <option value="male">{{ __('Laki-laki') }}</option>
                        <option value="female">{{ __('Perempuan') }}</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Tanggal Lahir') }} <span class="text-red-500">*</span></label>
                    <input name="birth_date" type="date" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Tempat Lahir') }} <span class="text-red-500">*</span></label>
                    <input name="birth_place" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Penghasilan/Bulan (Rp)') }} <span class="text-red-500">*</span></label>
                    <input name="monthly_income" type="number" min="0" value="0" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Pengeluaran/Bulan (Rp)') }} <span class="text-red-500">*</span></label>
                    <input name="monthly_expense" type="number" min="0" value="0" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Total Hutang (Rp)') }} <span class="text-red-500">*</span></label>
                    <input name="debt_amount" type="number" min="0" value="0" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Perkiraan Total Aset (Rp)') }} <span class="text-red-500">*</span></label>
                    <input name="asset_value" type="number" min="0" value="0" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Jumlah Tanggungan') }} <span class="text-red-500">*</span></label>
                    <input name="dependents_count" type="number" min="0" max="50" value="0" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Pekerjaan') }} <span class="text-red-500">*</span></label>
                    <input name="occupation" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Status Keluarga') }} <span class="text-red-500">*</span></label>
                    <select name="marital_status" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                        <option value="">{{ __('Pilih...') }}</option>
                        <option value="single">{{ __('Belum Menikah') }}</option>
                        <option value="married">{{ __('Menikah') }}</option>
                        <option value="divorced">{{ __('Cerai') }}</option>
                        <option value="widowed">{{ __('Duda/Janda') }}</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">{{ __('Alamat Lengkap') }} <span class="text-red-500">*</span></label>
                    <input name="address_line1" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2" placeholder="{{ __('Jalan, RT/RW, kelurahan, kecamatan') }}">
                </div>
            </div>
            <div class="rounded-xl border border-cream3/60 p-3 space-y-2">
                <div class="text-xs font-bold text-oliveDark"><i class="fa-solid fa-location-dot mr-1"></i> {{ __('Lokasi Penyaluran') }}</div>
                <label class="flex items-center gap-2 text-xs text-olive/80"><input type="radio" name="location_mode" value="existing" checked onchange="document.getElementById('locNew').classList.add('hidden');document.getElementById('locExisting').classList.remove('hidden')"> {{ __('Pakai lokasi yang ada') }}</label>
                <div id="locExisting">
                    <select name="location_id" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2">
                        <option value="">{{ __('Pilih lokasi...') }}</option>
                        @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }} — {{ $loc->typeLabel() }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex items-center gap-2 text-xs text-olive/80"><input type="radio" name="location_mode" value="new" onchange="document.getElementById('locNew').classList.remove('hidden');document.getElementById('locExisting').classList.add('hidden')"> {{ __('Buat lokasi baru sekaligus') }}</label>
                <div id="locNew" class="hidden grid sm:grid-cols-2 gap-2">
                    <div class="sm:col-span-2"><input name="new_location_name" placeholder="{{ __('Nama lokasi (mis. Masjid Al-Falah)') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2"></div>
                    <div class="sm:col-span-2"><input name="new_location_address" placeholder="{{ __('Alamat lokasi') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2"></div>
                    <div><input name="new_location_kelurahan" placeholder="{{ __('Kelurahan') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2"></div>
                    <div><input name="new_location_kecamatan" placeholder="{{ __('Kecamatan') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2"></div>
                    <div class="sm:col-span-2"><input name="new_location_phone" placeholder="{{ __('No. telepon lokasi (opsional)') }}" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2"></div>
                </div>
            </div>
<div class="flex gap-3 pt-2">
                <button class="bg-olive text-white font-semibold px-6 py-2 rounded-full text-xs hover:bg-olive2">{{ __('Simpan Warga') }}</button>
                <button type="button" onclick="document.getElementById('wargaModal').classList.add('hidden')" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2 rounded-full text-xs">{{ __('Batal') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection
