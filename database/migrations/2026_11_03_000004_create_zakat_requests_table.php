<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zakat_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();

            // Data pengajuan dari masyarakat
            $table->string('full_name')->nullable();
            $table->decimal('total_assets', 15, 2)->default(0);          // perkiraan total harta
            $table->decimal('monthly_income', 15, 2)->default(0);        // penghasilan per bulan
            $table->decimal('debt_amount', 15, 2)->default(0);           // hutang
            $table->unsignedTinyInteger('family_members')->default(0);   // jumlah anggota keluarga
            $table->text('description')->nullable();                    // mis. tanah sengketa dll.
            $table->text('admin_note')->nullable();

            $table->string('status', 20)->default('pending'); // pending | verified | calculating | done | rejected
            $table->decimal('calculated_amount', 15, 2)->nullable();
            $table->json('calculation_detail')->nullable();

            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('calculated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('calculated_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zakat_requests');
    }
};
