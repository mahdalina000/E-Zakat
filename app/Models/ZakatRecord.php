<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZakatRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'location_id', 'zakat_type', 'total_amount', 'beras_kg',
        'gold_gram', 'jiwa_count', 'due_date', 'payment_date',
        'payment_method', 'reference_number', 'notes',
        'is_confirmed', 'confirmed_by', 'confirmed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'beras_kg' => 'decimal:2',
        'gold_gram' => 'decimal:2',
        'jiwa_count' => 'integer',
        'due_date' => 'date',
        'payment_date' => 'date',
        'is_confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function zakatTypeLabel(): string
    {
        return match ($this->zakat_type) {
            'zakat_fitrah' => 'Zakat Fitrah',
            'zakat_maal' => 'Zakat Maal',
            'fidyah' => 'Fidyah',
            'infak_sedekah' => 'Infak & Sedekah',
            'wariq' => 'Waris (Wariq)',
            default => ucfirst($this->zakat_type ?? '-'),
        };
    }

    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'tunai' => 'Tunai',
            'transfer' => 'Transfer',
            'qris' => 'QRIS',
            'beras_fisik' => 'Beras Fisik',
            'emas_fisik' => 'Emas Fisik',
            'makanan' => 'Makanan',
            default => ucfirst($this->payment_method ?? '-'),
        };
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('zakat_type', $type);
    }
}
