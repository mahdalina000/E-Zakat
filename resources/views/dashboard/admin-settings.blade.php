@extends('layouts.dashboard')
@section('title', __('Pengaturan Lembaga — E-Zakat'))
@section('page-title', __('Pengaturan Profil Lembaga'))
@section('page-sub', __('Atur informasi profil') . ' ' . ($u->isAdminBaznas() ? 'BAZNAS' : 'UPZ') . ' ' . __('Anda'))
@section('content')
<div class="settings-page p-5 lg:p-8 w-full">
    {{-- Kartu header profil (foto, nama, email, tanggal) --}}
    @include('settings.partials.profile-header')

    <form method="POST" action="{{ route('admin.settings.update') }}" class="settings-card p-6 space-y-5">
        @csrf
        @method('PUT')

        <input type="hidden" name="institution_type" value="{{ $profile->institution_type }}">

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Nama Lembaga') }} *</label>
                <input name="institution_name" value="{{ old('institution_name', $profile->institution_name) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('mis. UPZ Masjid Al-Falah') }}">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Alias / Singkatan') }}</label>
                <input name="alias" value="{{ old('alias', $profile->alias) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('mis. UPZ Al-Falah') }}">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Alamat Lembaga') }}</label>
            <textarea name="address" rows="2" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('Alamat lengkap...') }}">{{ old('address', $profile->address) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('No. Telepon / WA') }}</label>
                <input name="phone" value="{{ old('phone', $profile->phone) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('08xx-xxxx-xxxx') }}">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Email Publik') }}</label>
                <input name="public_email" type="email" value="{{ old('public_email', $profile->public_email) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('lembaga@contoh.id') }}">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">{{ __('Website') }}</label>
                <input name="website" type="url" value="{{ old('website', $profile->website) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('https://...') }}">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">{{ __('Deskripsi / Profil Singkat') }}</label>
            <textarea name="description" rows="4" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-white border-cream3/80 outline-none focus:border-olive" placeholder="{{ __('Profil singkat lembaga...') }}">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> {{ __('Simpan Pengaturan') }}</button>
            <a href="{{ route('admin.baznas') }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">{{ __('Kembali') }}</a>
        </div>
    </form>

    <div class="mt-6">
        @include('settings.partials.account-options')
    </div>
</div>
@endsection
