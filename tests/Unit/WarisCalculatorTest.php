<?php

namespace Tests\Unit;

use App\Services\Waris\WarisCalculator;
use PHPUnit\Framework\TestCase;

class WarisCalculatorTest extends TestCase
{
    private function persen(array $r, string $ahli): float
    {
        foreach ($r['hasil'] as $h) {
            if ($h['ahli'] === $ahli) {
                return $h['persen'];
            }
        }
        return 0.0;
    }

    /** Total nilai harus sama dengan harta bersih. */
    private function assertTuntas(array $r, float $harta): void
    {
        $total = array_sum(array_column($r['hasil'], 'nilai'));
        $this->assertEqualsWithDelta($harta, $total, 1.0, 'Total nilai harus sama dengan harta bersih');
        $this->assertEqualsWithDelta(100.0, array_sum(array_column($r['hasil'], 'persen')), 0.5);
    }

    public function test_ayah_dan_ibu_tanpa_anak(): void
    {
        // Ayah ashabah: 2/3, Ibu 1/3
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaAyah: true, adaIbu: true);
        $this->assertEqualsWithDelta(66.67, $this->persen($r, 'Ayah'), 0.02);
        $this->assertEqualsWithDelta(33.33, $this->persen($r, 'Ibu'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_istri_ayah_ibu_dua_anak_perempuan_aul(): void
    {
        // 1/8 + 1/6 + 1/6 + 2/3 = 27/24 → aul
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaIstri: true, jumlahAnakP: 2, adaAyah: true, adaIbu: true);
        $this->assertEqualsWithDelta(11.11, $this->persen($r, 'Istri'), 0.02);
        $this->assertEqualsWithDelta(14.81, $this->persen($r, 'Ayah'), 0.02);
        $this->assertEqualsWithDelta(14.81, $this->persen($r, 'Ibu'), 0.02);
        $this->assertEqualsWithDelta(59.26, $this->persen($r, 'Anak perempuan (2)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_saudara_kandung_l_dan_p_dua_banding_satu(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L', jumlahSaudaraL: 1, jumlahSaudaraP: 1);
        $this->assertEqualsWithDelta(66.67, $this->persen($r, 'Saudara laki-laki (1)'), 0.02);
        $this->assertEqualsWithDelta(33.33, $this->persen($r, 'Saudara perempuan (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_anak_l_dan_p_dua_banding_satu(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L', jumlahAnakL: 1, jumlahAnakP: 1);
        $this->assertEqualsWithDelta(66.67, $this->persen($r, 'Anak laki-laki (1)'), 0.02);
        $this->assertEqualsWithDelta(33.33, $this->persen($r, 'Anak perempuan (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_suami_dengan_anak_laki_laki(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'P', adaSuami: true, jumlahAnakL: 1);
        $this->assertEqualsWithDelta(25.0, $this->persen($r, 'Suami'), 0.02);
        $this->assertEqualsWithDelta(75.0, $this->persen($r, 'Anak laki-laki (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_istri_dengan_anak_perempuan_tunggal_radd(): void
    {
        // 1/8 + 1/2 = 5/8 → sisa di-radd ke anak perempuan
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaIstri: true, jumlahAnakP: 1);
        $this->assertEqualsWithDelta(12.5, $this->persen($r, 'Istri'), 0.02);
        $this->assertEqualsWithDelta(87.5, $this->persen($r, 'Anak perempuan'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_umariyyatain_istri_ayah_ibu(): void
    {
        // Istri 1/4, Ibu 1/3 dari sisa (1/4), Ayah sisa 1/2
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaIstri: true, adaAyah: true, adaIbu: true);
        $this->assertEqualsWithDelta(25.0, $this->persen($r, 'Istri'), 0.02);
        $this->assertEqualsWithDelta(25.0, $this->persen($r, 'Ibu'), 0.02);
        $this->assertEqualsWithDelta(50.0, $this->persen($r, 'Ayah'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_harta_bersih_memotong_hutang_wasiat_pemakaman(): void
    {
        // Wasiat 50jt > 1/3 × 120jt = 40jt, jadi dibatasi 40jt
        $r = (new WarisCalculator())->hitung(
            120000000, 'L',
            jumlahAnakL: 1,
            hutang: 10000000,
            wasiat: 50000000,
            biayaPemakaman: 5000000
        );
        $this->assertEqualsWithDelta(40000000, $r['potongan']['wasiat'], 1.0);
        $this->assertEqualsWithDelta(65000000, $r['hartaBersih'], 1.0);
        $this->assertEqualsWithDelta(65000000, $this->persen($r, 'Anak laki-laki (1)') * 650000, 1000);
        $this->assertTuntas($r, 65000000);
    }

    public function test_cucu_menggantikan_anak(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaIstri: true, jumlahCucuL: 1, jumlahCucuP: 1);
        $this->assertEqualsWithDelta(12.5, $this->persen($r, 'Istri'), 0.02);
        $this->assertEqualsWithDelta(58.33, $this->persen($r, 'Cucu laki-laki (1)'), 0.02);
        $this->assertEqualsWithDelta(29.17, $this->persen($r, 'Cucu perempuan (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_kakek_menggantikan_ayah_dan_nenek_seperenam(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L', adaKakek: true, adaNenekIbu: true, jumlahAnakL: 1);
        $this->assertEqualsWithDelta(16.67, $this->persen($r, 'Kakek'), 0.02);
        $this->assertEqualsWithDelta(16.67, $this->persen($r, 'Nenek'), 0.02);
        $this->assertEqualsWithDelta(66.67, $this->persen($r, 'Anak laki-laki (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_saudara_terhalang_oleh_anak(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L', jumlahAnakL: 1, jumlahSaudaraL: 2, jumlahSaudaraP: 2);
        $this->assertEqualsWithDelta(0.0, $this->persen($r, 'Saudara laki-laki (2)'), 0.01);
        $this->assertEqualsWithDelta(100.0, $this->persen($r, 'Anak laki-laki (1)'), 0.02);
    }

    public function test_saudara_seibu_tidak_ashabah(): void
    {
        // Suami 1/2, saudara seibu 1/3, sisa ke saudara kandung laki-laki
        $r = (new WarisCalculator())->hitung(120000000, 'P', adaSuami: true, jumlahSaudaraSeibu: 2, jumlahSaudaraL: 1);
        $this->assertEqualsWithDelta(50.0, $this->persen($r, 'Suami'), 0.02);
        $this->assertEqualsWithDelta(33.33, $this->persen($r, 'Saudara seibu (2)'), 0.02);
        $this->assertEqualsWithDelta(16.67, $this->persen($r, 'Saudara laki-laki (1)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }

    public function test_tanpa_ahli_waris_ke_baitul_mal(): void
    {
        $r = (new WarisCalculator())->hitung(120000000, 'L');
        $this->assertEqualsWithDelta(100.0, $this->persen($r, 'Baitul Mal (Negara)'), 0.02);
        $this->assertTuntas($r, 120000000);
    }
}
