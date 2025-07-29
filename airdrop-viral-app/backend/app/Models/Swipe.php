<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'is_right_swipe',
        'device_id',
        'ip_address',
        'user_agent',
        'referrer',
        'created_profile_after'
    ];

    protected $casts = [
        'is_right_swipe' => 'boolean',
        'created_profile_after' => 'boolean',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
