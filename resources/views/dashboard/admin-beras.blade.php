@extends('layouts.dashboard')
@section('title','Harga Beras Banjar — E-Zakat')
@section('page-title','Pengelolaan Harga Beras Banjar')
@section('page-sub','Harga ini menjadi acuan perhitungan Zakat Fitrah')
@section('content')
<div class="grid lg:grid-cols-3 gap-4">
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-olive rounded-[20px] p-5 text-white">
            <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HARGA SAAT INI</div>
            <div class="text-4xl font-black mt-2">Rp {{ number_format($current->price ?? 16000,0,',','.') }}</div>
            <div class="text-cream/70 text-xs">per kilogram Beras Banjar</div>
            <div class="mt-3 text-xs text-cream/70"><i class="fa-regular fa-clock mr-1"></i> {{ $current?->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</div>
            <div class="text-xs text-cream/70"><i class="fa-solid fa-user-pen mr-1"></i> {{ $current?->updater?->name ?? 'Sistem' }}</div>
        </div>

        <form method="POST" action="{{ route('admin.beras.update') }}" class="rounded-[20px] border border-cream3/30 p-5 space-y-4">
            @csrf
            <div class="font-bold text-oliveDark text-sm"><i class="fa-solid fa-pen-to-square text-olive mr-2"></i> Perbarui Harga</div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Harga baru (Rp / kg) *</label>
                <div class="mt-1 flex items-center border border-cream3 rounded-full px-4 py-2.5 bg-cream2">
                    <span class="text-sm text-olive">Rp</span>
                    <input name="price" type="number" min="5000" max="100000" value="{{ $current->price ?? 16000 }}" required class="w-full bg-transparent outline-none text-sm ml-2">
                </div>
                <p class="text-[11px] text-olive/50 mt-1">Valid: Rp5.000 – Rp100.000 per kg.</p>
            </div>
            <div>
                <label class="text-xs font-semibold text-oliveDark">Catatan perubahan</label>
                <input name="note" class="mt-1 w-full border border-cream3 rounded-full px-4 py-2.5 text-sm bg-cream2 outline-none focus:border-olive" placeholder="mis. Penyesuaian harga pasar">
            </div>
            <button class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive2"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Harga Baru</button>
            <p class="text-[11px] text-olive/50"><i class="fa-solid fa-circle-info mr-1"></i> Setiap perubahan dicatat dalam riwayat.</p>
        </form>
    </div>

    <div class="lg:col-span-2">
        class="rounded-[20px] border border-cream3/30 p-5 lg:p-6 space-y-4"
            <div class="font-bold text-oliveDark text-sm mb-3"><i class="fa-solid fa-clock-rotate-left text-olive mr-2"></i> Riwayat Perubahan Harga</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-xs text-olive/50 border-b border-cream3">
                        <th class="py-2 pr-3">Harga</th><th class="py-2 pr-3">Catatan</th><th class="py-2 pr-3">Diubah oleh</th><th class="py-2">Waktu</th>
                    </tr></thead>
                    <tbody>
                    @forelse($history as $h)
                        <tr class="border-b border-cream2">
                            <td class="py-2.5 pr-3 font-bold text-olive">Rp {{ number_format($h->price,0,',','.') }}</td>
                            <td class="py-2.5 pr-3 text-xs text-olive/70">{{ $h->note }}</td>
                            <td class="py-2.5 pr-3 text-xs">{{ $h->updater->name ?? 'Sistem' }}</td>
                            <td class="py-2.5 text-xs text-olive/50">{{ $h->created_at->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-8 text-center text-olive/40 text-xs">Belum ada riwayat perubahan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $history->links() }}</div>
        </div>
    </div>
</div>
@endsection
