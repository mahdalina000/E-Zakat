@extends('layouts.dashboard')
@section('title','Aktivitas Login — E-Zakat')
@section('page-title','Aktivitas Login')
@section('page-sub','Riwayat aktivitas login seluruh pengguna')
@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-3xl font-black text-oliveDark">{{ $total }}</div>
        <div class="text-xs font-semibold text-oliveDark">Total Login Tercatat</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-3xl font-black text-oliveDark">{{ \App\Models\LoginActivity::whereDate('logged_in_at',today())->count() }}</div>
        <div class="text-xs font-semibold text-oliveDark">Login Hari Ini</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-3xl font-black text-oliveDark">{{ \App\Models\LoginActivity::where('logged_in_at','>=',now()->subDays(7))->count() }}</div>
        <div class="text-xs font-semibold text-oliveDark">7 Hari Terakhir</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="text-3xl font-black text-oliveDark">{{ \App\Models\LoginActivity::distinct('user_id')->count('user_id') }}</div>
        <div class="text-xs font-semibold text-oliveDark">Pengguna Unik</div>
    </div>
</div>

<div class="bg-white rounded-[20px] border border-cream3 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">#</th><th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">IP Address</th><th class="px-4 py-3">Perangkat</th><th class="px-4 py-3">Waktu</th>
            </tr></thead>
            <tbody>
            @forelse($activities as $a)
                <tr class="border-t border-cream2 hover:bg-cream2/50">
                    <td class="px-4 py-3 text-xs text-olive/40">{{ $a->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $a->user->name ?? 'Tidak dikenal' }}</td>
                    <td class="px-4 py-3"><span class="text-[11px] px-2 py-0.5 rounded-full bg-cream text-olive">{{ $a->user?->roleLabel() ?? '-' }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $a->ip_address }}</td>
                    <td class="px-4 py-3 text-xs text-olive/50 max-w-[220px] truncate">{{ Str::limit($a->user_agent, 45) }}</td>
                    <td class="px-4 py-3 text-xs text-olive/60">{{ $a->logged_in_at?->translatedFormat('d M Y, H:i:s') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-olive/40">Belum ada aktivitas login.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $activities->links() }}</div>
@endsection
