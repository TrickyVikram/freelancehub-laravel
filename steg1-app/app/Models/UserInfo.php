<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_info';

    protected $fillable = [
        'user_id',
        'phone',
        'bio',
        'avatar_url',
        'location',
        'website',
        'skills',
        'social_profiles',
    ];

    protected $casts = [
        'skills' => 'array',
        'social_profiles' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
