@extends('layouts.dashboard')
@section('title',__('Dashboard User — E-Zakat'))
@section('page-title')
    <span class="hidden sm:inline">{{ __('Assalamualaikum') }}, {{ auth()->user()->name }}</span>
    <span class="sm:hidden">{{ __('Assalamualaikum') }}</span>
@endsection
@section('page-sub',__('Selamat datang di E-Zakat Banjarbaru'))
@section('content')

{{-- STATUS PROFIL --}}
@if($profile?->zakat_category)
<div class="bg-olive/10 border border-olive/20 rounded-[20px] p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-id-card"></i></div>
        <div>
            <div class="text-xs text-olive/60 font-semibold">{{ __('Status Zakat Anda') }}</div>
            <div class="font-black text-oliveDark">{{ $profile->kategoriLabel() }}</div>
        </div>
    </div>
</div>
@endif

<div class="rounded-[20px] bg-gradient-to-br from-olive via-olive to-olive2 text-white p-5 lg:p-6 shadow-md relative overflow-hidden mt-4">
    <div class="absolute -right-8 -top-10 w-44 h-44 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-12 -left-6 w-36 h-36 rounded-full border-4 border-white/10"></div>
    <div class="relative flex flex-col lg:flex-row items-start lg:items-center gap-4 justify-between">
        <div>
            <div class="font-extrabold text-lg">{{ __('Tunaikan Zakat Anda') }}</div>
            <p class="text-sm text-cream/85 mt-1 max-w-lg">{{ __('Hitung zakat fitrah, maal, fidyah, dan waris dalam satu tempat; hasil perhitungan tersimpan otomatis di riwayat Anda.') }}</p>
        </div>
        <a href="{{ route('user.calculators') }}" class="bg-gold text-oliveDark font-bold px-6 py-3 rounded-full hover:brightness-105 whitespace-nowrap shadow-lg"><i class="fa-solid fa-calculator mr-2"></i> {{ __('Hitung Zakat') }}</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4 user-stats">
    <div class="stat-card sc-olive">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-building-columns"></i></div>
            <span class="sc-label">{{ __('BAZNAS') }}</span>
        </div>
        <div class="sc-num">{{ $totalBaznas }}</div>
        <div class="sc-sub">{{ __('Titik BAZNAS') }}</div>
    </div>
    <div class="stat-card sc-gold">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-mosque"></i></div>
            <span class="sc-label">{{ __('UPZ') }}</span>
        </div>
        <div class="sc-num">{{ $totalUpz }}</div>
        <div class="sc-sub">{{ __('UPZ / Masjid') }}</div>
    </div>
    <div class="stat-card sc-emerald">
        <div class="flex items-start justify-between">
            <div class="sc-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <span class="sc-label">{{ __('CATATAN') }}</span>
        </div>
        <div class="sc-num">{{ $totalRecords }}</div>
        <div class="sc-sub">{{ __('Catatan Zakat') }}</div>
    </div>
    <div class="stat-solid">
        <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white/10"></div>
        <div class="absolute right-6 bottom-2 text-white/10 text-3xl"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="flex items-center justify-between">
            <div class="sc-icon bg-white/15"><i class="fa-solid fa-wheat-awn"></i></div>
            <span class="sc-label">{{ __('HARGA') }}</span>
        </div>
        <div class="sc-num text-gold">Rp {{ number_format($beras,0,',','.') }}</div>
        <div class="sc-sub">{{ __('Beras Banjar /kg') }}</div>
    </div>
</div>

{{-- GRAFIK PRIBADI --}}
<div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 mt-4">
    <div class="flex items-center justify-between mb-4">
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-chart-line text-olive"></i> {{ __('Zakat Anda 6 Bulan Terakhir') }}
        </div>
        <a href="{{ route('user.profile') }}" class="text-xs font-semibold text-olive underline">{{ __('Lihat Catatan →') }}</a>
    </div>
    <div class="relative h-64">
        <canvas id="userZakatChart"></canvas>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    <a href="{{ route('user.calculators') }}" class="group bg-gradient-to-br from-olive to-olive2 rounded-[20px] p-5 hover:shadow-lg transition text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-calculator"></i></div>
        <div class="font-bold text-white mt-4">{{ __('Pusat Kalkulator') }}</div>
        <div class="text-sm text-cream/85 mt-1">{{ __('Fitrah, Maal, Fidyah, Penghasilan, Pertanian, Perdagangan & Waris — dengan riwayat.') }}</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">{{ __('Buka') }} <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
    <a href="{{ route('user.profile') }}" class="group bg-gradient-to-br from-gold/15 via-white to-cream2 rounded-[20px] border border-gold/30 p-5 hover:shadow-md transition shadow-sm">
        <div class="w-12 h-12 bg-gradient-to-br from-gold to-earth text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-id-card"></i></div>
        <div class="font-bold text-oliveDark mt-4">{{ __('Profil & Data Diri') }}</div>
        <div class="text-sm text-olive/60 mt-1">{{ __('Lengkapi data diri untuk kategori zakat otomatis.') }}</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">{{ __('Lihat') }} <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
    <a href="{{ route('user.histories') }}" class="group bg-gradient-to-br from-white to-cream2 rounded-[20px] border border-emerald-500/30 p-5 hover:shadow-md transition shadow-sm">
        <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <div class="font-bold text-oliveDark mt-4">{{ __('Riwayat Perhitungan') }}</div>
        <div class="text-sm text-olive/60 mt-1">{{ __('Lihat semua perhitungan yang pernah dilakukan.') }}</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-gold">{{ __('Lihat') }} <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
    </a>
</div>

<div class="rounded-[20px] bg-gradient-to-r from-olive to-olive2 text-white p-4 flex flex-col sm:flex-row items-start sm:items-center gap-3 justify-between mt-4 shadow-md">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gold/25 text-gold rounded-xl flex items-center justify-center"><i class="fa-solid fa-book-open-reader"></i></div>
        <div>
            <div class="font-bold">{{ __('Butuh bantuan?') }}</div>
            <div class="text-xs text-cream/80">{{ __('Pelajari nisab, cara hitung, dan panduan zakat & waris.') }}</div>
        </div>
    </div>
    <a href="{{ route('panduan') }}" class="bg-gold text-oliveDark font-bold px-5 py-2.5 rounded-full text-sm whitespace-nowrap shadow">{{ __('Buka Panduan →') }}</a>
</div>

@endsection

@section('scripts')
<script>
(function () {
    function boot() {
        if (typeof Chart === 'undefined') { setTimeout(boot, 100); return; }
        const canvasEl = document.getElementById('userZakatChart');
        if (!canvasEl) return;

        function getPalette(isDark) {
            if (isDark) return {
                border: '#DEB887',
                fillTop: 'rgba(222,184,135,0.35)',
                fillBottom: 'rgba(222,184,135,0.05)',
                point: '#EAB308', pointBorder: '#EAB308',
                tick: '#F5DEB3',
                grid: 'rgba(255,255,255,0.10)'
            };
            return {
                border: '#2E7D32',
                fillTop: 'rgba(46,125,50,0.30)',
                fillBottom: 'rgba(46,125,50,0.03)',
                point: '#2E7D32', pointBorder: '#2E7D32',
                tick: '#334155',
                grid: 'rgba(0,0,0,0.08)'
            };
        }

        const data = @json($chartSeries ?? []);
        const pal = getPalette(document.body.classList.contains('dark-mode'));
        let chart = null;

        function render() {
            if (chart) chart.destroy();
            chart = new Chart(canvasEl, {
                type: 'line',
                data: {
                    labels: data.map(d => d.label),
                    datasets: [{
                        label: 'Total Zakat (Rp)',
                        data: data.map(d => d.total),
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
                        borderWidth: 3,
                        pointBackgroundColor: pal.point,
                        pointBorderColor: pal.pointBorder,
                        pointBorderWidth: 1.5,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0, color: pal.tick }, grid: { color: pal.grid } },
                        x: { grid: { display: false }, ticks: { color: pal.tick } }
                    }
                }
            });
        }

        function applyTheme() {
            const next = getPalette(document.body.classList.contains('dark-mode'));
            Object.assign(pal, next);
            if (chart) {
                chart.data.datasets[0].borderColor = pal.border;
                chart.data.datasets[0].pointBackgroundColor = pal.point;
                chart.data.datasets[0].pointBorderColor = pal.pointBorder;
                chart.options.scales.y.ticks.color = pal.tick;
                chart.options.scales.y.grid.color = pal.grid;
                chart.options.scales.x.ticks.color = pal.tick;
                chart.update();
            }
        }

        render();

        // Sinkronisasi real-time: saat tema berubah tanpa refresh
        const obs = new MutationObserver(applyTheme);
        obs.observe(document.body, { attributes: true, attributeFilter: ['class'] });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
</script>
@endsection
