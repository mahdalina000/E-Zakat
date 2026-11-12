<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZakatRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'location_id',
        'full_name', 'deceased_name',
        'total_assets', 'monthly_income', 'debt_amount',
        'family_members', 'description', 'waris_data', 'admin_note',
        'status', 'calculated_amount', 'calculation_detail',
        'verified_by', 'verified_at', 'calculated_by', 'calculated_at',
        'rejected_at',
    ];

    protected $casts = [
        'total_assets' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'debt_amount' => 'decimal:2',
        'calculated_amount' => 'decimal:2',
        'waris_data' => 'array',
        'calculation_detail' => 'array',
        'verified_at' => 'datetime',
        'calculated_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function calculator()
    {
        return $this->belongsTo(User::class, 'calculated_by');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'calculating' => 'Sedang Dihitung',
            'done' => 'Selesai',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
