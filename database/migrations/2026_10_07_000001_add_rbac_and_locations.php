<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // super_admin, admin_baznas, admin_upz, admin, user
            $table->string('admin_type')->nullable()->after('role'); // baznas / upz (clarify if needed)
            $table->boolean('is_active')->default(true)->after('admin_type');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });

        Schema::create('login_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('logged_in_at')->useCurrent();
            $table->index(['user_id', 'logged_in_at']);
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('type')->default('upz'); // baznas, upz, warga
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('opening_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['type', 'is_active']);
        });

        Schema::create('beras_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price'); // rupiah per kg
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beras_prices');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('login_activities');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'admin_type', 'is_active', 'last_login_at']);
        });
    }
};
