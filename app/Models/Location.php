<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'kelurahan',
        'kecamatan',
        'latitude',
        'longitude',
        'type',
        'description',
        'phone',
        'opening_hours',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'baznas' => 'BAZNAS',
            'upz' => 'UPZ / Masjid',
            'warga' => 'Rumah Warga',
            default => ucfirst($this->type),
        };
    }

    public function typeColor(): string
    {
        return match ($this->type) {
            'baznas' => '#10b981',
            'upz' => '#f97316',
            'warga' => '#ef4444',
            default => '#6b7280',
        };
    }
}
