<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Swipe;
use Illuminate\Http\Request;

class SwipeController extends Controller
{
    /**
     * Record a swipe action
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_code' => 'required|string|exists:profiles,short_code',
            'is_right_swipe' => 'required|boolean',
        ]);

        $profile = Profile::where('short_code', $validated['profile_code'])->firstOrFail();

        // Record swipe
        $swipe = Swipe::create([
            'profile_id' => $profile->id,
            'is_right_swipe' => $validated['is_right_swipe'],
            'device_id' => $request->header('X-Device-ID'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
        ]);

        // Update profile stats
        $profile->recordSwipe($validated['is_right_swipe']);

        $response = [
            'message' => $validated['is_right_swipe'] ? 'Match! Contact details revealed.' : 'Thanks for swiping!',
            'swipe_id' => $swipe->id,
        ];

        if ($validated['is_right_swipe']) {
            $response['contact'] = [
                'method' => $profile->contact_method,
                'value' => $profile->contact_value,
                'url' => $profile->getContactUrl(),
            ];
        }

        return response()->json($response);
    }

    /**
     * Mark that a user created a profile after swiping
     */
    public function markViralConversion(Request $request)
    {
        $validated = $request->validate([
            'swipe_id' => 'required|exists:swipes,id',
        ]);

        $swipe = Swipe::findOrFail($validated['swipe_id']);
        $swipe->update(['created_profile_after' => true]);

        return response()->json(['message' => 'Viral conversion recorded']);
    }

    /**
     * Get swipe analytics for a profile
     */
    public function analytics($profileCode)
    {
        $profile = Profile::where('short_code', $profileCode)->firstOrFail();

        $swipes = $profile->swipes()
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total_swipes')
            ->selectRaw('SUM(CASE WHEN is_right_swipe = true THEN 1 ELSE 0 END) as right_swipes')
            ->selectRaw('SUM(CASE WHEN created_profile_after = true THEN 1 ELSE 0 END) as viral_conversions')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return response()->json([
            'profile' => $profile->only(['name', 'location', 'created_at']),
            'daily_stats' => $swipes,
            'totals' => [
                'views' => $profile->view_count,
                'swipes' => $profile->swipe_count,
                'right_swipes' => $profile->right_swipe_count,
                'viral_conversions' => $profile->swipes()->where('created_profile_after', true)->count(),
            ],
        ]);
    }
}
