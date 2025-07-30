<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo_url',
        'message',
        'location',
        'latitude',
        'longitude',
        'contact_method',
        'contact_value',
        'short_code',
        'qr_code_url',
        'view_count',
        'swipe_count',
        'right_swipe_count',
        'is_active',
        'device_id',
        'ip_address'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'view_count' => 'integer',
        'swipe_count' => 'integer',
        'right_swipe_count' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            // Generate unique short code
            do {
                $shortCode = Str::random(6);
            } while (self::where('short_code', $shortCode)->exists());
            
            $profile->short_code = $shortCode;
        });
    }

    public function swipes()
    {
        return $this->hasMany(Swipe::class);
    }

    public function incrementView()
    {
        $this->increment('view_count');
    }

    public function recordSwipe($isRightSwipe)
    {
        $this->increment('swipe_count');
        if ($isRightSwipe) {
            $this->increment('right_swipe_count');
        }
    }

    public function getShareUrl()
    {
        return config('app.url') . '/p/' . $this->short_code;
    }

    public function getContactUrl()
    {
        switch ($this->contact_method) {
            case 'whatsapp':
                return 'https://wa.me/' . preg_replace('/[^0-9]/', '', $this->contact_value);
            case 'instagram':
                return 'https://instagram.com/' . $this->contact_value;
            case 'phone':
                return 'tel:' . $this->contact_value;
            default:
                return $this->contact_value;
        }
    }

    public function getAirdropName()
    {
        return "{$this->name} likes you at {$this->location}";
    }
}
