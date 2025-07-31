<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ) {}

    public function store(StoreProfileRequest $request)
    {
        $profile = $this->profileService->create($request->validated());

        return response()->json([
            'slug' => $profile->slug,
            'url'  => url('/p/' . $profile->slug),
        ], 201);
    }

    public function show(string $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();

        return response()->json([
            'name' => $profile->name,
            'photo_url' => $profile->photo_url,
            'message' => $profile->message,
            'location' => $profile->location,
            'age' => $profile->age,
            'slug' => $profile->slug,
        ]);
    }

    public function swipe(Request $request, string $slug)
    {
        $validated = $request->validate([
            'direction' => 'required|in:left,right',
        ]);

        $profile = Profile::where('slug', $slug)->firstOrFail();
        
        $result = $this->profileService->recordSwipe(
            $profile,
            $validated['direction'],
            $request->ip()
        );

        if ($result['matched']) {
            return response()->json([
                'contact_type' => $result['contact_type'],
                'contact_value' => $result['contact_value'],
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}