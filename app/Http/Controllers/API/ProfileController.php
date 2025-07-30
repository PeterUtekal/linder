<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'message' => 'nullable|string|max:500',
            'contact_type' => 'required|string|max:50',
            'contact_value' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/photos');
            $validated['photo_url'] = Storage::url($path);
        }

        $profile = Profile::create($validated);

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
            'slug' => $profile->slug,
        ]);
    }

    public function swipe(Request $request, string $slug)
    {
        $validated = $request->validate([
            'direction' => 'required|in:left,right',
        ]);

        $profile = Profile::where('slug', $slug)->firstOrFail();

        $profile->push('swipes', [
            'direction'   => $validated['direction'],
            'ip'          => $request->ip(),
            'created_at'  => now(),
        ]);

        if ($validated['direction'] === 'right') {
            return response()->json([
                'contact_type' => $profile->contact_type,
                'contact_value' => $profile->contact_value,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}