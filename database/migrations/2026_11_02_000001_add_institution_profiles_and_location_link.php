<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengaturan profil lembaga (UPZ / BAZNAS) per akun admin
        Schema::create('institution_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('institution_type')->nullable(); // baznas / upz
            $table->string('institution_name');
            $table->string('alias', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('public_email')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });

        // Hubungkan warga penerima ke lokasi (untuk fitur tambah warga + lokasi sekaligus)
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('user_id')
                ->constrained('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('location_id');
        });
        Schema::dropIfExists('institution_profiles');
    }
};
