   <style>
/* ============================================================
   PENGATURAN — palet cream & emas lembut (Light + Dark)
   HANYA warna BLOK (kotak) yang diubah; teks & logo dibiarkan.
   ============================================================ */
/* --- Ikon header kartu --- */
.settings-page .info-icon {
    background: rgba(75,83,32,0.12) !important;
    border: 1px solid rgba(194,178,128,0.35) !important;
    color: #4B5320 !important;
}
body.dark-mode .settings-page .info-icon {
    background: rgba(194,178,128,0.18) !important;
    color: #F5DEB3 !important;
}
/* --- Judul section --- */
.settings-page .settings-card .text-oliveDark { color: #1e293b !important; }
body.dark-mode .settings-page .settings-card .text-oliveDark { color: #F5DEB3 !important; }
.settings-page .settings-card .text-olive\/60 { color: #475569 !important; }
body.dark-mode .settings-page .settings-card .text-olive\/60 { color: rgba(245,222,179,0.62) !important; }

/* ============================================================
   BLOK PILIHAN BAHASA & TEMA — cerah, BUKAN hijau
   Hanya latar & border blok. Teks/logo/centang tidak disentuh.
   ============================================================ */
/* BASE blok: light = putih, dark = krem hangat */
.settings-page label > input.peer ~ .ez-opt-card {
    background-color: #FFFFFF !important;
    border-color: #E2E8F0 !important;
}
body.dark-mode .settings-page label > input.peer ~ .ez-opt-card {
    background-color: #EDE2CE !important;
    border-color: rgba(194,178,128,0.55) !important;
}
/* BLOK AKTIF: lebih cerah + border tegas + bayangan */
.settings-page label > input.peer:checked ~ .ez-opt-card {
    background-color: #F5DEB3 !important;
    border-color: #4B5320 !important;
    box-shadow: 0 2px 10px rgba(75,83,32,0.18) !important;
}
body.dark-mode .settings-page label > input.peer:checked ~ .ez-opt-card {
    background-color: #F5DEB3 !important;
    border-color: #C2B280 !important;
    box-shadow: 0 2px 12px rgba(194,178,128,0.35) !important;
}

/* ============================================================
   INPUT, TOMBOL, SAKELAR (tetap)
   ============================================================ */
body.dark-mode .settings-page input[type="text"],
body.dark-mode .settings-page input[type="password"],
body.dark-mode .settings-page input[type="email"] {
    background-color: #14261C !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #f8fafc !important;
}
body.dark-mode .settings-page input[type="text"]:focus,
body.dark-mode .settings-page input[type="password"]:focus,
body.dark-mode .settings-page input[type="email"]:focus { border-color: #C2B280 !important; }
.settings-page input[type="text"], .settings-page input[type="password"], .settings-page input[type="email"] { color: #1e293b !important; }
body.dark-mode .settings-page .pw-toggle { color: rgba(245,222,179,0.7); }

.settings-page button[type="submit"], .settings-page .bg-olive {
    background: linear-gradient(135deg, #4B5320, #246c42) !important;
    color: #ffffff !important;
    box-shadow: 0 6px 16px -6px rgba(36,108,66,0.55) !important;
    font-weight: 700 !important;
}
body.dark-mode .settings-page button[type="submit"], body.dark-mode .settings-page .bg-olive {
    box-shadow: 0 8px 20px -6px rgba(194,178,128,0.35) !important;
}
/* ============================================================
   SAKELAR NOTIFIKASI — ON hijau terang, OFF redup
   ============================================================ */
/* Track OFF: light = stone-300, dark = #14261C + border putih tipis */
.settings-page .bg-cream3 { background-color: #d6d3d1 !important; }
body.dark-mode .settings-page .bg-cream3 {
    background-color: #14261C !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
}
/* Track ON: hijau terang (emerald-500) — kedua mode */
.settings-page .peer:checked ~ .peer-checked\:bg-olive,
body.dark-mode .settings-page .peer:checked ~ .peer-checked\:bg-olive {
    background-color: #22C55E !important;
}
/* Thumb: OFF = putih 80%, ON = putih bersih + bayangan */
.settings-page label > input.peer:not(:checked) ~ span[class*="bg-white"] {
    background-color: rgba(255,255,255,0.8) !important;
}
.settings-page label > input.peer:checked ~ span[class*="bg-white"] {
    background-color: #ffffff !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
}
</style>

<div class="space-y-6">  {{-- Preferensi Bahasa --}} <div class="settings-card p-6"> <div class="flex items-center gap-2.5 font-bold text-oliveDark text-sm mb-1"> <span class="info-icon"><i class="fa-solid fa-globe"></i></span> {{ __('Preferensi Bahasa') }} </div> <div class="text-xs text-olive/60 mb-5 sm:ml-11">{{ __('Pilih bahasa antarmuka situs — perubahan langsung diterapkan.') }}</div> <form method="POST" action="{{ route('settings.locale') }}"> @csrf <div class="grid grid-cols-2 sm:grid-cols-4 gap-3"> @foreach([['id', __('Indonesia'), 'ID'], ['en', __('English'), 'EN'], ['ar', __('العربية'), 'AR'], ['ms', __('Bahasa Melayu'), 'MS']] as [$code, $name, $abbr]) <label class="relative cursor-pointer group block"> <input type="radio" name="locale" value="{{ $code }}" {{ app()->getLocale() == $code ? 'checked' : '' }} class="peer sr-only"> <div class="relative h-full rounded-2xl border border-cream3 bg-white/40 ez-opt-card p-4 text-center transition-all ez-opt-card duration-200 group-hover:border-olive/50 group-hover:-translate-y-0.5 group-hover:shadow-md peer-checked:border-olive peer-checked:bg-olive/10 peer-checked:shadow-lg"> <div class="w-11 h-11 mx-auto rounded-full bg-olive/10 text-olive flex items-center justify-center text-base font-extrabold mb-2 transition-colors duration-200 group-hover:bg-olive group-hover:text-white peer-checked:bg-olive peer-checked:text-white">{{ $abbr }}</div> <div class="text-sm font-bold text-olive/80 leading-snug" {{ app()->getLocale() == $code ? '' : '' }}>{{ $name }}</div> </div> <span class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full bg-olive text-white flex items-center justify-center text-[10px] opacity-0 scale-75 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100 shadow"> <i class="fa-solid fa-check"></i> </span> </label> @endforeach </div> <div class="mt-5 flex justify-end"> <button class="bg-olive text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-sm hover:brightness-110 transition active:scale-[0.98]">{{ __('Simpan Bahasa') }}</button> </div> </form> </div> {{-- Preferensi Tema --}} <div class="settings-card p-6"> <div class="flex items-center gap-2.5 font-bold text-oliveDark text-sm mb-1"> <span class="info-icon"><i class="fa-solid fa-circle-half-stroke"></i></span> {{ __('Preferensi Tema') }} </div> <div class="text-xs text-olive/60 mb-5 sm:ml-11">{{ __('Pilih tampilan situs sesuai preferensi Anda.') }}</div> <div class="grid grid-cols-2 gap-3"> <label class="relative cursor-pointer group block"> <input type="radio" name="theme" value="light" class="peer sr-only"> <div class="relative h-full rounded-2xl border border-cream3 bg-white/40 ez-opt-card p-5 text-center transition-all ez-opt-card duration-200 group-hover:border-olive/50 group-hover:-translate-y-0.5 group-hover:shadow-md peer-checked:border-olive peer-checked:bg-olive/10 peer-checked:shadow-lg"> <div class="w-11 h-11 mx-auto rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-lg mb-2 transition-colors duration-200 group-hover:bg-amber-200 peer-checked:bg-amber-400 peer-checked:text-white"><i class="fa-solid fa-sun"></i></div> <div class="text-sm font-bold text-olive/80 leading-snug">{{ __('Light Mode') }}</div> </div> <span class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full bg-olive text-white flex items-center justify-center text-[10px] opacity-0 scale-75 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100 shadow"> <i class="fa-solid fa-check"></i> </span> </label> <label class="relative cursor-pointer group block"> <input type="radio" name="theme" value="dark" class="peer sr-only"> <div class="relative h-full rounded-2xl border border-cream3 bg-white/40 ez-opt-card p-5 text-center transition-all ez-opt-card duration-200 group-hover:border-olive/50 group-hover:-translate-y-0.5 group-hover:shadow-md peer-checked:border-olive peer-checked:bg-olive/10 peer-checked:shadow-lg"> <div class="w-11 h-11 mx-auto rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center text-lg mb-2 transition-colors duration-200 group-hover:bg-indigo-200 peer-checked:bg-indigo-500 peer-checked:text-white"><i class="fa-solid fa-moon"></i></div> <div class="text-sm font-bold text-olive/80 leading-snug">{{ __('Dark Mode') }}</div> </div> <span class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full bg-olive text-white flex items-center justify-center text-[10px] opacity-0 scale-75 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100 shadow"> <i class="fa-solid fa-check"></i> </span> </label> </div> </div> @if(auth()->user()->isAdmin()) {{-- Profil (edit nama) — khusus Admin --}} <div class="settings-card p-6"> <div class="flex items-center gap-2.5 font-bold text-oliveDark text-sm mb-1"> <span class="info-icon"><i class="fa-solid fa-user-pen"></i></span> {{ __('Profil') }} </div> <div class="text-xs text-olive/60 mb-5 sm:ml-11">{{ __('Nama tampilan akun Anda.') }}</div> <form method="POST" action="{{ route('settings.profile') }}" class="sm:ml-11"> @csrf <label class="block text-xs font-medium text-olive/70 mb-1.5">{{ __('Nama tampilan') }}</label> <input name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-xl border border-cream3 bg-white px-4 py-3 text-sm text-oliveDark outline-none focus:border-olive mb-4 max-w-md @error('name') border-red-400 @enderror"> @error('name') <p class="text-xs text-red-500 mb-3">{{ $message }}</p> @enderror <button class="bg-olive text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-sm hover:brightness-110 transition active:scale-[0.98]">{{ __('Simpan Profil') }}</button> </form> </div> @endif <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch"> {{-- Preferensi Notifikasi --}} <div class="settings-card p-6 h-full flex flex-col"> <div class="flex items-center gap-2.5 font-bold text-oliveDark text-sm mb-1"> <span class="info-icon"><i class="fa-solid fa-bell"></i></span> {{ __('Preferensi Notifikasi') }} </div> <div class="text-xs text-olive/60 mb-2 sm:ml-11">{{ __('Atur notifikasi yang ingin Anda terima.') }}</div> @php $np = auth()->user()->notification_prefs ?? []; $nW = (bool)($np['waris'] ?? true); $nZ = (bool)($np['zakat'] ?? true); $nB = (bool)($np['berita'] ?? true); @endphp <form id="notifForm" method="POST" action="{{ route('settings.notifications') }}" class="sm:ml-11 flex flex-col h-full"> @csrf <div class="divide-y divide-cream3"> <label class="flex items-start justify-between gap-4 py-4 cursor-pointer group"> <span class="pr-4 min-w-0"> <span class="block font-bold text-oliveDark text-sm">{{ __('Status Pengajuan Hitung Waris') }}</span> <span class="block text-xs text-olive/60 mt-1">{{ __('Terima notifikasi saat pengajuan waris diverifikasi atau selesai dihitung oleh admin.') }}</span> </span> <span class="relative flex-none w-11 h-6 mt-0.5"> <input type="checkbox" name="notif_waris" value="1" class="peer sr-only" {{ $nW ? 'checked' : '' }}> <span class="absolute inset-0 rounded-full bg-cream3 transition-colors duration-200 group-hover:bg-cream2 peer-checked:bg-olive"></span> <span class="absolute left-0.5 top-0.5 h-5 w-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></span> </span> </label> <label class="flex items-start justify-between gap-4 py-4 cursor-pointer group"> <span class="pr-4 min-w-0"> <span class="block font-bold text-oliveDark text-sm">{{ __('Pengingat Waktu Zakat') }}</span> <span class="block text-xs text-olive/60 mt-1">{{ __('Terima pengingat otomatis menjelang batas waktu Zakat Fitrah (Ramadhan) dan haul Zakat Maal.') }}</span> </span> <span class="relative flex-none w-11 h-6 mt-0.5"> <input type="checkbox" name="notif_zakat" value="1" class="peer sr-only" {{ $nZ ? 'checked' : '' }}> <span class="absolute inset-0 rounded-full bg-cream3 transition-colors duration-200 group-hover:bg-cream2 peer-checked:bg-olive"></span> <span class="absolute left-0.5 top-0.5 h-5 w-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></span> </span> </label> <label class="flex items-start justify-between gap-4 py-4 cursor-pointer group"> <span class="pr-4 min-w-0"> <span class="block font-bold text-oliveDark text-sm">{{ __('Pengumuman & Info BAZNAS/UPZ') }}</span> <span class="block text-xs text-olive/60 mt-1">{{ __('Terima informasi terbaru terkait jadwal penyaluran zakat dan pembaruan layanan.') }}</span> </span> <span class="relative flex-none w-11 h-6 mt-0.5"> <input type="checkbox" name="notif_berita" value="1" class="peer sr-only" {{ $nB ? 'checked' : '' }}> <span class="absolute inset-0 rounded-full bg-cream3 transition-colors duration-200 group-hover:bg-cream2 peer-checked:bg-olive"></span> <span class="absolute left-0.5 top-0.5 h-5 w-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></span> </span> </label> </div> <div class="pt-3 flex flex-col items-stretch gap-2"> <span id="notifMsg" class="text-xs font-semibold text-emerald-600 opacity-0 transition-opacity duration-300"></span> <button type="submit" class="w-full bg-olive text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-sm hover:brightness-110 transition active:scale-[0.98]">{{ __('Simpan Preferensi Notifikasi') }}</button> </div> </form> </div> {{-- Ganti Kata Sandi --}} <div class="settings-card p-6 h-full flex flex-col"> <div class="flex items-center gap-2.5 font-bold text-oliveDark text-sm mb-1"> <span class="info-icon"><i class="fa-solid fa-lock"></i></span> {{ __('Ganti Kata Sandi') }} </div> <div class="text-xs text-olive/60 mb-5 sm:ml-11">{{ __('Minimal 8 karakter, kombinasi huruf besar, huruf kecil, angka, dan simbol.') }}</div> <form method="POST" action="{{ route('settings.password') }}" class="w-full flex flex-col h-full"> @csrf <label class="block text-xs font-medium text-olive/70 mb-1.5">{{ __('Kata sandi saat ini') }}</label> <div class="flex items-center rounded-xl border border-cream3 bg-white focus-within:border-olive mb-4 @error('current_password') border-red-400 @enderror"> <input type="password" name="current_password" id="cur_pw" required autocomplete="current-password" class="flex-1 min-w-0 bg-transparent outline-none border-0 px-4 py-3 text-sm text-oliveDark"> <button type="button" onclick="togglePw('cur_pw',this)" tabindex="-1" aria-label="Tampilkan kata sandi" class="pw-toggle flex-none pl-2 pr-4 text-base leading-none"><i class="fa-solid fa-eye"></i></button> </div> @error('current_password') <p class="text-xs text-red-500 -mt-2 mb-3">{{ $message }}</p> @enderror <div class="grid grid-cols-1 gap-3 mb-4"> <div> <label class="block text-xs font-medium text-olive/70 mb-1.5">{{ __('Kata sandi baru') }}</label> <div class="flex items-center rounded-xl border border-cream3 bg-white focus-within:border-olive @error('password') border-red-400 @enderror"> <input type="password" name="password" id="new_pw" required autocomplete="new-password" class="flex-1 min-w-0 bg-transparent outline-none border-0 px-4 py-3 text-sm text-oliveDark"> <button type="button" onclick="togglePw('new_pw',this)" tabindex="-1" aria-label="Tampilkan kata sandi" class="pw-toggle flex-none pl-2 pr-4 text-base leading-none"><i class="fa-solid fa-eye"></i></button> </div> @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror </div> <div> <label class="block text-xs font-medium text-olive/70 mb-1.5">{{ __('Ulangi kata sandi baru') }}</label> <div class="flex items-center rounded-xl border border-cream3 bg-white focus-within:border-olive"> <input type="password" name="password_confirmation" id="con_pw" required autocomplete="new-password" class="flex-1 min-w-0 bg-transparent outline-none border-0 px-4 py-3 text-sm text-oliveDark"> <button type="button" onclick="togglePw('con_pw',this)" tabindex="-1" aria-label="Tampilkan kata sandi" class="pw-toggle flex-none pl-2 pr-4 text-base leading-none"><i class="fa-solid fa-eye"></i></button> </div> </div> </div> <button class="bg-olive text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-sm hover:brightness-110 transition active:scale-[0.98] mt-auto pt-2">{{ __('Simpan Kata Sandi') }}</button> </form> </div> </div> </div> <script>
(function () { var radios = document.querySelectorAll('input[name="theme"]'); if (! radios.length) return; function sync() { var dark = localStorage.getItem('theme') === 'dark'; radios.forEach(function (r) { r.checked = (r.value === 'dark') === dark; }); } sync(); radios.forEach(function (r) { r.addEventListener('change', function () { if (! r.checked) return; localStorage.setItem('theme', r.value); // Terapkan via fungsi global (sinkronkan ikon navbar + body) if (window.EZApplyTheme) { window.EZApplyTheme(r.value === 'dark'); } else { var dark = r.value === 'dark'; document.body.classList.toggle('dark-mode', dark); var icon = document.getElementById('themeIconDash'); if (icon) icon.className = dark ? 'fa-solid fa-sun text-earth' : 'fa-solid fa-moon'; } }); }); // Sinkron real-time jika tema diubah dari tempat lain (mis. toggle navbar) window.addEventListener('storage', function (e) { if (e.key === 'theme') sync(); });
})();
</script> <script>
(function () { var form = document.getElementById('notifForm'); if (! form) return; var msg = document.getElementById('notifMsg'); var token = form.querySelector('input[name="_token"]').value; var timer = null; form.addEventListener('submit', function (e) { e.preventDefault(); var fd = new FormData(); ['notif_waris', 'notif_zakat', 'notif_berita'].forEach(function (name) { var cb = form.querySelector('input[name="' + name + '"]'); if (cb && cb.checked) fd.append(name, '1'); }); fd.append('_token', token); fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(function (r) { return r.json(); }).then(function (res) { if (res && res.ok) { msg.textContent = res.message; msg.classList.remove('opacity-0'); clearTimeout(timer); timer = setTimeout(function () { msg.classList.add('opacity-0'); }, 3000); } else { msg.textContent = 'Gagal menyimpan'; msg.classList.remove('opacity-0'); } }).catch(function () { msg.textContent = 'Gagal menyimpan'; msg.classList.remove('opacity-0'); }); });
})();
</script> <script>
(function () { window.togglePw = function (id, btn) { var inp = document.getElementById(id); var icon = btn.querySelector('i'); if (inp.type === 'password') { inp.type = 'text'; icon.className = 'fa-solid fa-eye-slash'; btn.setAttribute('aria-label', 'Sembunyikan kata sandi'); } else { inp.type = 'password'; icon.className = 'fa-solid fa-eye'; btn.setAttribute('aria-label', 'Tampilkan kata sandi'); } };
})();
</script> 
