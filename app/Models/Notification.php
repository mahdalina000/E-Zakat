<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'message', 'link', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Pesan/title disimpan sebagai kunci terjemahan (atau JSON berparameter).
     * Aksesor ini mengembalikan teks sesuai bahasa aktif.
     */
    public function getLocalizedTitleAttribute()
    {
        return __($this->title);
    }

    public function getLocalizedMessageAttribute()
    {
        if (!$this->message) {
            return '';
        }
        $decoded = json_decode($this->message, true);
        if (is_array($decoded) && isset($decoded['k'])) {
            return __($decoded['k'], $decoded['p'] ?? []);
        }
        return __($this->message);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
