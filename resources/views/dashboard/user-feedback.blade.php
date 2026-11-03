@extends('layouts.dashboard')
@section('title','Kritik & Saran — E-Zakat')
@section('page-title','Kritik & Saran')
@section('page-sub','Berikan masukan untuk perbaikan E-Zakat')
@section('content')

@if(session('success'))
    <div class="mb-4 bg-olive/10 border border-olive/30 text-oliveDark text-xs px-4 py-3 rounded-xl">{{ session('success') }}</div>
@endif

<div class="grid lg:grid-cols-2 gap-4">
    {{-- FORM KIRIM --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
        <div class="font-bold text-oliveDark text-sm mb-4 flex items-center gap-2">
            <i class="fa-solid fa-comment-dots text-olive"></i> Kirim Masukan
        </div>

        <form method="POST" action="{{ route('user.feedback.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-oliveDark block mb-1">Kategori *</label>
                <select name="category" class="w-full border border-cream3 rounded-full px-4 py-2.5 text-xs bg-cream2 outline-none focus:border-olive">
                    <option value="saran" @selected(old('category','saran')==='saran')>Saran</option>
                    <option value="kritik" @selected(old('category')==='kritik')>Kritik</option>
                    <option value="pertanyaan" @selected(old('category')==='pertanyaan')>Pertanyaan</option>
                    <option value="lainnya" @selected(old('category')==='lainnya')>Lainnya</option>
                </select>
                @error('category') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark block mb-1">Subjek (opsional)</label>
                <input name="subject" value="{{ old('subject') }}" maxlength="150" placeholder="mis. Saran tampilan dashboard"
                    class="w-full border border-cream3 rounded-full px-4 py-2.5 text-xs bg-cream2 outline-none focus:border-olive">
                @error('subject') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-oliveDark block mb-1">Pesan Anda *</label>
                <textarea name="message" rows="4" maxlength="2000" required placeholder="Tulis kritik atau saran Anda…"
                    class="w-full border border-cream3 rounded-xl px-4 py-3 text-xs bg-cream2 outline-none focus:border-olive">{{ old('message') }}</textarea>
                @error('message') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button class="bg-olive text-white font-semibold px-6 py-2.5 rounded-full text-xs hover:bg-olive2 transition">
                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Masukan
            </button>
        </form>
    </div>

    {{-- RIWAYAT MASUKAN --}}
    <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
        <div class="font-bold text-oliveDark text-sm mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-olive"></i> Riwayat Masukan Anda
        </div>

        @forelse($feedbacks as $fb)
            <div class="flex items-start justify-between gap-3 py-3 border-b border-cream2 last:border-0">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-olive/10 text-olive font-semibold">{{ $fb->categoryLabel() }}</span>
                        @if($fb->subject)
                            <span class="text-xs font-bold text-oliveDark truncate">{{ $fb->subject }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-olive/70 mt-1.5 leading-relaxed break-words">{{ $fb->message }}</p>
                    <div class="text-[10px] text-olive/40 mt-1">{{ $fb->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
                <form method="POST" action="{{ route('user.feedback.destroy', $fb) }}" onsubmit="return confirm('Hapus masukan ini?')">
                    @csrf @method('DELETE')
                    <button class="w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 text-xs"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        @empty
            <div class="text-center py-10 text-olive/40 text-sm">Belum ada masukan yang Anda kirim.</div>
        @endforelse

        <div class="mt-4">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>

@endsection
