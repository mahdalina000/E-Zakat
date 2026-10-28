@extends('layouts.dashboard')
@section('title','Edit Warga — E-Zakat')
@section('page-title','Edit Data Warga — ' . $user->name)
@section('page-sub','Perbarui data profil dan kategori zakat warga')
@section('content')

<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.warga.update', $user) }}" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 space-y-4">
        @csrf @method('PUT')

        <p class="text-[10px] text-olive/50 -mt-2">Tanda <span class="text-red-500">*</span> wajib diisi. Sisanya opsional.</p>

        {{-- IDENTITAS --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-id-card text-olive"></i> Identitas
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Nama Lengkap</label>
                <input name="name" value="{{ $user->name }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
                <p class="text-[10px] text-olive/50 mt-0.5">Nama akun login warga</p>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> NIK</label>
                <input name="nik" value="{{ old('nik', $profile->nik ?? '') }}" maxlength="16" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Jenis Kelamin</label>
                <select name="gender" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
                    <option value="">Pilih...</option>
                    <option value="male" @selected(old('gender', $profile->gender) === 'male')>Laki-laki</option>
                    <option value="female" @selected(old('gender', $profile->gender) === 'female')>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Tanggal Lahir</label>
                <input name="birth_date" type="date" value="{{ old('birth_date', $profile->birth_date?->format('Y-m-d')) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Tempat Lahir</label>
                <input name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Status Keluarga</label>
                <input type="hidden" name="marital_status" value="{{ old('marital_status', $profile->marital_status) }}">
                <select data-marital required onchange="this.previousElementSibling.value=this.value" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
                    <option value="" @selected(blank(old('marital_status', $profile->marital_status))) hidden>Pilih Status Keluarga</option>
                    <option value="single" @selected(old('marital_status', $profile->marital_status) === 'single')>Belum Menikah</option>
                    <option value="married" @selected(old('marital_status', $profile->marital_status) === 'married')>Menikah</option>
                    <option value="divorced" @selected(old('marital_status', $profile->marital_status) === 'divorced')>Cerai</option>
                    <option value="widowed" @selected(old('marital_status', $profile->marital_status) === 'widowed')>Duda/Janda</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Pekerjaan</label>
                <input name="occupation" value="{{ old('occupation', $profile->occupation ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
        </div>

        {{-- EKONOMI --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-sack-dollar text-olive"></i> Ekonomi & Tanggungan
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Jumlah Tanggungan</label>
                <input name="dependents_count" type="number" min="0" max="50" value="{{ old('dependents_count', $profile->dependents_count ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Penghasilan Bulanan (Rp)</label>
                <input name="monthly_income" type="number" step="0.01" min="0" value="{{ old('monthly_income', $profile->monthly_income ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Total Hutang (Rp)</label>
                <input name="debt_amount" type="number" step="0.01" min="0" value="{{ old('debt_amount', $profile->debt_amount ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Perkiraan Total Aset (Rp)</label>
                <input name="asset_value" type="number" step="0.01" min="0" value="{{ old('asset_value', $profile->asset_value ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Pengeluaran Bulanan (Rp)</label>
                <input name="monthly_expense" type="number" step="0.01" min="0" value="{{ old('monthly_expense', $profile->monthly_expense ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2">
            </div>
        </div>

        {{-- ALAMAT --}}
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-location-dot text-olive"></i> Alamat
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Alamat Lengkap</label>
            <textarea name="address_line1" rows="3" required maxlength="255" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2">{{ old('address_line1', $profile->address_line1 ?? '') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.warga.show', $user) }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">Batal</a>
        </div>
    </form>
</div>
@endsection
