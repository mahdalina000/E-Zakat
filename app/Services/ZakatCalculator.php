<?php

namespace App\Services;

/**
 * Kalkulator zakat: penghasilan, pertanian, perdagangan/perniagaan.
 * Tarif mengikuti pedoman umum BAZNAS.
 */
class ZakatCalculator
{
    /**
     * Zakat penghasilan — 2,5% dari penghasilan bulanan (bila mencapai nisab 2,5 jt/bulan).
     *
     * @param float $penghasilanBulan
     */
    public function penghasilan(float $penghasilanBulan): array
    {
        $nisab = 2_500_000;
        $wajib = $penghasilanBulan >= $nisab;
        $zakat = $wajib ? round($penghasilanBulan * 0.025, 0) : 0;
        $zakatTahunan = $zakat * 12;

        return [
            'wajib' => $wajib,
            'zakat_bulanan' => $zakat,
            'zakat_tahunan' => $zakatTahunan,
            'nisab' => $nisab,
            'keterangan' => $wajib
                ? 'Penghasilan Anda di atas nisab Rp2.500.000/bulan. Zakat penghasilan 2,5% dari penghasilan setiap bulan.'
                : 'Penghasilan Anda di bawah nisab Rp2.500.000/bulan, sehingga belum wajib zakat penghasilan.',
        ];
    }

    /**
     * Zakat pertanian — 5% (dengan irigasi) atau 10% (tanpa irigasi) dari hasil panen.
     *
     * @param float $hasilPanenKg hasil panen (kg)
     * @param bool  $denganIrigasi
     */
    public function pertanian(float $hasilPanenKg, bool $denganIrigasi = true): array
    {
        $nisab = $denganIrigasi ? 1_000 : 653; // kg
        $tarif = $denganIrigasi ? 0.05 : 0.10;
        $wajib = $hasilPanenKg >= $nisab;
        $zakat = $wajib ? round($hasilPanenKg * $tarif, 0) : 0;

        return [
            'wajib' => $wajib,
            'zakat' => $zakat,
            'nisab' => $nisab,
            'tarif' => $tarif,
            'keterangan' => $wajib
                ? ($denganIrigasi
                    ? 'Panen dengan irigasi: nisab 1.000 kg, zakat 5% dari hasil panen.'
                    : 'Panen tanpa irigasi: nisab 653 kg, zakat 10% dari hasil panen.')
                : 'Hasil panen di bawah nisab, belum wajib zakat pertanian.',
        ];
    }

    /**
     * Zakat perdagangan/perniagaan — 2,5% dari total harta perniagaan,
     * bila mencapai nisab 85 gr emas & haul 1 tahun.
     *
     * Total harta = modal + piutang + persediaan − utang.
     *
     * @param float $modal
     * @param float $piutang
     * @param float $persediaan
     * @param float $utang
     * @param float $hargaEmas  harga emas per gram
     * @param bool  $sudahHaul
     */
    public function perdagangan(
        float $modal,
        float $piutang,
        float $persediaan,
        float $utang,
        float $hargaEmas,
        bool $sudahHaul = true
    ): array {
        $totalHarta = max(0, $modal + $piutang + $persediaan - $utang);
        $nisab = 85 * $hargaEmas;
        $wajib = $totalHarta >= $nisab && $sudahHaul;
        $zakat = $wajib ? round($totalHarta * 0.025, 0) : 0;

        return [
            'wajib' => $wajib,
            'zakat' => $zakat,
            'total_harta' => $totalHarta,
            'nisab' => $nisab,
            'keterangan' => $wajib
                ? 'Harta perniagaan mencapai nisab 85 gr emas & haul 1 tahun. Zakat 2,5% dari total harta.'
                : ($sudahHaul
                    ? 'Harta perniagaan belum mencapai nisab 85 gr emas, belum wajib.'
                    : 'Harta sudah mencapai nisab, tetapi haul 1 tahun belum genap.'),
        ];
    }
}
