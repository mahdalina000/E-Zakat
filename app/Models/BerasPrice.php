<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerasPrice extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'updated_by', 'note'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function current(): ?self
    {
        return self::latest('id')->first();
    }

    public static function currentPrice(): int
    {
        return self::current()?->price ?? 16000;
    }
}
