<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:3072', // 3MB
            'message' => 'required|string|max:1024',
            'contact_type' => 'required|string|in:tel,wa,ig,email,url',
            'contact_value' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo_url'] = Storage::disk('public')->url($path);
        }

        $profile = Profile::create($validated);

        $url = url('/p/'.$profile->slug);

        return response()->json([
            'slug' => $profile->slug,
            'url' => $url,
        ], 201);
    }

    public function show(string $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();

        // Exclude contact info by default
        $data = $profile->only(['name', 'photo_url', 'message', 'location', 'slug']);

        return response()->json($data);
    }

    public function swipe(Request $request, string $slug)
    {
        $validated = $request->validate([
            'direction' => 'required|in:left,right',
        ]);

        $profile = Profile::where('slug', $slug)->firstOrFail();

        // Record swipe analytics - simple increment fields
        $field = $validated['direction'] === 'right' ? 'right_swipes' : 'left_swipes';
        $profile->increment($field);

        // On right swipe, reveal contact info
        if ($validated['direction'] === 'right') {
            return response()->json([
                'contact_type' => $profile->contact_type,
                'contact_value' => $profile->contact_value,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}