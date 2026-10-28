# Folder Audio Hadis E-Zakat

Letakkan file MP3 di sini dengan nama sesuai:

    h01.mp3   (hadis ke-1: "Islam dibangun di atas lima perkara...")
    h02.mp3
    ...
    h20.mp3   (hadis ke-20)

Setiap MP3 sebaiknya berisi:
  1. Bacaan ARAB hadis (oleh qari'/suara natural)
  2. Jeda singkat
  3. Bacaan ARTINYA dalam bahasa Indonesia

Jika file h01.mp3 sampai h20.mp3 semua ada, tombol suara hadis di halaman
welcome akan memutar audio asli (natural).

Jika file TIDAK ada, sistem otomatis FALLBACK ke Web Speech API
(suara robotik bawaan browser) sehingga tombol tetap berfungsi.

Catatan:
- Format: MP3 (AAC juga bisa), durasi bebas (maks ~30 detik ideal)
- Setelah menambah file, lakukan hard reload (Ctrl+Shift+R)
- File di folder ini otomatis di-cache oleh service worker (sw.js)
