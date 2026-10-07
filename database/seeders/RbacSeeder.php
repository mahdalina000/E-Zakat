<?php

namespace Database\Seeders;

use App\Models\BerasPrice;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin — Pemko Banjarbaru
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@banjarbaru.go.id'],
            [
                'name' => 'Super Admin Pemko Banjarbaru',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Admin BAZNAS
        $adminBaznas = User::firstOrCreate(
            ['email' => 'admin@baznas-banjarbaru.id'],
            [
                'name' => 'Admin BAZNAS Kota Banjarbaru',
                'password' => Hash::make('admin123'),
                'role' => 'admin_baznas',
                'admin_type' => 'baznas',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Admin UPZ
        $adminUpz = User::firstOrCreate(
            ['email' => 'admin@upz-banjarbaru.id'],
            [
                'name' => 'Admin UPZ Masjid Al-Munawwarah',
                'password' => Hash::make('admin123'),
                'role' => 'admin_upz',
                'admin_type' => 'upz',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // User umum
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Warga Banjarbaru',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Extra users for stats
        foreach (range(1, 6) as $i) {
            User::firstOrCreate(
                ['email' => "warga{$i}@gmail.com"],
                [
                    'name' => "Warga {$i}",
                    'password' => Hash::make('user123'),
                    'role' => 'user',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'last_login_at' => now()->subDays(rand(0, 7)),
                ]
            );
        }
        foreach (range(1, 2) as $i) {
            User::firstOrCreate(
                ['email' => "upz{$i}@banjarbaru.id"],
                [
                    'name' => "Admin UPZ {$i}",
                    'password' => Hash::make('admin123'),
                    'role' => 'admin_upz',
                    'admin_type' => 'upz',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Harga beras awal
        if (BerasPrice::count() === 0) {
            BerasPrice::create(['price' => 16000, 'updated_by' => $adminBaznas->id, 'note' => 'Harga awal Beras Banjar']);
            BerasPrice::create(['price' => 16500, 'updated_by' => $adminBaznas->id, 'note' => 'Penyesuaian harga pasar']);
        }

        // Lokasi contoh — hanya jika belum ada
        if (Location::count() === 0) {
            $locs = [
                ['name'=>'BAZNAS Kota Banjarbaru','address'=>'Jl. A. Yani KM 33,5 — Komplek Perkantoran Pemko','kelurahan'=>'Loktabat Selatan','kecamatan'=>'Banjarbaru Selatan','latitude'=>-3.4420,'longitude'=>114.8310,'type'=>'baznas','phone'=>'(0511) 4772xxx','opening_hours'=>'08.00–16.00 WITA','description'=>'Pusat. Jemput zakat, transfer & QRIS.'],
                ['name'=>'BAZNAS Gerai Banjarbaru Mart','address'=>'Jl. RO Ulin, Loktabat','kelurahan'=>'Loktabat Utara','kecamatan'=>'Banjarbaru Utara','latitude'=>-3.4390,'longitude'=>114.8380,'type'=>'baznas','phone'=>'0821-5xxx-xxxx','opening_hours'=>'09.00–17.00','description'=>'Gerai layanan zakat di pusat perbelanjaan.'],
                ['name'=>'Masjid Agung Al-Munawwarah','address'=>'Jl. Trikora, Banjarbaru','kelurahan'=>'Komet','kecamatan'=>'Banjarbaru Utara','latitude'=>-3.4440,'longitude'=>114.8290,'type'=>'upz','phone'=>'0812-5xxx-xxxx','opening_hours'=>'Menjelang Idul Fitri 24 jam','description'=>'UPZ resmi. Menerima beras & uang.'],
                ['name'=>'Masjid At-Taqwa Landasan Ulin','address'=>'Jl. A. Yani KM 24, Landasan Ulin','kelurahan'=>'Landasan Ulin Timur','kecamatan'=>'Liang Anggang','latitude'=>-3.4520,'longitude'=>114.8150,'type'=>'upz','phone'=>'0821-5xxx-xxxx','opening_hours'=>"Ba'da shalat",'description'=>'UPZ Landasan Ulin.'],
                ['name'=>'Masjid Nurul Iman Cempaka','address'=>'Jl. Mistar Cokrokusumo, Cempaka','kelurahan'=>'Cempaka','kecamatan'=>'Cempaka','latitude'=>-3.4350,'longitude'=>114.8450,'type'=>'upz','phone'=>'0852-5xxx-xxxx','opening_hours'=>'08.00–20.00','description'=>'Melayani zakat fitrah & fidyah.'],
                ['name'=>'Masjid Al-Ikhlas Guntung Paikat','address'=>'Guntung Paikat, Banjarbaru Selatan','kelurahan'=>'Guntung Paikat','kecamatan'=>'Banjarbaru Selatan','latitude'=>-3.4480,'longitude'=>114.8400,'type'=>'upz','phone'=>'0813-5xxx-xxxx','opening_hours'=>"Ba'da shalat",'description'=>'UPZ lingkungan.'],
                ['name'=>'UPZ Kelurahan Loktabat Utara','address'=>'Kantor Lurah Loktabat Utara','kelurahan'=>'Loktabat Utara','kecamatan'=>'Banjarbaru Utara','latitude'=>-3.4360,'longitude'=>114.8330,'type'=>'upz','phone'=>'0822-5xxx-xxxx','opening_hours'=>'08.00–15.00','description'=>'Koordinasi RT/RW.'],
            ];
            foreach ($locs as $l) {
                Location::create(array_merge($l, ['created_by' => $adminBaznas->id]));
            }
        }
    }
}
