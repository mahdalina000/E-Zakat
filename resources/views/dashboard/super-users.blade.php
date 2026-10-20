@extends('layouts.dashboard')
@section('title','Manajemen User — E-Zakat')
@section('page-title','Manajemen Pengguna')
@section('page-sub','Seluruh akun terdaftar dalam sistem')
@section('content')
<div class="flex flex-wrap items-center gap-2 mb-4">
    @php
        $tabs = ['all'=>'Semua','super_admin'=>'Super Admin','admin_baznas'=>'Admin BAZNAS','admin_upz'=>'Admin UPZ','user'=>'User'];
    @endphp
    @foreach($tabs as $k=>$v)
        <a href="{{ route('super.users', array_filter(['role'=>$k==='all'?null:$k,'q'=>$q])) }}"
           class="px-4 py-2 rounded-full text-xs font-semibold {{ ($role===$k || ($k==='all' && !$role)) ? 'bg-olive text-white' : 'border border-cream3 text-olive' }}">
            {{ $v }} <span class="opacity-60">({{ $counts[$k] }})</span>
        </a>
    @endforeach
    <form method="GET" class="ml-auto flex items-center border border-cream3 rounded-full px-3">
        <i class="fa-solid fa-magnifying-glass text-olive/40 text-xs"></i>
        <input name="q" value="{{ $q }}" placeholder="Cari nama/email..." class="text-xs px-2 py-2 outline-none bg-transparent w-40">
        @if($role) <input type="hidden" name="role" value="{{ $role }}"> @endif
    </form>
</div>

<div class="rounded-[20px] border border-cream3/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Login Terakhir</th><th class="px-4 py-3">Terdaftar</th>
            </tr></thead>
            <tbody>
            @forelse($users as $usr)
                @php $rc = ['super_admin'=>'bg-violet-100 text-violet-700','admin_baznas'=>'bg-emerald-100 text-emerald-700','admin_upz'=>'bg-orange-100 text-orange-700','user'=>'bg-sky-100 text-sky-700']; @endphp
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($usr->name,0,1)) }}</span>
                            <div><div class="font-semibold">{{ $usr->name }}</div><div class="text-[11px] text-olive/50">{{ $usr->email }}</div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full {{ $rc[$usr->role] ?? 'bg-gray-100' }}">{{ $usr->roleLabel() }}</span></td>
                    <td class="px-4 py-3"><span class="text-[11px] {{ $usr->is_active ? 'text-emerald-600' : 'text-gray-400' }}"><i class="fa-solid fa-circle text-[7px] mr-1"></i>{{ $usr->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="px-4 py-3 text-xs text-olive/60">{{ $usr->last_login_at?->translatedFormat('d M Y, H:i') ?? 'Belum pernah' }}</td>
                    <td class="px-4 py-3 text-xs text-olive/60">{{ $usr->created_at->translatedFormat('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">Tidak ada pengguna ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
