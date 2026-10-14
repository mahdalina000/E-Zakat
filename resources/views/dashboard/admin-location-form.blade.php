@extends('layouts.dashboard')
@section('title',($location->exists ? 'Edit' : 'Tambah') . ' Lokasi — E-Zakat')
@section('page-title', $location->exists ? 'Edit Lokasi' : 'Tambah Lokasi Baru')
@section('page-sub','Lengkapi data lokasi penyaluran zakat')
@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ $location->exists ? route('admin.locations.update', $location) : route('admin.locations.store') }}" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 space-y-4">
        @csrf
        @if($location->exists) @method('PUT') @endif

        <div>
            <label class="text-xs font-semibold text-oliveDark">Nama Lokasi *</label>
            <input name="name" value="{{ old('name', $location->name) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. Masjid Al-Ikhlas">
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">Alamat *</label>
            <input name="address" value="{{ old('address', $location->address) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Jl. ...">
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Kelurahan *</label>
                <input name="kelurahan" value="{{ old('kelurahan', $location->kelurahan) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Kecamatan *</label>
                <input name="kecamatan" value="{{ old('kecamatan', $location->kecamatan) }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Latitude * <span class="text-olive/40 font-normal">(-90 s/d 90)</span></label>
                <input name="latitude" id="lat" value="{{ old('latitude', $location->latitude ?? '-3.4420') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Longitude * <span class="text-olive/40 font-normal">(-180 s/d 180)</span></label>
                <input name="longitude" id="lng" value="{{ old('longitude', $location->longitude ?? '114.8310') }}" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-oliveDark">Tipe Lokasi *</label>
                <select name="type" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive">
                    @php $types = ['upz'=>'UPZ / Masjid']; if(auth()->user()->isAdminBaznas()) $types = ['baznas'=>'BAZNAS','upz'=>'UPZ / Masjid','warga'=>'Rumah Warga']; @endphp
                    @foreach($types as $k=>$v)
                        <option value="{{ $k }}" @selected(old('type',$location->type)===$k)>{{ $v }}</option>
                    @endforeach
                </select>
                @if(auth()->user()->isAdminUpz())
                    <p class="text-[11px] text-olive/50 mt-1">Admin UPZ hanya dapat menambah lokasi bertipe UPZ/Masjid.</p>
                @endif
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Jam Operasional</label>
                <input name="opening_hours" value="{{ old('opening_hours', $location->opening_hours) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. 08.00–16.00 WITA">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">No. Telepon / WA</label>
            <input name="phone" value="{{ old('phone', $location->phone) }}" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="08xx-xxxx-xxxx">
        </div>

        <div>
            <label class="text-xs font-semibold text-oliveDark">Keterangan</label>
            <textarea name="description" rows="3" class="mt-1 w-full border border-cream3 rounded-2xl px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="Informasi tambahan...">{{ old('description', $location->description) }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $location->is_active ?? true)) class="accent-olive"> Lokasi aktif (tampil di peta publik)
        </label>

        <div class="flex gap-3 pt-2">
            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> {{ $location->exists ? 'Simpan Perubahan' : 'Simpan Lokasi' }}</button>
            <a href="{{ route('admin.locations.index') }}" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2.5 rounded-full hover:bg-cream3">Batal</a>
        </div>
    </form>
</div>
@endsection
