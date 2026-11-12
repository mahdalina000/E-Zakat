<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom baru Tujuan Zakat pada catatan zakat (bayar sendiri / ke amil / dll)
        Schema::table('zakat_records', function (Blueprint $table) {
            $table->string('tujuan', 100)->nullable()->after('reference_number');
        });

        // Kolom kategori 'usulan' sudah ada (zakat_category); tambah penanda disetujui admin
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->boolean('category_approved')->default(false)->after('zakat_category_reason');
            $table->foreignId('category_approved_by')->nullable()->after('category_approved')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('category_approved_at')->nullable()->after('category_approved_by');
        });
    }

    public function down(): void
    {
        Schema::table('zakat_records', function (Blueprint $table) {
            $table->dropColumn('tujuan');
        });
        Schema::table('warga_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_approved_by');
            $table->dropColumn(['category_approved', 'category_approved_at']);
        });
    }
};
