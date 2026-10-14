@extends('layouts.dashboard')
@section('title','Dashboard Super Admin — E-Zakat')
@section('page-title','Dashboard Super Admin')
@section('page-sub','Monitoring sistem E-Zakat Kota Banjarbaru')
@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endsection
@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @php
        $cards = [
            ['Total Admin UPZ/BAZNAS', $totalAdmins, 'fa-user-tie', 'olive', 'BAZNAS '.$totalBaznasAdmin.' • UPZ '.$totalUpz],
            ['Total User Terdaftar', $totalUsers, 'fa-users', 'earth', $activeUsers.' akun aktif'],
            ['Total Lokasi', $totalLocations, 'fa-map-location-dot', 'olive2', 'BAZNAS '.$locationsByType['baznas'].' • UPZ '.$locationsByType['upz'].' • Warga '.$locationsByType['warga']],
            ['Aktivitas Login', $loginsWeek, 'fa-clock-rotate-left', 'olive3', $loginsToday.' login hari ini'],
        ];
    @endphp
    @foreach($cards as $c)
    <div class="bg-white rounded-[20px] border border-cream3 p-4">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 bg-{{ $c[3] }}/10 text-{{ $c[3] }} rounded-xl flex items-center justify-center"><i class="fa-solid {{ $c[2] }}"></i></div>
            <i class="fa-solid fa-arrow-trend-up text-emerald-500 text-xs"></i>
        </div>
        <div class="text-3xl font-black text-oliveDark mt-3">{{ $c[1] }}</div>
        <div class="text-xs font-semibold text-oliveDark mt-1">{{ $c[0] }}</div>
        <div class="text-[11px] text-olive/50">{{ $c[4] }}</div>
    </div>
    @endforeach
</div>

{{-- Charts --}}
<div class="grid lg:grid-cols-2 gap-4 mt-4">
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-bold text-oliveDark text-sm">Aktivitas Login — 7 Hari Terakhir</div>
                <div class="text-xs text-olive/50">Jumlah login per hari</div>
            </div>
            <span class="bg-cream text-olive text-xs px-3 py-1 rounded-full font-semibold">{{ $loginsWeek }} total</span>
        </div>
        <div class="mt-4"><canvas id="loginChart" height="110"></canvas></div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-bold text-oliveDark text-sm">Komposisi Pengguna</div>
                <div class="text-xs text-olive/50">Berdasarkan role</div>
            </div>
            <span class="bg-cream text-olive text-xs px-3 py-1 rounded-full font-semibold">{{ $activeUsers }} aktif</span>
        </div>
        <div class="mt-4 flex items-center gap-4">
            <div class="w-1/2"><canvas id="roleChart" height="150"></canvas></div>
            <div class="w-1/2 space-y-2 text-xs">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-violet-500"></span> Super Admin <b class="ml-auto">{{ \App\Models\User::where('role','super_admin')->count() }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Admin BAZNAS <b class="ml-auto">{{ $totalBaznasAdmin }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Admin UPZ <b class="ml-auto">{{ $totalUpz }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-sky-500"></span> User <b class="ml-auto">{{ $totalUsers }}</b></div>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    {{-- Statistik sistem --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-chart-simple text-olive mr-2"></i> Ringkasan Sistem</div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-cream3 pb-2"><span class="text-olive/60">Total semua akun</span><b>{{ \App\Models\User::count() }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2"><span class="text-olive/60">Pernah login</span><b>{{ $everLoggedIn }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2"><span class="text-olive/60">Login hari ini</span><b>{{ $loginsToday }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2"><span class="text-olive/60">Total lokasi aktif</span><b>{{ \App\Models\Location::where('is_active',true)->count() }}</b></div>
            <div class="flex justify-between"><span class="text-olive/60">Total login tercatat</span><b>{{ \App\Models\LoginActivity::count() }}</b></div>
        </div>
    </div>

    {{-- Harga beras --}}
    <div class="bg-olive rounded-[20px] p-5 text-white">
        <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HARGA BERAS BANJAR TERKINI</div>
        <div class="text-4xl font-black mt-2">Rp {{ number_format($beras->price ?? 16000,0,',','.') }}</div>
        <div class="text-cream/70 text-xs mt-1">per kilogram</div>
        <div class="mt-4 bg-white/10 rounded-xl p-3 text-xs">
            <div><i class="fa-regular fa-clock mr-1"></i> Diperbarui: {{ $beras?->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</div>
            <div class="mt-1"><i class="fa-solid fa-user-pen mr-1"></i> Oleh: {{ $beras?->updater?->name ?? 'Sistem' }}</div>
            @if($beras?->note)<div class="mt-1 text-cream/60">"{{ $beras->note }}"</div>@endif
        </div>
        <div class="mt-4 text-xs text-cream/70">Dipakai sebagai acuan perhitungan Zakat Fitrah.</div>
    </div>

    {{-- User terbaru --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5">
        <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-user-plus text-olive mr-2"></i> Pengguna Terbaru</div>
        <div class="space-y-2">
            @foreach($latestUsers as $lu)
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($lu->name,0,1)) }}</span>
                <div class="min-w-0 flex-1">
                    <div class="text-xs font-semibold truncate">{{ $lu->name }}</div>
                    <div class="text-[10px] text-olive/50 truncate">{{ $lu->email }}</div>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full {{ $lu->role==='user' ? 'bg-sky-100 text-sky-700' : 'bg-olive/10 text-olive' }}">{{ $lu->roleLabel() }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Aktivitas terbaru --}}
<div class="bg-white rounded-[20px] border border-cream3 p-5 mt-4">
    <div class="flex items-center justify-between mb-3">
        <div class="font-bold text-oliveDark text-sm"><i class="fa-solid fa-list-check text-olive mr-2"></i> Aktivitas Login Terbaru</div>
        <a href="{{ route('super.activity') }}" class="text-xs text-olive font-semibold hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 border-b border-cream3">
                <th class="py-2 pr-3">Pengguna</th><th class="py-2 pr-3">Role</th><th class="py-2 pr-3">IP</th><th class="py-2">Waktu</th>
            </tr></thead>
            <tbody>
            @forelse($recentActivity as $a)
                <tr class="border-b border-cream2">
                    <td class="py-2 pr-3 font-medium">{{ $a->user->name ?? 'Tidak dikenal' }}</td>
                    <td class="py-2 pr-3"><span class="text-[10px] px-2 py-0.5 rounded-full bg-cream text-olive">{{ $a->user?->roleLabel() ?? '-' }}</span></td>
                    <td class="py-2 pr-3 text-xs text-olive/60">{{ $a->ip_address }}</td>
                    <td class="py-2 text-xs text-olive/60">{{ $a->logged_in_at?->translatedFormat('d M, H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-6 text-center text-olive/40 text-xs">Belum ada aktivitas login.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
const loginData = @json($loginSeries);
new Chart(document.getElementById('loginChart'), {
    type: 'line',
    data: {
        labels: loginData.map(d=>d.label),
        datasets: [{
            data: loginData.map(d=>d.count),
            borderColor: '#5A6B33', backgroundColor: 'rgba(90,107,51,0.12)',
            fill: true, tension: 0.4, pointBackgroundColor:'#5A6B33', pointRadius: 4
        }]
    },
    options: {plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, ticks:{precision:0}}}}
});

new Chart(document.getElementById('roleChart'), {
    type: 'doughnut',
    data: {
        labels: ['Super Admin','Admin BAZNAS','Admin UPZ','User'],
        datasets: [{
            data: [{{ \App\Models\User::where('role','super_admin')->count() }}, {{ $totalBaznasAdmin }}, {{ $totalUpz }}, {{ $totalUsers }}],
            backgroundColor: ['#8b5cf6','#10b981','#f97316','#0ea5e9'], borderWidth: 0
        }]
    },
    options: {plugins:{legend:{display:false}}, cutout:'65%'}
});
</script>
@endsection
