@extends('layouts.dashboard')
@section('title','Pengaturan Lembaga — E-Zakat')
@section('page-title','Pengaturan Profil Lembaga')
@section('page-sub','Atur informasi profil ' . ($u->isAdminBaznas() ? 'BAZNAS' : 'UPZ') . ' Anda')
@section('content')
<div class="max-w-3xl">
    @if(session('success'))
        <div class="mb-4 rounded-[20px] border border-emerald-200 bg-emerald-50 text-emerald-700 px-5 py-3 text-sm font-medium">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="rounded-[20px] border border-cream3/30 p-5 lg:p-6 space-y-4">
        @csrf
        @method('PUT')

        <input type="hidden" name="institution_type" value="{{ $profile->institution_type }}">

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Nama Lembaga *</label>
                <input name="institution_name" value="{{ old('institution_name', $profile->institution_name) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. UPZ Masjid Al-Falah">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Alias / Singkatan</label>
                <input name="alias" value="{{ old('alias', $profile->alias) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. UPZ Al-Falah">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">Alamat Lembaga</label>
            <textarea name="address" rows="2" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Alamat lengkap...">{{ old('address', $profile->address) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">No. Telepon / WA</label>
                <input name="phone" value="{{ old('phone', $profile->phone) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="08xx-xxxx-xxxx">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Email Publik</label>
                <input name="public_email" type="email" value="{{ old('public_email', $profile->public_email) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="lembaga@contoh.id">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Website</label>
                <input name="website" type="url" value="{{ old('website', $profile->website) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="https://...">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">Deskripsi / Profil Singkat</label>
            <textarea name="description" rows="4" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Profil singkat lembaga...">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="border-t border-cream3/50 pt-4">
            <div class="text-xs font-bold text-oliveDark mb-3 flex items-center gap-2"><i class="fa-solid fa-lock"></i> Ganti Password Akun</div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Password Lama</label>
                    <input name="current_password" type="password" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="••••••••">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Password Baru</label>
                    <input name="new_password" type="password" minlength="8" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Ulangi Password Baru</label>
                    <input name="new_password_confirmation" type="password" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Ulangi password baru">
                </div>
            </div>
            <p class="text-[10px] text-olive/60 mt-2">Kosongkan ketiganya jika tidak ingin mengganti password.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pengaturan</button>
            <a href="{{ route('admin.baznas') }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">Kembali</a>
        </div>
    </form>
</div>
@endsection
