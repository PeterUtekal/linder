<?php

return [
    /*
    |--------------------------------------------------------------------------
    | LinkWMe Application Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options specific to the LinkWMe app.
    |
    */

    'supported_locales' => ['en', 'sk'],
    
    'default_locale' => env('LINKWME_DEFAULT_LOCALE', 'en'),
    
    'age' => [
        'min' => env('LINKWME_MIN_AGE', 18),
        'max' => env('LINKWME_MAX_AGE', 100),
    ],
    
    'profile' => [
        'max_photo_size' => env('LINKWME_MAX_PHOTO_SIZE', 2048), // in KB
        'max_message_length' => env('LINKWME_MAX_MESSAGE_LENGTH', 500),
        'slug_length' => env('LINKWME_SLUG_LENGTH', 6),
    ],
    
    'contact_types' => [
        'tel' => 'Phone',
        'whatsapp' => 'WhatsApp',
        'instagram' => 'Instagram',
        'email' => 'Email',
    ],
];