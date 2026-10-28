<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'calc_type', 'input_data', 'result_data',
        'beras_price', 'gold_price',
    ];

    protected $casts = [
        'input_data' => 'array',
        'result_data' => 'array',
        'beras_price' => 'decimal:2',
        'gold_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calcTypeLabel(): string
    {
        return match ($this->calc_type) {
            'zakat_fitrah' => 'Zakat Fitrah',
            'zakat_maal' => 'Zakat Maal',
            'fidyah' => 'Fidyah',
            'wariq' => 'Waris',
            'zakat_penghasilan' => 'Zakat Penghasilan',
            'zakat_pertanian' => 'Zakat Pertanian',
            'zakat_perdagangan' => 'Zakat Perdagangan',
            default => ucfirst(str_replace('_', ' ', $this->calc_type ?? '-')),
        };
    }

    public function calcTypeIcon(): string
    {
        return match ($this->calc_type) {
            'zakat_fitrah' => 'fa-wheat-awn',
            'zakat_maal' => 'fa-coins',
            'fidyah' => 'fa-utensils',
            'wariq' => 'fa-scale-balanced',
            'zakat_penghasilan' => 'fa-money-bill-trend-up',
            'zakat_pertanian' => 'fa-seedling',
            'zakat_perdagangan' => 'fa-store',
            default => 'fa-calculator',
        };
    }
}
