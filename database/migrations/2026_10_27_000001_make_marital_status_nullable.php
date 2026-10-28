<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Status Keluarga harus bisa benar-benar kosong.
 *
 * Sebelumnya kolom ini NOT NULL DEFAULT 'single', sehingga setiap warga yang
 * belum mengisi otomatis tercatat "Belum Menikah" — itu tebakan, bukan data.
 * Dengan nullable, form bisa menampilkan "Pilih..." sampai warga memilih sendiri.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])
                ->nullable()
                ->default(null)
                ->change();
        });

        // Bersihkan 'single' hasil default lama supaya warga mengisi sendiri.
        // Hanya untuk profil yang field wajibnya masih kosong (belum pernah diisi).
        DB::table('warga_profiles')
            ->where('marital_status', 'single')
            ->whereNull('birth_place')
            ->update(['marital_status' => null]);
    }

    public function down(): void
    {
        DB::table('warga_profiles')->whereNull('marital_status')->update(['marital_status' => 'single']);

        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])
                ->nullable(false)
                ->default('single')
                ->change();
        });
    }
};
