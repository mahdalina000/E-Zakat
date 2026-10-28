<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Heir extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'deceased_name', 'deceased_died_date', 'estate_value',
        'heir_breakdown', 'calculation_notes',
    ];

    protected $casts = [
        'deceased_died_date' => 'date',
        'estate_value' => 'decimal:2',
        'heir_breakdown' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Total harta yang dibagi.
     */
    public function totalDistributed(): float
    {
        $total = 0;
        foreach (($this->heir_breakdown ?? []) as $heir) {
            $total += (float) ($heir['share_value'] ?? 0);
        }
        return $total;
    }

    /**
     * Jumlah ahli waris.
     */
    public function heirCount(): int
    {
        return count($this->heir_breakdown ?? []);
    }
}
