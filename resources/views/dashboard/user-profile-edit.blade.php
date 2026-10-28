@extends('layouts.dashboard')
@section('title','Edit Data Diri — E-Zakat')
@section('page-title','Edit Data Diri — ' . auth()->user()->name)
@section('page-sub','Lengkapi data diri Anda untuk kategori zakat otomatis')
@section('content')

@php
    $profile = auth()->user()->wargaProfile;
    $profile = $profile ?: auth()->user()->wargaProfile()->first();
@endphp

<div class="max-w-3xl">
    <form method="POST" action="{{ route('user.profile.update') }}" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 space-y-4">
        @csrf @method('PUT')

        <p class="text-[10px] text-olive/50 -mt-2">Tanda <span class="text-red-500">*</span> wajib diisi. Sisanya opsional.</p>

        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-olive"></i> Identitas
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> NIK</label>
                <input name="nik" value="{{ old('nik', $profile->nik ?? '') }}" maxlength="16" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="16 digit NIK">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Jenis Kelamin</label>
                <select name="gender" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
                    <option value="">Pilih...</option>
                    <option value="male" @selected(old('gender', $profile->gender) === 'male')>Laki-laki</option>
                    <option value="female" @selected(old('gender', $profile->gender) === 'female')>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Tanggal Lahir</label>
                <input name="birth_date" type="date" value="{{ old('birth_date', $profile->birth_date?->format('Y-m-d')) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Tempat Lahir</label>
                <input name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. Banjarbaru">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Status Keluarga</label>
                <input type="hidden" name="marital_status" value="{{ old('marital_status', $profile->marital_status) }}">
                <select data-marital required onchange="this.previousElementSibling.value=this.value" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
                    <option value="" @selected(blank(old('marital_status', $profile->marital_status))) hidden>Pilih Status Keluarga</option>
                    <option value="single" @selected(old('marital_status', $profile->marital_status) === 'single')>Belum Menikah</option>
                    <option value="married" @selected(old('marital_status', $profile->marital_status) === 'married')>Menikah</option>
                    <option value="divorced" @selected(old('marital_status', $profile->marital_status) === 'divorced')>Cerai</option>
                    <option value="widowed" @selected(old('marital_status', $profile->marital_status) === 'widowed')>Duda/Janda</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Pekerjaan</label>
                <input name="occupation" value="{{ old('occupation', $profile->occupation ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. Petani, Karyawan, Wiraswasta">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> No. Telepon</label>
                <input name="phone" value="{{ old('phone', $profile->phone ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="08xx-xxxx-xxxx">
            </div>
        </div>

        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-people-group text-olive"></i> Tanggungan & Ekonomi
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Jumlah Tanggungan</label>
                <input name="dependents_count" type="number" min="0" max="50" value="{{ old('dependents_count', $profile->dependents_count ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Penghasilan Bulanan (Rp)</label>
                <input name="monthly_income" type="number" step="0.01" min="0" value="{{ old('monthly_income', $profile->monthly_income ?? '') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="0">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Pengeluaran Bulanan (Rp)</label>
                <input name="monthly_expense" type="number" step="0.01" min="0" value="{{ old('monthly_expense', $profile->monthly_expense ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="0">
                <p class="text-[10px] text-olive/50 mt-0.5">Isi 0 jika tidak ada pengeluaran rutin.</p>
            </div>
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Total Hutang (Rp)</label>
            <input name="debt_amount" type="number" step="0.01" min="0" value="{{ old('debt_amount', $profile->debt_amount ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="0">
            <p class="text-[10px] text-olive/50 mt-0.5">Isi 0 jika tidak punya hutang.</p>
        </div>

        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-landmark text-olive"></i> Aset & Harta
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Perkiraan Total Aset (Rp)</label>
            <input name="asset_value" type="number" step="0.01" min="0" value="{{ old('asset_value', $profile->asset_value ?? 0) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="0">
            <p class="text-[10px] text-olive/50 mt-0.5">Gabungan kas, emas, investasi, properti, kendaraan. Isi 0 jika tidak ada. Boleh dikosongkan rinciannya di bawah.</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Kas / Tabungan (Rp)</label>
                <input name="cash_value" type="number" step="0.01" min="0" value="{{ old('cash_value', $profile->cash_value ?? '') }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Emas (Rp)</label>
                <input name="gold_value" type="number" step="0.01" min="0" value="{{ old('gold_value', $profile->gold_value ?? '') }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
        </div>
        <div>
            <label class="text-xs font-semibold text-oliveDark">Kendaraan (Rp)</label>
            <input name="vehicle_value" type="number" step="0.01" min="0" value="{{ old('vehicle_value', $profile->vehicle_value ?? '') }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
        </div>

        <div class="font-bold text-oliveDark text-sm flex items-center gap-2 mt-4">
            <i class="fa-solid fa-house text-olive"></i> Alamat
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark"><span class="text-red-500">*</span> Alamat Lengkap</label>
            <textarea name="address_line1" rows="3" required maxlength="255" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Jalan, no. rumah, RT/RW, kelurahan, kecamatan">{{ old('address_line1', $profile->address_line1 ?? '') }}</textarea>
            <p class="text-[10px] text-olive/50 mt-0.5">Tulis lengkap dalam satu kolom: jalan, no. rumah, RT/RW, kelurahan, kecamatan.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
            <a href="{{ route('user.profile') }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">Batal</a>
        </div>
    </form>
</div>
@endsection
