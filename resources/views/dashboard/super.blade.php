@extends('layouts.dashboard')
@section('title', __('Dashboard Super Admin — E-Zakat'))
@section('page-title', __('Dashboard Super Admin'))
@section('page-sub', __('Monitoring sistem E-Zakat Kota Banjarbaru'))
@section('head')
{{-- Chart.js sudah di-bundle Vite di resources/js/app.js --}}
@endsection
<style>
@keyframes hermSpinOnce { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.role-spin { animation: hermSpinOnce 1.8s ease-in-out 1; }
</style>
@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @php
        $cards = [
            ['Total Admin UPZ/BAZNAS', $totalAdmins, 'fa-user-tie', 'olive', 'BAZNAS '.$totalBaznasAdmin.' • UPZ '.$totalUpz],
            ['Total User Terdaftar', $totalUsers, 'fa-users', 'gold', $activeUsers.' akun aktif'],
            ['Total Lokasi', $totalLocations, 'fa-map-location-dot', 'sky', 'BAZNAS '.$locationsByType['baznas'].' • UPZ '.$locationsByType['upz'].' • Warga '.$locationsByType['warga']],
            ['Aktivitas Login', $loginsWeek, 'fa-clock-rotate-left', 'rose', $loginsToday.' login hari ini'],
        ];
    @endphp
    @foreach($cards as $c)
    <div class="stat-card sc-{{ $c[3] }}">
        <div class="flex items-center justify-between">
            <div class="sc-icon"><i class="fa-solid {{ $c[2] }}"></i></div>
            <i class="fa-solid fa-arrow-trend-up text-gold text-xs"></i>
        </div>
        <div class="sc-num">{{ $c[1] }}</div>
        <div class="sc-sub">{{ $c[0] }}</div>
        <div class="sc-foot">{{ $c[4] }}</div>
    </div>
@endforeach
</div>

{{-- Charts --}}
<div class="grid lg:grid-cols-2 gap-4 mt-4">
    <div class="rounded-[20px] border border-cream3/30 p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-bold text-oliveDark text-sm">{{ __('Aktivitas Login — 7 Hari Terakhir') }}</div>
                <div class="text-xs text-olive/50">{{ __('Jumlah login per hari') }}</div>
            </div>
            <span class="bg-cream text-olive text-xs px-3 py-1 rounded-full font-semibold">{{ $loginsWeek }} {{ __('total') }}</span>
        </div>
        <div class="mt-4"><canvas id="loginChart" height="110"></canvas></div>
    </div>
    <div class="rounded-[20px] border border-cream3/30 p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-bold text-oliveDark text-sm">{{ __('Komposisi Pengguna') }}</div>
                <div class="text-xs text-olive/50">{{ __('Berdasarkan role') }}</div>
            </div>
            <span class="bg-cream text-olive text-xs px-3 py-1 rounded-full font-semibold">{{ $activeUsers }} {{ __('aktif') }}</span>
        </div>
        <div class="mt-4 flex items-center gap-4">
            <div class="w-1/2">
                <div class="role-spin rounded-full overflow-hidden aspect-square mx-auto max-w-[190px]">
                    <canvas id="roleChart" height="150"></canvas>
                </div>
            </div>
            <div class="w-1/2 space-y-2 text-xs">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-violet-500"></span> {{ __('Super Admin') }} <b class="ml-auto">{{ \App\Models\User::where('role','super_admin')->count() }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> {{ __('Admin BAZNAS') }} <b class="ml-auto">{{ $totalBaznasAdmin }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-500"></span> {{ __('Admin UPZ') }} <b class="ml-auto">{{ $totalUpz }}</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-sky-500"></span> {{ __('User') }} <b class="ml-auto">{{ $totalUsers }}</b></div>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    {{-- Statistik sistem --}}
    <div class="rounded-[20px] border border-cream3/30 p-5">
        <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-chart-simple text-olive mr-2"></i> {{ __('Ringkasan Sistem') }}</div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-cream3 pb-2 sys-row"><span class="text-olive/60">{{ __('Total semua akun') }}</span><b>{{ \App\Models\User::count() }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2 sys-row"><span class="text-olive/60">{{ __('Pernah login') }}</span><b>{{ $everLoggedIn }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2 sys-row"><span class="text-olive/60">{{ __('Login hari ini') }}</span><b>{{ $loginsToday }}</b></div>
            <div class="flex justify-between border-b border-cream3 pb-2 sys-row"><span class="text-olive/60">{{ __('Total lokasi aktif') }}</span><b>{{ \App\Models\Location::where('is_active',true)->count() }}</b></div>
            <div class="flex justify-between sys-row"><span class="text-olive/60">{{ __('Total login tercatat') }}</span><b>{{ \App\Models\LoginActivity::count() }}</b></div>
        </div>
    </div>

    {{-- Harga beras --}}
    <div class="bg-olive rounded-[20px] p-5 text-white">
        <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">{{ __('HARGA BERAS BANJAR TERKINI') }}</div>
        <div class="text-4xl font-black mt-2">Rp {{ number_format($beras->price ?? 16000,0,',','.') }}</div>
        <div class="text-cream/70 text-xs mt-1">{{ __('per kilogram') }}</div>
        <div class="mt-4 bg-white/10 rounded-xl p-3 text-xs">
            <div><i class="fa-regular fa-clock mr-1"></i> {{ __('Diperbarui:') }} {{ $beras?->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</div>
            <div class="mt-1"><i class="fa-solid fa-user-pen mr-1"></i> {{ __('Oleh:') }} {{ $beras?->updater?->name ?? 'Sistem' }}</div>
            @if($beras?->note)<div class="mt-1 text-cream/60">"{{ $beras->note }}"</div>@endif
        </div>
        <div class="mt-4 text-xs text-cream/70">{{ __('Dipakai sebagai acuan perhitungan Zakat Fitrah.') }}</div>
    </div>

    {{-- User terbaru --}}
    <div class="rounded-[20px] border border-cream3/30 p-5">
        <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-user-plus text-olive mr-2"></i> {{ __('Pengguna Terbaru') }}</div>
        <div class="space-y-2">
            @foreach($latestUsers as $lu)
            <div class="flex items-center gap-3 user-row">
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
<div class="rounded-[20px] border border-cream3/30 p-5 mt-4">
    <div class="flex items-center justify-between mb-3">
        <div class="font-bold text-oliveDark text-sm"><i class="fa-solid fa-list-check text-olive mr-2"></i> {{ __('Aktivitas Login Terbaru') }}</div>
        <a href="{{ route('super.activity') }}" class="text-xs text-olive font-semibold hover:underline">{{ __('Lihat semua →') }}</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 border-b border-cream3">
                <th class="py-2 pr-3">{{ __('Pengguna') }}</th><th class="py-2 pr-3">{{ __('Role') }}</th><th class="py-2 pr-3">{{ __('IP') }}</th><th class="py-2">{{ __('Waktu') }}</th>
            </tr></thead>
            <tbody>
            @forelse($recentActivity as $a)
                <tr class="border-b border-cream2">
                    <td class="py-2 pr-3 font-medium">{{ $a->user->name ?? __('Tidak dikenal') }}</td>
                    <td class="py-2 pr-3"><span class="text-[10px] px-2 py-0.5 rounded-full bg-cream text-olive">{{ $a->user?->roleLabel() ?? '-' }}</span></td>
                    <td class="py-2 pr-3 text-xs text-olive/60">{{ $a->ip_address }}</td>
                    <td class="py-2 text-xs text-olive/60">{{ $a->logged_in_at?->translatedFormat('d M, H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-6 text-center text-olive/40 text-xs">{{ __('Belum ada aktivitas login.') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
(function () {
    function getPalette(isDark) {
        if (isDark) return {
            border: '#DEB887', fillTop: 'rgba(222,184,135,0.35)', fillBottom: 'rgba(222,184,135,0.05)',
            point: '#EAB308', tick: '#F5DEB3', grid: 'rgba(255,255,255,0.10)',
            sliceBorder: 'rgba(255,255,255,0.30)'
        };
        return {
            border: '#2E7D32', fillTop: 'rgba(46,125,50,0.30)', fillBottom: 'rgba(46,125,50,0.03)',
            point: '#2E7D32', tick: '#334155', grid: 'rgba(0,0,0,0.08)',
            sliceBorder: 'rgba(0,0,0,0.12)'
        };
    }

    const pal = getPalette(document.body.classList.contains('dark-mode'));
    let loginChart = null, roleChart = null;
    const loginData = @json($loginSeries);
    const roleLabels = ['Super Admin', 'Admin BAZNAS', 'Admin UPZ', 'User'];
    const roleValues = [
        {{ \App\Models\User::where('role','super_admin')->count() }},
        {{ $totalBaznasAdmin }},
        {{ $totalUpz }},
        {{ $totalUsers }}
    ];
    const roleColors = ['#e2c57f', '#6f9e7c', '#bf975f', '#87a7ab'];

    function renderLogin() {
        const canvas = document.getElementById('loginChart');
        if (!canvas) return;
        if (loginChart) loginChart.destroy();
        loginChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: loginData.map(d => d.label),
                datasets: [{
                    data: loginData.map(d => d.count),
                    borderColor: pal.border,
                    backgroundColor: function (ctx) {
                        const a = ctx.chart.chartArea;
                        if (!a) return pal.fillBottom;
                        const g = ctx.chart.ctx.createLinearGradient(0, a.top, 0, a.bottom);
                        g.addColorStop(0, pal.fillTop);
                        g.addColorStop(1, pal.fillBottom);
                        return g;
                    },
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: pal.point,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0, color: pal.tick }, grid: { color: pal.grid } },
                    x: { grid: { display: false }, ticks: { color: pal.tick } }
                },
                animation: { duration: 2000, easing: 'easeOutQuart' }
            }
        });
    }

    function renderRole() {
        const canvas = document.getElementById('roleChart');
        if (!canvas) return;
        if (roleChart) roleChart.destroy();
        roleChart = new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleValues,
                    backgroundColor: roleColors,
                    borderColor: pal.sliceBorder,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: { legend: { display: false } },
                animation: { animateRotate: true, animateScale: true, duration: 2500, easing: 'easeOutQuart' },
                animations: {
                    numbers: {
                        type: 'number',
                        properties: ['circumference', 'endAngle', 'startAngle', 'outerRadius', 'innerRadius']
                    }
                }
            }
        });
    }

    function applyTheme() {
        const dark = document.body.classList.contains('dark-mode');
        const next = getPalette(dark);
        Object.assign(pal, next);
        if (loginChart) {
            loginChart.data.datasets[0].borderColor = pal.border;
            loginChart.data.datasets[0].pointBackgroundColor = pal.point;
            loginChart.options.scales.y.ticks.color = pal.tick;
            loginChart.options.scales.y.grid.color = pal.grid;
            loginChart.options.scales.x.ticks.color = pal.tick;
            loginChart.update();
        }
        if (roleChart) {
            roleChart.data.datasets[0].borderColor = pal.sliceBorder;
            roleChart.update();
        }
    }

    function initCharts() {
        renderLogin();
        renderRole();
        // Sinkronisasi real-time: saat tema berubah tanpa refresh
        const obs = new MutationObserver(applyTheme);
        obs.observe(document.body, { attributes: true, attributeFilter: ['class'] });
    }

    function boot() {
        if (typeof Chart === 'undefined') { setTimeout(boot, 100); return; }
        initCharts();
    }

    // Tunggu DOM siap, lalu render saat grafik masuk layar
    document.addEventListener('DOMContentLoaded', function () {
        const target = document.getElementById('roleChart');
        if (!target) { boot(); return; }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    boot();
                    observer.disconnect();
                }
            });
        }, { threshold: 0.2 });
        observer.observe(target);
    });
})();
</script>
@endsection