@extends('layouts.dashboard')
@section('title', __('Edit Warga — E-Zakat'))
@section('page-title', __('Edit Data Warga') . ' — ' . $user->name)
@section('page-sub', __('Perbarui data profil dan kategori zakat warga'))
@section('content')

<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.warga.update', $user) }}" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 space-y-4">
        @csrf @method('PUT')

        <p class="text-[10px] text-olive/50 -mt-2">{{ __('Tanda') }} <span class="text-red-500">*</span> {{ __('wajib diisi. Sisanya opsional.') }}</p>

        {{-- IDENTITAS --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-id-card text-olive"></i> {{ __('Identitas') }}
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Nama Lengkap') }}</label>
                <input name="name" value="{{ $user->name }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
                <p class="text-[10px] text-olive/50 mt-0.5">{{ __('Nama akun login warga') }}</p>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('NIK') }}</label>
                <input name="nik" value="{{ old('nik', $profile->nik ?? '') }}" maxlength="16" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Jenis Kelamin') }}</label>
                <select name="gender" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
                    <option value="">{{ __('Pilih...') }}</option>
                    <option value="male" @selected(old('gender', $profile->gender) === 'male')>{{ __('Laki-laki') }}</option>
                    <option value="female" @selected(old('gender', $profile->gender) === 'female')>{{ __('Perempuan') }}</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Tanggal Lahir') }}</label>
                <input name="birth_date" type="date" value="{{ old('birth_date', $profile->birth_date?->format('Y-m-d')) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Tempat Lahir') }}</label>
                <input name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Status Keluarga') }}</label>
                <input type="hidden" name="marital_status" value="{{ old('marital_status', $profile->marital_status) }}">
                <select data-marital required onchange="this.previousElementSibling.value=this.value" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
                    <option value="" @selected(blank(old('marital_status', $profile->marital_status))) hidden>{{ __('Pilih Status Keluarga') }}</option>
                    <option value="single" @selected(old('marital_status', $profile->marital_status) === 'single')>{{ __('Belum Menikah') }}</option>
                    <option value="married" @selected(old('marital_status', $profile->marital_status) === 'married')>{{ __('Menikah') }}</option>
                    <option value="divorced" @selected(old('marital_status', $profile->marital_status) === 'divorced')>{{ __('Cerai') }}</option>
                    <option value="widowed" @selected(old('marital_status', $profile->marital_status) === 'widowed')>{{ __('Duda/Janda') }}</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Pekerjaan') }}</label>
                <input name="occupation" value="{{ old('occupation', $profile->occupation ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
        </div>

        {{-- EKONOMI --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-sack-dollar text-olive"></i> {{ __('Ekonomi & Tanggungan') }}
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Jumlah Tanggungan') }}</label>
                <input name="dependents_count" type="number" min="0" max="50" value="{{ old('dependents_count', $profile->dependents_count ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Penghasilan Bulanan (Rp)') }}</label>
                <input name="monthly_income" type="number" step="0.01" min="0" value="{{ old('monthly_income', $profile->monthly_income ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Total Hutang (Rp)') }}</label>
                <input name="debt_amount" type="number" step="0.01" min="0" value="{{ old('debt_amount', $profile->debt_amount ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Perkiraan Total Aset (Rp)') }}</label>
                <input name="asset_value" type="number" step="0.01" min="0" value="{{ old('asset_value', $profile->asset_value ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Pengeluaran Bulanan (Rp)') }}</label>
                <input name="monthly_expense" type="number" step="0.01" min="0" value="{{ old('monthly_expense', $profile->monthly_expense ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
        </div>

        {{-- ALAMAT --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-location-dot text-olive"></i> {{ __('Alamat') }}
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> {{ __('Alamat Lengkap') }}</label>
            <textarea name="address_line1" rows="3" required maxlength="255" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2">{{ old('address_line1', $profile->address_line1 ?? '') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> {{ __('Simpan Perubahan') }}</button>
            <a href="{{ route('admin.warga.show', $user) }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">{{ __('Batal') }}</a>
        </div>
    </form>
</div>
@endsection
