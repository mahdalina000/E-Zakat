<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Banner hari besar keagamaan dinamis.
 *
 * Admin BAZNAS mengelola daftar hari raya (teks ucapan, tanggal countdown,
 * durasi tampil sebelum/sesudah, ikon, warna) melalui panel admin.
 * Beranda membaca tabel ini, bukan array hardcoded di JS.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holiday_banners', function (Blueprint $table) {
            $table->id();
            $table->string('key', 60)->unique();                 // slug unik, mis. idul-fitri-1449
            $table->string('name', 150);                         // nama hari raya
            $table->date('event_date');                          // tanggal inti (countdown)
            $table->unsignedSmallInteger('before_days')->default(15); // tampil H-before
            $table->unsignedSmallInteger('after_days')->default(3);  // tampil s/d H+after
            $table->string('icon', 60)->default('fa-solid fa-mosque');
            $table->string('color', 20)->default('olive');       // olive|teal|blue|emerald|rose|gold
            $table->string('title', 150);                        // judul banner
            $table->text('text');                                // isi ucapan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holiday_banners');
    }
};
