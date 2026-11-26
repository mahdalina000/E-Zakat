<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkmResponse extends Model
{
    protected $fillable = ['user_id', 'answers', 'comment'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
