<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

class Profile extends Eloquent
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
        'slug',
        'left_swipes',
        'right_swipes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug();
            }

            $model->left_swipes = 0;
            $model->right_swipes = 0;
        });
    }

    private static function generateUniqueSlug(): string
    {
        do {
            $slug = Str::random(8);
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }
}