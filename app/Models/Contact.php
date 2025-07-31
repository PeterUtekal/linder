<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'mongodb';
    
    protected $collection = 'contacts';
    
    protected $fillable = [
        'profile_id',
        'name',
        'contact_type',
        'contact_value',
        'selfie_url',
        'message',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the profile this contact belongs to
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    
    /**
     * Get display name for contact type
     */
    public function getContactTypeDisplayAttribute(): string
    {
        return match($this->contact_type) {
            'instagram' => 'Instagram',
            'selfie' => 'Selfie',
            default => $this->contact_type
        };
    }
    
    /**
     * Check if contact has a selfie
     */
    public function hasSelfie(): bool
    {
        return $this->contact_type === 'selfie' && !empty($this->selfie_url);
    }
}