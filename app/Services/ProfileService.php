<?php

namespace App\Services;

use App\Models\Profile;
use App\Events\ProfileCreated;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Create a new profile
     */
    public function create(array $data): Profile
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $path = $data['photo']->store('public/photos');
            $data['photo_url'] = Storage::url($path);
            unset($data['photo']);
        }

        $profile = Profile::create($data);
        
        event(new ProfileCreated($profile));
        
        return $profile;
    }

    /**
     * Record a swipe action on a profile
     */
    public function recordSwipe(Profile $profile, string $direction, string $ip): array
    {
        $profile->push('swipes', [
            'direction' => $direction,
            'ip' => $ip,
            'created_at' => now(),
        ]);

        if ($direction === 'right') {
            return [
                'matched' => true,
                'contact_type' => $profile->contact_type,
                'contact_value' => $profile->contact_value,
            ];
        }

        return ['matched' => false];
    }

    /**
     * Get profile statistics
     */
    public function getStats(Profile $profile): array
    {
        $swipes = collect($profile->swipes ?? []);
        
        return [
            'total_swipes' => $swipes->count(),
            'right_swipes' => $swipes->where('direction', 'right')->count(),
            'left_swipes' => $swipes->where('direction', 'left')->count(),
            'unique_visitors' => $swipes->pluck('ip')->unique()->count(),
        ];
    }
}