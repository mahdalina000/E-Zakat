<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'logged_in_at'];

    protected $casts = [
        'logged_in_at' => 'datetime',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function pruneToLatest(int $limit = 50): void
    {
        if (static::count() <= $limit) {
            return;
        }
        $keep = static::orderByDesc('id')->take($limit)->pluck('id');
        static::whereNotIn('id', $keep)->delete();
    }
}
