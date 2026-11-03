@extends('layouts.dashboard')
@section('title','Profil Warga — E-Zakat')
@section('page-title','Profil & Data Diri — ' . auth()->user()->name)
@section('page-sub','Kelola data diri, kategori zakat, dan catatan perhitungan')
@section('content')

@php
    $profile = auth()->user()->wargaProfile;
@endphp

{{-- CARD DATA DIRI --}}
<div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-id-card text-olive"></i> Data Diri
        </div>
        <a href="{{ route('user.profile.edit') }}" class="bg-olive text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-olive2">
            <i class="fa-solid fa-pen mr-1"></i> Edit Data
        </a>
    </div>

    @if($profile)
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">NIK</div><div class="font-bold text-oliveDark">{{ $profile->nik ?? '-' }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Jenis Kelamin</div><div class="font-bold text-oliveDark">{{ $profile->genderLabel() }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Tanggal Lahir</div><div class="font-bold text-oliveDark">{{ $profile->birth_date?->translatedFormat('d M Y') ?? '-' }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Status Pernikahan</div><div class="font-bold text-oliveDark">{{ $profile->statusPernikahanLabel() }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Pekerjaan</div><div class="font-bold text-oliveDark">{{ $profile->occupation ?? '-' }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Tanggungan</div><div class="font-bold text-oliveDark">{{ $profile->dependents_count ?? 0 }} jiwa</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Penghasilan/Bulan</div><div class="font-bold text-oliveDark">Rp {{ number_format($profile->monthly_income ?? 0, 0, ',', '.') }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Total Hutang</div><div class="font-bold text-oliveDark">Rp {{ number_format($profile->debt_amount ?? 0, 0, ',', '.') }}</div></div>
        <div class="bg-cream2 rounded-xl p-3"><div class="text-olive/60">Total Aset</div><div class="font-bold text-oliveDark">Rp {{ number_format($profile->totalAsset(), 0, ',', '.') }}</div></div>
        <div class="bg-cream2 rounded-xl p-3 col-span-full"><div class="text-olive/60">Alamat</div><div class="font-bold text-oliveDark">{{ $profile->address_line1 ?: '-' }}</div></div>
    </div>
    @else
    <div class="text-center py-8">
        <div class="text-olive/40 text-sm mb-3">Data diri belum diisi.</div>
        <a href="{{ route('user.profile.edit') }}" class="bg-olive text-white text-xs font-semibold px-4 py-2 rounded-full">Isi Data Diri Sekarang</a>
    </div>
    @endif
</div>

{{-- CARD KATEGORI ZAKAT --}}
<div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 mt-4">
    <div class="font-bold text-oliveDark text-sm mb-3 flex items-center gap-2">
        <i class="fa-solid fa-scale-balanced text-olive"></i> Kategori Zakat
    </div>
    @if($profile?->zakat_category)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="bg-olive/10 rounded-xl p-4">
            <div class="text-xs font-bold text-olive uppercase tracking-wider">Status Zakat</div>
            <div class="text-lg font-black text-oliveDark mt-1">{{ $profile->kategoriLabel() }}</div>
            @if($profile->zakat_category_reason)
            <div class="text-xs text-olive/70 mt-1">Alasan: {{ $profile->zakat_category_reason }}</div>
            @endif
        </div>
        <div class="bg-cream2 rounded-xl p-4">
            <div class="text-xs font-bold text-olive uppercase tracking-wider">Pengaturan</div>
            <p class="text-xs text-olive/60 mt-1 leading-relaxed">Kategori ditentukan otomatis berdasarkan penghasilan, tanggungan, dan hutang. Edit data di atas untuk memperbarui status.</p>
        </div>
    </div>
    @else
    <div class="text-center py-6 text-olive/40 text-sm">Kategori belum ditentukan. Isi data diri lengkap terlebih dahulu.</div>
    @endif

    <div class="mt-4 bg-cream2 rounded-xl p-4 text-xs text-oliveDark">
        <div class="font-bold text-oliveDark uppercase tracking-wider text-xs mb-2">Cara Menghitung Kategori</div>
        <ol class="list-decimal list-inside space-y-1.5 leading-relaxed text-oliveDark">
            <li>Hitung <b class="text-oliveDark">kebutuhan pokok keluarga</b> = Rp1.500.000 × jumlah tanggungan (minimal 1).</li>
            <li>Punya <b class="text-oliveDark">hutang</b> dan penghasilan ≤ kebutuhan pokok → <b class="text-oliveDark">Gharimin</b>.</li>
            <li><b class="text-oliveDark">Tanpa penghasilan &amp; tanpa harta</b> → <b class="text-oliveDark">Fakir</b>.</li>
            <li>Penghasilan <b class="text-oliveDark">≤ kebutuhan pokok</b> → <b class="text-oliveDark">Miskin</b>.</li>
            <li>Penghasilan <b class="text-oliveDark">≥ Rp5.000.000</b> &amp; total aset <b class="text-oliveDark">≥ Rp10.000.000</b> → <b class="text-oliveDark">Pemberi Zakat</b>.</li>
            <li>Selain itu → <b class="text-oliveDark">Netral</b>.</li>
        </ol>
        <div class="mt-2.5 pt-2.5 border-t border-cream3 text-oliveDark">
            Data yang dipakai: penghasilan/bulan, tanggungan, hutang, dan total aset. Edit data diri untuk memperbarui status.
        </div>
    </div>
</div>

{{-- CARD CATATAN ZAKAT --}}
<div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6 mt-4">
    <div class="flex items-center justify-between mb-4">
        <div class="font-bold text-oliveDark text-sm flex items-center gap-2">
            <i class="fa-solid fa-clipboard-list text-olive"></i> Catatan Zakat
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('recordModal').classList.remove('hidden')" class="bg-olive text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-olive2">
                <i class="fa-solid fa-plus mr-1"></i> Tambah
            </button>
            <button onclick="location.href='{{ route('user.export') }}'" class="bg-cream border border-cream3 text-olive text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-cream3">
                <i class="fa-solid fa-file-excel mr-1"></i> Export
            </button>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-3 mb-3">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-olive/40 text-xs pointer-events-none"></i>
            <input type="text" id="recordSearch" placeholder="Cari catatan…" style="padding-left:2.25rem"
                class="w-full border border-cream3 rounded-full pr-4 py-2 text-xs bg-cream2 outline-none focus:border-olive">
        </div>
        <select id="recordTypeFilter" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none focus:border-olive">
            <option value="">Semua Jenis</option>
            <option value="zakat_fitrah">Zakat Fitrah</option>
            <option value="zakat_maal">Zakat Maal</option>
            <option value="fidyah">Fidyah</option>
            <option value="infak_sedekah">Infak & Sedekah</option>
            <option value="wariq">Waris (Wariq)</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 border-b border-cream3">
                <th class="py-2 pr-3">Jenis</th><th class="py-2 pr-3">Jumlah</th>
                <th class="py-2 pr-3">Total (Rp)</th><th class="py-2 pr-3">Tanggal</th>
                <th class="py-2 pr-3">Metode</th><th class="py-2 pr-3">Keterangan</th>
                <th class="py-2 text-right">Aksi</th>
            </tr></thead>
            <tbody id="recordsTableBody">
            @forelse($records as $r)
                <tr class="border-b border-cream2 hover:bg-cream2/50" data-type="{{ $r->zakat_type }}" data-search="{{ strtolower($r->zakatTypeLabel().' '.$r->paymentMethodLabel().' '.($r->notes ?? '').' '.($r->payment_date?->format('d M Y') ?? '')) }}">
                    <td class="py-2.5 pr-3"><span class="text-[11px] px-2 py-0.5 rounded-full bg-olive/10 text-olive font-semibold">{{ $r->zakatTypeLabel() }}</span></td>
                    <td class="py-2.5 pr-3 text-xs">{{ $r->jiwa_count }} jiwa @if($r->beras_kg) • {{ $r->beras_kg }} kg beras @endif</td>
                    <td class="py-2.5 pr-3 font-bold text-oliveDark">Rp {{ number_format($r->total_amount ?? 0, 0, ',', '.') }}</td>
                    <td class="py-2.5 pr-3 text-xs text-olive/60">{{ $r->payment_date?->translatedFormat('d M Y') ?? ($r->due_date?->translatedFormat('d M Y') ?? '-') }}</td>
                    <td class="py-2.5 pr-3 text-xs">{{ $r->paymentMethodLabel() }}</td>
                    <td class="py-2.5 pr-3 text-xs text-olive/70">{{ Str::limit($r->notes, 40) }}</td>
                    <td class="py-2.5 text-right">
                        <form method="POST" action="{{ route('user.records.destroy', $r) }}" onsubmit="return confirm('Hapus catatan ini?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 text-xs"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="py-8 text-center text-olive/40">Belum ada catatan zakat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH CATATAN --}}
<div id="recordModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-5 w-full max-w-lg max-h-[90vh] overflow-auto">
        <h3 class="font-bold text-oliveDark text-sm mb-3">Tambah Catatan Zakat</h3>
        @error('jumlah')
            <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2 mb-3">{{ $message }}</div>
        @enderror
        <form method="POST" action="{{ route('user.records.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-xs font-semibold text-oliveDark">Jenis Zakat *</label>
                <select name="zakat_type" required class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none">
                    <option value="zakat_fitrah">Zakat Fitrah</option>
                    <option value="zakat_maal">Zakat Maal</option>
                    <option value="fidyah">Fidyah</option>
                    <option value="infak_sedekah">Infak & Sedekah</option>
                    <option value="wariq">Waris (Wariq)</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Jumlah Jiwa</label>
                    <input name="jiwa_count" type="number" min="1" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none">
                </div>
                <div>
                    <label class="text-xs font-semibold text-oliveDark">Beras (kg)</label>
                    <input name="beras_kg" type="number" step="0.01" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none">
                </div>
            </div>

            {{-- TOTAL NILAI (RP) DENGAN FORMAT TITIK RIBUAN --}}
            <div>
                <label class="text-xs font-semibold text-oliveDark">Total Nilai (Rp)</label>
                <input type="text" 
                       id="total_amount_formatted" 
                       placeholder="0" 
                       class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none" 
                       oninput="formatRupiahDirect(this)">
                <input type="hidden" name="total_amount" id="total_amount">
            </div>

            <div class="grid grid-cols-2 gap-3">
                {{-- TANGGAL BAYAR TANPA IKON (POLOS DENGAN TRIGGER CLICK) --}}
                <div>
                    <label class="text-xs font-semibold text-oliveDark block mb-1">Tanggal Bayar</label>
                    <input name="payment_date" 
                           type="date" 
                           onclick="this.showPicker()" 
                           class="no-calendar-icon w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none cursor-pointer text-oliveDark">
                </div>

                <div>
                    <label class="text-xs font-semibold text-oliveDark block mb-1">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none">
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="beras_fisik">Beras Fisik</option>
                        <option value="makanan">Makanan</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">No. Referensi</label>
                <input name="reference_number" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2 text-xs bg-cream2 outline-none" placeholder="mis. No. transfer">
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Keterangan</label>
                <textarea name="notes" rows="2" class="mt-1 w-full border border-cream3 rounded-xl px-4 py-2 text-xs bg-cream2 outline-none" placeholder="mis. Zakat fitrah keluarga, 4 jiwa × 2.5 kg"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button class="bg-olive text-white font-semibold px-6 py-2 rounded-full text-xs hover:bg-olive2">Simpan Catatan</button>
                <button type="button" onclick="document.getElementById('recordModal').classList.add('hidden')" class="bg-cream border border-cream3 text-olive font-semibold px-6 py-2 rounded-full text-xs">Batal</button>
            </div>
        </form>
    </div>
</div>

<div class="grid sm:grid-cols-2 gap-3 mt-4">
    <a href="{{ route('user.waris') }}" class="bg-olive/10 border border-olive/20 rounded-xl p-3 text-center hover:bg-olive/20 transition">
        <i class="fa-solid fa-scale-balanced text-olive text-lg"></i>
        <div class="text-xs font-bold text-oliveDark mt-1">Kalkulator Waris</div>
    </a>
    <a href="{{ route('user.histories') }}" class="bg-cream2 border border-cream3 rounded-xl p-3 text-center hover:bg-cream3 transition">
        <i class="fa-solid fa-clock-rotate-left text-olive text-lg"></i>
        <div class="text-xs font-bold text-oliveDark mt-1">Riwayat Perhitungan</div>
    </a>
</div>

{{-- CSS KHUSUS UNTUK MENGHAPUS SEMUA IKON KALENDER BAWAAN --}}
<style>
input[type="date"].no-calendar-icon::-webkit-calendar-picker-indicator,
input[type="date"].no-calendar-icon::-webkit-inner-spin-button,
input[type="date"].no-calendar-icon::-webkit-clear-button {
    display: none !important;
    -webkit-appearance: none !important;
}
</style>

{{-- SCRIPT FORMAT TERPISAH --}}
<script>
function formatRupiahDirect(el) {
    let val = el.value.replace(/[^0-9]/g, '');
    let hiddenInput = document.getElementById('total_amount');
    if (hiddenInput) {
        hiddenInput.value = val;
    }
    if (val) {
        el.value = new Intl.NumberFormat('id-ID').format(val);
    } else {
        el.value = '';
    }
}
</script>
@endsection

@section('scripts')
<script>
    (function () {
        const search = document.getElementById('recordSearch');
        const filter = document.getElementById('recordTypeFilter');
        const tbody = document.getElementById('recordsTableBody');
        const rows = tbody ? Array.from(tbody.querySelectorAll('tr')) : [];
        const emptyRow = tbody && tbody.querySelector('tr[colspan]') ? tbody.querySelector('tr[colspan]') : null;

        function apply() {
            const q = (search.value || '').trim().toLowerCase();
            const type = filter.value;
            let visible = 0;
            rows.forEach(function (row) {
                if (row === emptyRow) return;
                const mType = row.dataset.type || '';
                const mSearch = row.dataset.search || '';
                const okType = !type || mType === type;
                const okSearch = !q || mSearch.indexOf(q) !== -1;
                const show = okType && okSearch;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (emptyRow) {
                emptyRow.style.display = visible === 0 ? '' : 'none';
            }
        }

        if (search) search.addEventListener('input', apply);
        if (filter) filter.addEventListener('change', apply);
    })();
</script>
@endsection