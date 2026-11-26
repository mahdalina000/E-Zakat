@php
    $u = auth()->user();
    $initials = \Illuminate\Support\Str::of($u->name)->trim()->explode(' ')->filter()
        ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('');
    if (! $initials) $initials = 'U';
    $roleMap = ['user' => 'User','admin' => 'Admin','admin_upz' => 'UPZ Admin','admin_baznas' => 'BAZNAS Admin','super_admin' => 'Super Admin'];
    $roleLabel = $roleMap[$u->role] ?? ucfirst(str_replace('_', ' ', $u->role));
    $roleIcon = match ($u->role) { 'user' => 'fa-user','super_admin' => 'fa-star','admin_baznas' => 'fa-building-columns', default => 'fa-shield-halved' };
@endphp
@php $avUrl = $u->avatarUrl(); @endphp

{{-- Kartu header profil horizontal (full width) --}}
<div class="settings-card mb-6">
    <div class="flex flex-col sm:flex-row items-center gap-5 p-6">
        <div class="relative flex-none">
            <div class="avatar-circle border-4 border-white overflow-hidden">
                <img id="avatarPreview" src="{{ $avUrl ?: 'data:,' }}" alt="{{ __('Foto profil') }}"
                     class="w-full h-full rounded-full object-cover {{ $avUrl ? '' : 'hidden' }}">
                <span id="avatarInitials" class="{{ $avUrl ? 'hidden' : '' }}">{{ $initials }}</span>
            </div>
            <label for="avatarInput" class="absolute -bottom-0.5 -right-0.5 w-8 h-8 rounded-full bg-olive text-white flex items-center justify-center shadow-md border-2 border-white cursor-pointer hover:brightness-110 transition" title="{{ __('Ubah Foto') }}">
                <i class="fa-solid fa-camera text-xs"></i>
            </label>
            <form id="avatarForm" method="POST" action="{{ route('settings.avatar') }}" enctype="multipart/form-data" class="hidden">
                @csrf
                <input id="avatarInput" name="avatar" type="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden" onchange="this.form.submit()">
            </form>
        </div>

        <div class="flex-1 min-w-0 text-center sm:text-left">
            <h1 class="text-xl font-extrabold text-oliveDark break-words">{{ $u->name }}</h1>
            <div class="mt-2.5 flex flex-wrap items-center justify-center sm:justify-start gap-x-5 gap-y-2 text-sm">
                <span class="role-badge"><i class="fa-solid {{ $roleIcon }}"></i> {{ $roleLabel }}</span>
                <span class="flex items-center gap-1.5 text-olive/70"><i class="fa-solid fa-envelope text-xs"></i><span class="break-all">{{ $u->email }}</span></span>
                <span class="flex items-center gap-1.5 text-olive/70"><i class="fa-solid fa-calendar-days text-xs"></i>{{ __('Tanggal Bergabung') }}: {{ optional($u->created_at)->format('d M Y') }}</span>
            </div>
        </div>

        <div class="flex-none flex items-center gap-2">
            <span id="avatarMsg" class="text-xs font-semibold text-emerald-600 hidden max-w-40"></span>
            <label for="avatarInput" class="text-xs font-bold bg-olive text-white px-4 py-2 rounded-full shadow-sm hover:brightness-110 transition cursor-pointer active:scale-[0.98]"><i class="fa-solid fa-pen mr-1.5"></i>{{ __('Ubah Foto') }}</label>
            @if($avUrl)
            <button type="button" onclick="event.preventDefault(); confirmDelete({ title: {{ json_encode(__('Hapus Foto Profil')) }}, message: {{ json_encode(__('Apakah Anda yakin ingin menghapus foto profil?')) }}, action: '{{ route('settings.avatar.remove') }}' })" class="text-xs font-bold bg-red-50 text-red-600 px-4 py-2 rounded-full hover:bg-red-100 transition"><i class="fa-solid fa-trash-can mr-1.5"></i>{{ __('Hapus Foto') }}</button>
            @endif
        </div>
    </div>
</div>

    {{-- Upload via form submit native (tanpa JS) — setelah submit server reload menampilkan foto di semua lingkaran avatar --}}
