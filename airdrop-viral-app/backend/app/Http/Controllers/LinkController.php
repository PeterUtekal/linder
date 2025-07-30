<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Show form to create profile / link
     */
    public function create()
    {
        return view('home');
    }

    /**
     * Store new profile and redirect to success page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'contact_method' => 'required|in:whatsapp,instagram,phone',
            'contact_value' => 'required|string|max:255',
        ]);

        $profile = Profile::create($validated + [
            'location' => $request->input('location'),
            'is_active' => true,
            'device_id' => $request->header('X-Device-ID'),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('profile.success', ['shortCode' => $profile->short_code]);
    }

    /**
     * Show the main swipe page for a profile
     */
    public function show($shortCode)
    {
        $profile = Profile::where('short_code', $shortCode)->where('is_active', true)->firstOrFail();
        $profile->incrementView();
        return view('swipe', ['profile' => $profile]);
    }

    /**
     * Success page after profile created
     */
    public function success($shortCode)
    {
        $profile = Profile::where('short_code', $shortCode)->firstOrFail();
        return view('success', [
            'profile' => $profile,
            'shareUrl' => $profile->getShareUrl(),
        ]);
    }
}