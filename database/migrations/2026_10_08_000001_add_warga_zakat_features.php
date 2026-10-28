<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================
        // 1. TABLE: WARGA PROFILES (Data Diri Warga)
        // ============================================
        Schema::create('warga_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            
            // Data Pribadi
            $table->string('full_name');
            $table->string('nik', 16)->nullable()->unique(); // NIK 16 digit
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->default('single');
            $table->string('blood_type', 10)->nullable();
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
            $table->string('employment_status', 50)->nullable(); // PNS, Swasta, Wiraswasta, etc
            
            // Alamat
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('city', 100)->default('Banjarbaru');
            $table->string('province', 100)->default('Kalimantan Selatan');
            $table->string('postal_code', 10)->nullable();
            
            // Tanggungan
            $table->unsignedTinyInteger('dependents_count')->default(0);
            $table->decimal('monthly_income', 14, 2)->nullable(); // Penghasilan per bulan
            $table->decimal('monthly_expense', 14, 2)->nullable(); // Pengeluaran per bulan
            $table->decimal('debt_amount', 14, 2)->default(0); // Total utang
            $table->decimal('asset_value', 14, 2)->default(0); // Total aset
            $table->decimal('cash_value', 14, 2)->default(0); // Kas/Tabungan
            $table->decimal('gold_value', 14, 2)->default(0); // Emas
            $table->decimal('investment_value', 14, 2)->default(0); // Investasi
            $table->decimal('property_value', 14, 2)->default(0); // Properti
            $table->decimal('vehicle_value', 14, 2)->default(0); // Kendaraan
            
            // Kategori Zakat (Otomatis ditentukan oleh sistem)
            $table->enum('zakat_category', ['pemberi', 'penerima_fakir', 'penerima_miskin', 'penerima_gharimin', 'netral'])->default('netral');
            $table->text('zakat_category_reason')->nullable(); // Penjelasan kenapa masuk kategori ini
            
            // Status
            $table->boolean('is_verified')->default(false); // Sudah diverifikasi oleh admin
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['zakat_category']);
            $table->index(['kelurahan', 'kecamatan']);
        });

        // ============================================
        // 2. TABLE: ZAKAT RECORDS (Pencatatan Zakat)
        // ============================================
        Schema::create('zakat_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            
            // Jenis zakat
            $table->enum('zakat_type', ['zakat_fitrah', 'zakat_maal', 'fidyah', 'infak_sedekah', 'wariq']);
            
            // Data perhitungan
            $table->decimal('total_amount', 16, 2); // Total uang
            $table->decimal('beras_kg')->nullable(); // Jika ada konversi ke beras
            $table->decimal('gold_gram')->nullable(); // Jika ada konversi ke emas
            $table->unsignedInteger('jiwa_count')->default(1); // Jumlah jiwa
            $table->date('due_date')->nullable(); // Tanggal jatuh tempo / dibayar
            $table->date('payment_date')->nullable(); // Tanggal pembayaran
            
            // Metode pembayaran
            $table->enum('payment_method', ['tunai', 'transfer', 'qris', 'beras_fisik', 'emas_fisik', 'makanan'])->default('tunai');
            $table->string('reference_number', 100)->nullable(); // No. transfer/referensi
            
            // Keterangan
            $table->text('notes')->nullable();
            $table->boolean('is_confirmed')->default(false); // Sudah dikonfirmasi oleh admin
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'zakat_type']);
            $table->index(['due_date']);
        });

        // ============================================
        // 3. TABLE: CALCULATION HISTORIES (Riwayat Perhitungan)
        // ============================================
        Schema::create('calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Jenis kalkulator
            $table->enum('calc_type', ['zakat_fitrah', 'zakat_maal', 'fidyah', 'wariq']);
            
            // Input data (JSON)
            $table->json('input_data'); // Semua input yang dimasukkan user
            $table->json('result_data'); // Hasil perhitungan
            
            // Snapshot harga referensi saat itu
            $table->decimal('beras_price', 14, 2)->nullable();
            $table->decimal('gold_price', 14, 2)->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'calc_type']);
        });

        // ============================================
        // 4. TABLE: HEIRS (Untuk Kalkulator Waris)
        // ============================================
        Schema::create('heirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Data pewaris
            $table->string('deceased_name'); // Nama almarhum/almarhumah
            $table->date('deceased_died_date')->nullable();
            $table->decimal('estate_value', 18, 2); // Total harta warisan
            
            // Hasil perhitungan
            $table->json('heir_breakdown'); // Array berisi pembagian per ahli waris
            $table->text('calculation_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heirs');
        Schema::dropIfExists('calculation_histories');
        Schema::dropIfExists('zakat_records');
        Schema::dropIfExists('warga_profiles');
    }
};
