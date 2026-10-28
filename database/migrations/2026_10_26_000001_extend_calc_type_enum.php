<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Perluas enum calc_type untuk mendukung 3 kalkulator zakat baru:
     * zakat_penghasilan, zakat_pertanian, zakat_perdagangan.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE calculation_histories
            MODIFY COLUMN calc_type
            ENUM('zakat_fitrah','zakat_maal','fidyah','wariq','zakat_penghasilan','zakat_pertanian','zakat_perdagangan') NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE calculation_histories
            MODIFY COLUMN calc_type
            ENUM('zakat_fitrah','zakat_maal','fidyah','wariq') NOT NULL
        ");
    }
};
