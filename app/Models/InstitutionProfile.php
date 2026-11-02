<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionProfile extends Model
{
    protected $fillable = [
        'user_id',
        'institution_type',
        'institution_name',
        'alias',
        'address',
        'phone',
        'public_email',
        'description',
        'website',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
