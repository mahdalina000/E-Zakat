<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->string('nik', 500)->nullable()->change();
            $table->string('phone', 500)->nullable()->change();
            $table->text('address_line1')->nullable()->change();
            $table->text('address_line2')->nullable()->change();
        });

        Schema::table('institution_profiles', function (Blueprint $table) {
            $table->string('phone', 500)->nullable()->change();
            $table->text('address')->nullable()->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('phone', 500)->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    public function down(): void
    {
        // kolom diperlebar; downgrade tidak wajib memulihkan panjang asli.
    }
};
