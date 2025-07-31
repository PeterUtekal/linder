<?php

namespace App\Models;


use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model as Model;

class Profile extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'profiles';

    protected $fillable = [
        'name',
        'photo_url',
        'message',
        'contact_type',
        'contact_value',
        'location',
        'age',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($profile) {
            if (empty($profile->slug)) {
                $profile->slug = self::generateUniqueSlug();
            }
        });
    }

    protected static function generateUniqueSlug(): string
    {
        $length = config('linkwme.profile.slug_length', 6);
        
        do {
            $slug = Str::lower(Str::random($length));
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }

    /**
     * Get the contacts for this profile
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}