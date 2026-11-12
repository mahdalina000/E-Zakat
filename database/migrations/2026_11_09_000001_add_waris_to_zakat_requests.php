<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Khususkan fitur pengajuan perhitungan menjadi perhitungan WARIS.
 * Kolom lama (total_assets/monthly_income/debt_amount/family_members) tetap ada
 * namun tidak lagi dipakai untuk fitur baru.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zakat_requests', function (Blueprint $table) {
            $table->string('deceased_name')->nullable()->after('full_name');
            $table->json('waris_data')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('zakat_requests', function (Blueprint $table) {
            $table->dropColumn(['deceased_name', 'waris_data']);
        });
    }
};
