<?php

namespace App\Services\Waris;

/**
 * Kalkulator Waris (Faraidh) sesuai kaidah Ahli Sunnah.
 *
 * Urutan kerja:
 * 1. Hitung harta bersih = harta − hutang − biaya pemakaman − wasiat (maks 1/3).
 * 2. Terapkan hijab (penghalang) untuk menentukan ahli waris yang berhak.
 * 3. Tetapkan bagian tetap (furud) masing-masing ahli waris.
 * 4. Berikan sisa harta kepada ashabah (penerima sisa) dengan rasio 2:1.
 * 5. Tangani 'aul (total > 1) dengan menormalkan porsi secara proporsional.
 * 6. Tangani radd (total < 1 tanpa ashabah) dengan mengembalikan sisa
 *    kepada ahli waris selain pasangan secara proporsional.
 * 7. Bagi harta bersih sesuai porsi akhir.
 */
class WarisCalculator
{
    public function hitung(
        float $totalHarta,
        string $pewarisJk,
        bool $adaIstri = false,
        bool $adaSuami = false,
        int $jumlahAnakL = 0,
        int $jumlahAnakP = 0,
        bool $adaAyah = false,
        bool $adaIbu = false,
        int $jumlahSaudaraL = 0,
        int $jumlahSaudaraP = 0,
        int $jumlahSaudaraSeibu = 0,
        int $jumlahCucuL = 0,
        int $jumlahCucuP = 0,
        bool $adaKakek = false,
        bool $adaNenekIbu = false,
        bool $adaNenekAyah = false,
        float $hutang = 0,
        float $wasiat = 0,
        float $biayaPemakaman = 0
    ): array {
        $keterangan = [];

        // ===== 1. Harta bersih =====
        $hutang = max(0, $hutang);
        $biayaPemakaman = max(0, $biayaPemakaman);
        $wasiatDiminta = max(0, $wasiat);
        $batasWasiat = $totalHarta / 3;
        $wasiat = min($wasiatDiminta, $batasWasiat);

        $hartaBersih = max(0, $totalHarta - $hutang - $biayaPemakaman - $wasiat);

        if ($hutang > 0 || $biayaPemakaman > 0 || $wasiat > 0) {
            $keterangan[] = 'Harta bersih Rp ' . $this->rupiah($hartaBersih)
                . ' = harta Rp ' . $this->rupiah($totalHarta)
                . ' − hutang Rp ' . $this->rupiah($hutang)
                . ' − biaya pemakaman Rp ' . $this->rupiah($biayaPemakaman)
                . ' − wasiat Rp ' . $this->rupiah($wasiat);
            if ($wasiatDiminta > $batasWasiat) {
                $keterangan[] = 'Wasiat dibatasi maksimal 1/3 harta (Rp ' . $this->rupiah($batasWasiat) . ').';
            }
        }

        // ===== 2. Hijab (penghalang) =====
        $anakL = max(0, $jumlahAnakL);
        $anakP = max(0, $jumlahAnakP);
        $cucuL = max(0, $jumlahCucuL);
        $cucuP = max(0, $jumlahCucuP);

        $adaAnak = ($anakL + $anakP) > 0;
        $adaCucu = !$adaAnak && ($cucuL + $cucuP) > 0;
        $adaKeturunan = $adaAnak || $adaCucu;

        $sdrL = max(0, $jumlahSaudaraL);
        $sdrP = max(0, $jumlahSaudaraP);
        $sdrSeibu = max(0, $jumlahSaudaraSeibu);

        $kakekAktif = $adaKakek && !$adaAyah;
        $nenekAktif = ($adaNenekIbu || $adaNenekAyah) && !$adaIbu;

        // Saudara terhalang oleh keturunan, ayah, atau kakek
        $saudaraTerhalang = $adaKeturunan || $adaAyah || $kakekAktif;
        $sdrKandungL = $saudaraTerhalang ? 0 : $sdrL;
        $sdrKandungP = $saudaraTerhalang ? 0 : $sdrP;
        $sdrSeibuAktif = $saudaraTerhalang ? 0 : $sdrSeibu;

        $jumlahSaudaraAktif = $sdrKandungL + $sdrKandungP + $sdrSeibuAktif;

        // ===== 3. Bagian tetap (furud) =====
        $furud = [];
        $adaPasangan = false;
        $porsiPasangan = 0.0;

        if ($pewarisJk === 'L' && $adaIstri) {
            $porsi = $adaKeturunan ? 1 / 8 : 1 / 4;
            $furud[] = ['label' => 'Istri', 'share' => $porsi];
            $keterangan[] = 'Istri: ' . ($adaKeturunan ? '1/8' : '1/4') . ($adaKeturunan ? ' (ada keturunan)' : ' (tidak ada keturunan)') . '.';
            $adaPasangan = true;
            $porsiPasangan = $porsi;
        }

        if ($pewarisJk === 'P' && $adaSuami) {
            $porsi = $adaKeturunan ? 1 / 4 : 1 / 2;
            $furud[] = ['label' => 'Suami', 'share' => $porsi];
            $keterangan[] = 'Suami: ' . ($adaKeturunan ? '1/4' : '1/2') . ($adaKeturunan ? ' (ada keturunan)' : ' (tidak ada keturunan)') . '.';
            $adaPasangan = true;
            $porsiPasangan = $porsi;
        }

        // Ibu — termasuk kasus umariyyatain (pasangan + ayah + ibu)
        if ($adaIbu) {
            $umariyyatain = $adaPasangan && $adaAyah && !$adaKeturunan && $jumlahSaudaraAktif === 0;
            if ($umariyyatain) {
                $porsi = (1 - $porsiPasangan) / 3;
                $keterangan[] = 'Ibu: 1/3 dari sisa setelah bagian pasangan (kasus umariyyatain).';
            } elseif ($adaKeturunan || $jumlahSaudaraAktif >= 2) {
                $porsi = 1 / 6;
                $keterangan[] = 'Ibu: 1/6' . ($adaKeturunan ? ' (ada keturunan)' : ' (ada dua saudara atau lebih)') . '.';
            } else {
                $porsi = 1 / 3;
                $keterangan[] = 'Ibu: 1/3 (tidak ada keturunan/saudara).';
            }
            $furud[] = ['label' => 'Ibu', 'share' => $porsi];
        }

        // Ayah
        $ayahAshabah = false;
        if ($adaAyah) {
            if ($anakL > 0 || $cucuL > 0) {
                $furud[] = ['label' => 'Ayah', 'share' => 1 / 6];
                $keterangan[] = 'Ayah: 1/6 (ada keturunan laki-laki).';
            } elseif ($adaKeturunan) {
                $furud[] = ['label' => 'Ayah', 'share' => 1 / 6];
                $ayahAshabah = true;
                $keterangan[] = 'Ayah: 1/6 + sisa harta (ashabah, karena keturunan hanya perempuan).';
            } else {
                $ayahAshabah = true;
                $keterangan[] = 'Ayah: ashabah (menerima seluruh sisa harta).';
            }
        }

        // Kakek (menggantikan ayah bila ayah tidak ada)
        $kakekAshabah = false;
        if ($kakekAktif) {
            if ($anakL > 0 || $cucuL > 0) {
                $furud[] = ['label' => 'Kakek', 'share' => 1 / 6];
                $keterangan[] = 'Kakek: 1/6 (menggantikan ayah, ada keturunan laki-laki).';
            } elseif ($adaKeturunan) {
                $furud[] = ['label' => 'Kakek', 'share' => 1 / 6];
                $kakekAshabah = true;
                $keterangan[] = 'Kakek: 1/6 + sisa harta (ashabah).';
            } else {
                $kakekAshabah = true;
                $keterangan[] = 'Kakek: ashabah (menggantikan ayah).';
            }
        }

        // Nenek
        if ($nenekAktif) {
            $furud[] = ['label' => 'Nenek', 'share' => 1 / 6];
            $keterangan[] = 'Nenek: 1/6'
                . (($adaNenekIbu && $adaNenekAyah) ? ' (dibagi rata antara nenek dari ibu dan dari ayah).' : '.');
        }

        // Anak — furud bila perempuan saja, ashabah bila ada laki-laki
        $anakAshabah = false;
        if ($adaAnak) {
            if ($anakL > 0) {
                $anakAshabah = true;
            } elseif ($anakP === 1) {
                $furud[] = ['label' => 'Anak perempuan', 'share' => 1 / 2];
                $keterangan[] = 'Anak perempuan tunggal: 1/2.';
            } else {
                $furud[] = ['label' => "Anak perempuan ($anakP)", 'share' => 2 / 3];
                $keterangan[] = "Anak perempuan ($anakP orang): 2/3 dibagi rata.";
            }
        }

        // Cucu (menggantikan anak bila anak tidak ada)
        $cucuAshabah = false;
        if ($adaCucu) {
            if ($cucuL > 0) {
                $cucuAshabah = true;
            } elseif ($cucuP === 1) {
                $furud[] = ['label' => 'Cucu perempuan', 'share' => 1 / 2];
                $keterangan[] = 'Cucu perempuan tunggal: 1/2.';
            } else {
                $furud[] = ['label' => "Cucu perempuan ($cucuP)", 'share' => 2 / 3];
                $keterangan[] = "Cucu perempuan ($cucuP orang): 2/3 dibagi rata.";
            }
        }

        // ===== 4. Ashabah (penerima sisa) =====
        $ashabah = [];

        if ($anakAshabah) {
            if ($anakL > 0) {
                $ashabah[] = ['label' => "Anak laki-laki ($anakL)", 'weight' => 2 * $anakL];
            }
            if ($anakP > 0) {
                $ashabah[] = ['label' => "Anak perempuan ($anakP)", 'weight' => $anakP];
            }
            $keterangan[] = 'Anak: ashabah, bagian laki-laki 2× perempuan.';
        } elseif ($cucuAshabah) {
            if ($cucuL > 0) {
                $ashabah[] = ['label' => "Cucu laki-laki ($cucuL)", 'weight' => 2 * $cucuL];
            }
            if ($cucuP > 0) {
                $ashabah[] = ['label' => "Cucu perempuan ($cucuP)", 'weight' => $cucuP];
            }
            $keterangan[] = 'Cucu: ashabah, bagian laki-laki 2× perempuan.';
        } elseif ($ayahAshabah) {
            $ashabah[] = ['label' => 'Ayah', 'weight' => 1];
        } elseif ($kakekAshabah) {
            $ashabah[] = ['label' => 'Kakek', 'weight' => 1];
        } elseif ($sdrKandungL > 0) {
            $ashabah[] = ['label' => "Saudara laki-laki ($sdrKandungL)", 'weight' => 2 * $sdrKandungL];
            if ($sdrKandungP > 0) {
                $ashabah[] = ['label' => "Saudara perempuan ($sdrKandungP)", 'weight' => $sdrKandungP];
            }
            $keterangan[] = 'Saudara kandung: ashabah, bagian laki-laki 2× perempuan.';
        } elseif ($sdrKandungP > 0) {
            if ($sdrKandungP === 1) {
                $furud[] = ['label' => 'Saudara perempuan', 'share' => 1 / 2];
                $keterangan[] = 'Saudara perempuan tunggal: 1/2.';
            } else {
                $furud[] = ['label' => "Saudara perempuan ($sdrKandungP)", 'share' => 2 / 3];
                $keterangan[] = "Saudara perempuan ($sdrKandungP orang): 2/3 dibagi rata.";
            }
        }

        // Saudara seibu — furud, tidak pernah ashabah
        if ($sdrSeibuAktif > 0) {
            $furud[] = [
                'label' => "Saudara seibu ($sdrSeibuAktif)",
                'share' => $sdrSeibuAktif === 1 ? 1 / 6 : 1 / 3,
            ];
            $keterangan[] = 'Saudara seibu: ' . ($sdrSeibuAktif === 1 ? '1/6' : '1/3') . ' dibagi rata (laki-laki = perempuan).';
        }

        // ===== 5. Hitung porsi =====
        $hasil = [];
        foreach ($furud as $f) {
            $hasil[] = ['ahli' => $f['label'], 'porsi' => $f['share']];
        }

        $totalFurud = array_sum(array_column($furud, 'share'));
        $sisa = 1 - $totalFurud;

        if (!empty($ashabah) && $sisa > 0.0000001) {
            $totalWeight = array_sum(array_column($ashabah, 'weight'));
            foreach ($ashabah as $a) {
                $hasil[] = [
                    'ahli' => $a['label'],
                    'porsi' => $sisa * ($a['weight'] / $totalWeight),
                ];
            }
        }

        $totalPorsi = array_sum(array_column($hasil, 'porsi'));

        // 'Aul — total bagian melebihi 1, semua dinormalkan
        if ($totalPorsi > 1.0000001) {
            $keterangan[] = "Terjadi 'aul (total bagian melebihi 1) — porsi dinormalkan secara proporsional.";
            foreach ($hasil as &$h) {
                $h['porsi'] = $h['porsi'] / $totalPorsi;
            }
            unset($h);
            $totalPorsi = 1.0;
        }

        // Radd — sisa harta dikembalikan kepada ahli waris selain pasangan
        if ($totalPorsi < 0.9999999 && empty($ashabah) && !empty($hasil)) {
            $penerimaRadd = array_filter($hasil, fn ($h) => !in_array($h['ahli'], ['Istri', 'Suami'], true));
            $totalRadd = array_sum(array_column($penerimaRadd, 'porsi'));
            if ($totalRadd > 0) {
                $keterangan[] = 'Terjadi radd — sisa harta dikembalikan kepada ahli waris selain pasangan secara proporsional.';
                foreach ($hasil as &$h) {
                    if (in_array($h['ahli'], ['Istri', 'Suami'], true)) {
                        continue;
                    }
                    $h['porsi'] += (1 - $totalPorsi) * ($h['porsi'] / $totalRadd);
                }
                unset($h);
                $totalPorsi = 1.0;
            }
        }

        // Tanpa ahli waris
        if (empty($hasil)) {
            $hasil[] = ['ahli' => 'Baitul Mal (Negara)', 'porsi' => 1.0];
            $keterangan[] = 'Tidak terdeteksi ahli waris — harta diserahkan ke Baitul Mal.';
            $totalPorsi = 1.0;
        }

        // ===== 6. Konversi ke rupiah =====
        $hasilAkhir = [];
        foreach ($hasil as $h) {
            $porsi = $totalPorsi > 0 ? $h['porsi'] / $totalPorsi : 0;
            $hasilAkhir[] = [
                'ahli' => $h['ahli'],
                'porsi' => round($porsi, 6),
                'persen' => round($porsi * 100, 2),
                'nilai' => round($porsi * $hartaBersih, 2),
            ];
        }

        return [
            'totalHarta' => $totalHarta,
            'hartaBersih' => round($hartaBersih, 2),
            'potongan' => [
                'hutang' => $hutang,
                'biaya_pemakaman' => $biayaPemakaman,
                'wasiat' => $wasiat,
                'total' => round($hutang + $biayaPemakaman + $wasiat, 2),
            ],
            'hasil' => $hasilAkhir,
            'keterangan' => $keterangan,
            'total' => round($hartaBersih, 2),
        ];
    }

    private function rupiah(float $nilai): string
    {
        return number_format($nilai, 0, ',', '.');
    }
}
