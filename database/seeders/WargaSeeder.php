<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WargaProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh warga dengan profil lengkap — untuk demo kategori otomatis
        $warga = User::firstOrCreate(
            ['email' => 'demo.penerima@gmail.com'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if (!$warga->wargaProfile) {
            WargaProfile::create([
                'user_id' => $warga->id,
                'full_name' => 'Ahmad Fauzi',
                'nik' => '6101010101000001',
                'gender' => 'male',
                'birth_date' => '1985-06-15',
                'marital_status' => 'married',
                'occupation' => 'Petani',
                'dependents_count' => 4,
                'monthly_income' => 900000,
                'monthly_expense' => 850000,
                'debt_amount' => 15000000,
                'cash_value' => 500000,
                'gold_value' => 0,
                'investment_value' => 0,
                'property_value' => 0,
                'vehicle_value' => 30000000,
                'asset_value' => 30500000,
                'rt' => '05',
                'rw' => '02',
                'kelurahan' => 'Komet',
                'kecamatan' => 'Banjarbaru Utara',
                'city' => 'Banjarbaru',
                'province' => 'Kalimantan Selatan',
            ]);
        }

        // Warga pemberi zakat
        $pemberi = User::firstOrCreate(
            ['email' => 'demo.pemberi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if (!$pemberi->wargaProfile) {
            WargaProfile::create([
                'user_id' => $pemberi->id,
                'full_name' => 'Budi Santoso',
                'nik' => '6101020202000002',
                'gender' => 'male',
                'birth_date' => '1978-03-20',
                'marital_status' => 'married',
                'occupation' => 'Wiraswasta',
                'dependents_count' => 2,
                'monthly_income' => 25000000,
                'monthly_expense' => 15000000,
                'debt_amount' => 0,
                'cash_value' => 100000000,
                'gold_value' => 50000000,
                'investment_value' => 200000000,
                'property_value' => 1500000000,
                'vehicle_value' => 80000000,
                'asset_value' => 2450000000,
                'rt' => '03',
                'rw' => '01',
                'kelurahan' => 'Loktabat',
                'kecamatan' => 'Banjarbaru Utara',
                'city' => 'Banjarbaru',
                'province' => 'Kalimantan Selatan',
            ]);
        }
    }
}
