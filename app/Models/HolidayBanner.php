<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'name', 'event_date', 'before_days', 'after_days',
        'icon', 'color', 'title', 'text', 'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'before_days' => 'integer',
        'after_days' => 'integer',
        'is_active' => 'boolean',
    ];
}
