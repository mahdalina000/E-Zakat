<?php

namespace Database\Seeders;

use App\Models\HolidayBanner;
use Illuminate\Database\Seeder;

class HolidayBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'key' => 'mawlid-1449', 'name' => 'Maulid Nabi Muhammad SAW 1449H',
                'event_date' => '2028-10-16', 'before_days' => 7, 'after_days' => 3,
                'icon' => 'fa-solid fa-star-and-crescent', 'color' => 'teal',
                'title' => 'Maulid Nabi SAW Mendekat!',
                'text' => 'Peringatan kelahiran Rasulullah SAW. Perbanyak keutamaan sedekah & zakat sebagai sunnah beliau.',
            ],
            [
                'key' => 'ramadan-1449', 'name' => 'Bulan Suci Ramadan 1449H',
                'event_date' => '2027-12-24', 'before_days' => 30, 'after_days' => 3,
                'icon' => 'fa-solid fa-star-and-crescent', 'color' => 'emerald',
                'title' => 'Ramadan 1449H Akan Tiba!',
                'text' => 'Bersyukurlah & siapkan fisik dan harta. Segera tunaikan zakat fitrah menjelang akhir Ramadan.',
            ],
            [
                'key' => 'idul-fitri-1449', 'name' => '1 Syawal 1449H (Idul Fitri)',
                'event_date' => '2028-01-23', 'before_days' => 15, 'after_days' => 3,
                'icon' => 'fa-solid fa-mosque', 'color' => 'rose',
                'title' => 'Idul Fitri Mendekat!',
                'text' => 'Segera tunaikan zakat fitrah sebelum Sholat Id. 2,5 kg beras/jiwa.',
            ],
            [
                'key' => 'idul-adha-1449', 'name' => '10 Dzulhijjah 1449H (Idul Adha)',
                'event_date' => '2028-03-31', 'before_days' => 15, 'after_days' => 3,
                'icon' => 'fa-solid fa-cow', 'color' => 'gold',
                'title' => 'Idul Adha Mendekat!',
                'text' => 'Waktunya kurban. Siapkan 1/7 bagian hewan kurban — minimal ±12,5 kg daging per jiwa.',
            ],
        ];

        foreach ($banners as $b) {
            HolidayBanner::firstOrCreate(['key' => $b['key']], $b);
        }
    }
}
