# Ringkasan Kalkulator E-Zakat
Dokumen pendamping untuk presentasi/mentor. Satu halaman.

## Konsep dasar (dipakai semua kalkulator)
- **Nisab** = batas minimal harta. Di bawah nisab → belum wajib.
- **Haul** = harta sudah digenggam 1 tahun hijriah.
- **Tarif** = persentase yang dikeluarkan (umumnya **2,5%**).
Semua keluaran: **status (wajib/belum)** + **jumlah zakat**, dan bisa **disimpan ke riwayat** (tabel `calculation_histories`, input & hasil disimpan sebagai JSON + snapshot harga beras/emas).

## 7 kalkulator

### 1. Zakat Fitrah
Zakat per jiwa menjelang Idul Fitri.
`Jiwa × 2,5 kg beras`.
Contoh: 4 jiwa, beras Rp16.000/kg → 10 kg → **Rp160.000**.

### 2. Zakat Maal (Harta)
Zakat harta/tabungan yang sudah haul 1 tahun.
`Harta ≥ nisab(85 gr emas) & haul → Harta × 2,5%`.
Contoh: harta Rp200.000.000, emas Rp1.300.000/gr → nisab Rp110.500.000 → wajib → **Rp5.000.000**.

### 3. Fidyah
Ganti puasa yang ditinggalkan (untuk yang tidak mampu puasa).
`Hari × harga 1 porsi`. Setara beras: hari × 0,75 kg.
Contoh: 7 hari × Rp45.000 → **Rp315.000** (≈ 5,25 kg beras).

### 4. Zakat Penghasilan *(baru)*
Zakat gaji/penghasilan bulanan.
`Penghasilan ≥ Rp2.500.000/bulan → 2,5% tiap bulan`.
Contoh: gaji Rp10.000.000 → **Rp250.000/bulan**, Rp3.000.000/tahun.

### 5. Zakat Pertanian *(baru)*
Zakat hasil panen.
- Dengan irigasi: nisab 1.000 kg, zakat **5%**.
- Tanpa irigasi: nisab 653 kg, zakat **10%**.
Contoh: panen 2.000 kg irigasi → **100 kg**.

### 6. Zakat Perdagangan/Perniagaan *(baru)*
Untuk pedagang.
`Total = Modal + Piutang + Persediaan − Utang`
`Total ≥ nisab(85 gr emas) & haul → Total × 2,5%`.
Contoh: modal 200 jt + piutang 30 jt + persediaan 50 jt − utang 20 jt = 260 jt → **Rp6.500.000**.

### 7. Waris / Faraidh
Pembagian harta warisan menurut hukum Islam. Dua kelompok ahli waris:
- **Dzurrin (porsi tetap dari dalil):** Suami 1/2 (tanpa anak) / 1/4 (ada anak); Istri 1/4 / 1/8; Ayah 1/6; Ibu 1/3 (tidak ada saudara&anak) / 1/6 (ada).
- **Ashabah (sisa):** umumnya anak. Laki = 2 bagian, perempuan = 1 bagian.
- **Aul (normalisasi):** jika jumlah porsi > 1, semua dinormalkan (tashib).
Sistem menghitung otomatis dengan basis fraksi 24, lalu output per ahli waris: nama, persentase, nilai rupiah.

## Arsitektur (kualifikasi teknis)
- Hitung 3 zakat baru + waris → **server** (PHP service `ZakatCalculator` & `WarisCalculator`), lewat endpoint `POST /user/calculators/{type}/calculate` (JSON real-time) & `saveCalculation` (simpan).
- Fitrah/Maal/Fidyah → client-side (JS di halaman) — hitungannya sederhana.
- Riwayat: tabel `calculation_histories`, kolom `calc_type` (enum 7 jenis), `input_data` & `result_data` (JSON), `beras_price`/`gold_price` (snapshot harga).

## Status
- Logika hitung 7 kalkulator: **siap & teruji (uji HTTP/DB)**.
- 3 kalkulator baru: belum diuji klik browser (tombol Simpan).
- Masih proses: pengaturan profil admin UPZ/BAZNAS; UPZ tambah warga + lokasi sekaligus.
