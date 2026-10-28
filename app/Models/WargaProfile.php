<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WargaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'nik', 'gender', 'birth_date', 'birth_place',
        'marital_status', 'blood_type', 'phone', 'occupation', 'employment_status',
        'address_line1', 'address_line2', 'rt', 'rw', 'kelurahan', 'kecamatan',
        'city', 'province', 'postal_code',
        'dependents_count', 'monthly_income', 'monthly_expense',
        'debt_amount', 'asset_value', 'cash_value', 'gold_value',
 'investment_value', 'property_value', 'vehicle_value',
 'zakat_category', 'zakat_category_reason',
        'is_verified', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'monthly_income' => 'decimal:2',
        'monthly_expense' => 'decimal:2',
        'debt_amount' => 'decimal:2',
        'asset_value' => 'decimal:2',
        'cash_value' => 'decimal:2',
        'gold_value' => 'decimal:2',
        'investment_value' => 'decimal:2',
        'property_value' => 'decimal:2',
        'vehicle_value' => 'decimal:2',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Cek apakah profil sudah diverifikasi.
     */
    public function isVerified(): bool
    {
        return $this->is_verified && $this->verified_at !== null;
    }

    /**
     * Hitung total aset.
     *
     * Rincian aset opsional; bila warga hanya mengisi "Perkiraan Total Aset"
     * (asset_value), pakai nilai itu. max() mencegah hitung dobel.
     */
    public function totalAsset(): float
    {
        $rincian = (float) $this->cash_value
            + (float) $this->gold_value
            + (float) $this->vehicle_value;

        return max($rincian, (float) $this->asset_value);
    }

    /**
     * Kategori otomatis berdasarkan kondisi ekonomi.
     */
    public function autoCategorize(): array
    {
        $income = (float) $this->monthly_income;
        $debt = (float) $this->debt_amount;
        $assets = $this->totalAsset();
        $dependents = (int) $this->dependents_count;

        // Kebutuhan pokok per orang: Rp 1.500.000 (estimatasi)
        $kebutuhanPokok = 1500000 * max($dependents, 1);

        if ($debt > 0 && $income <= $kebutuhanPokok) {
            return ['category' => 'penerima_gharimin', 'reason' => 'Memiliki hutang dan penghasilan tidak mampu menutup kebutuhan pokok.'];
        }
        if ($income == 0 && $assets == 0) {
            return ['category' => 'penerima_fakir', 'reason' => 'Tidak memiliki penghasilan dan harta.'];
        }
        if ($income <= $kebutuhanPokok) {
            return ['category' => 'penerima_miskin', 'reason' => 'Penghasilan tidak mencukupi kebutuhan pokok keluarga.'];
        }
        if ($income >= 5000000 && $assets >= 10000000) {
            return ['category' => 'pemberi', 'reason' => 'Memiliki penghasilan dan aset yang mencukupi.'];
        }
        return ['category' => 'netral', 'reason' => 'Kondisi ekonomi sedang — tidak terdeteksi sebagai penerima atau pemberi khusus.'];
    }

    /**
     * Label kategori.
     */
    public function kategoriLabel(): string
    {
        return match ($this->zakat_category) {
            'pemberi' => 'Pemberi Zakat',
            'penerima_fakir' => 'Penerima — Fakir',
            'penerima_miskin' => 'Penerima — Miskin',
            'penerima_gharimin' => 'Penerima — Gharimin',
            'netral' => 'Netral',
            default => 'Belum Diketahui',
        };
    }

    /**
     * Label gender.
     */
    public function genderLabel(): string
    {
        return match ($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => 'Tidak diketahui',
        };
    }

    /**
     * Label status pernikahan.
     */
    public function statusPernikahanLabel(): string
    {
        return match ($this->marital_status) {
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorced' => 'Cerai',
            'widowed' => 'Duda/Janda',
            default => 'Belum diisi',
        };
    }
}
