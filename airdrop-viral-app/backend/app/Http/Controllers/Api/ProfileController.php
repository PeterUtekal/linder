<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($profiles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:5120', // 5MB max
            'message' => 'required|string|max:500',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contact_method' => 'required|in:whatsapp,instagram,phone',
            'contact_value' => 'required|string|max:255',
        ]);

        // Handle photo upload
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            try {
                $path = $request->file('photo')->store('profile-photos', 's3');
                if ($path === false || empty($path)) {
                    throw new \Exception('Failed to store file on S3');
                }
                $photoUrl = Storage::disk('s3')->url($path);
            } catch (\Exception $e) {
                Log::error('S3 upload failed: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Failed to upload photo. Please try again.',
                    'details' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Create profile
        $profile = Profile::create([
            'name' => $validated['name'],
            'photo_url' => $photoUrl,
            'message' => $validated['message'],
            'location' => $validated['location'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'contact_method' => $validated['contact_method'],
            'contact_value' => $validated['contact_value'],
            'device_id' => $request->header('X-Device-ID'),
            'ip_address' => $request->ip(),
        ]);

        // Generate QR code
        $qrCodeUrl = $this->generateQrCode($profile);
        $profile->update(['qr_code_url' => $qrCodeUrl]);

        return response()->json([
            'profile' => $profile,
            'share_url' => $profile->getShareUrl(),
            'airdrop_name' => $profile->getAirdropName(),
        ], 201);
    }

    /**
     * Display the specified resource by short code.
     */
    public function showByCode($shortCode)
    {
        $profile = Profile::where('short_code', $shortCode)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $profile->incrementView();

        return response()->json([
            'profile' => $profile->only([
                'name',
                'photo_url',
                'message',
                'location',
                'short_code'
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::findOrFail($id);

        return response()->json($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        // Verify ownership
        if ($profile->device_id !== $request->header('X-Device-ID')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'photo' => 'sometimes|image|max:5120',
            'message' => 'sometimes|string|max:500',
            'location' => 'sometimes|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contact_method' => 'sometimes|in:whatsapp,instagram,phone',
            'contact_value' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            try {
                // Delete old photo if exists
                if ($profile->photo_url) {
                    $oldPath = str_replace(Storage::disk('s3')->url(''), '', $profile->photo_url);
                    Storage::disk('s3')->delete($oldPath);
                }

                $path = $request->file('photo')->store('profile-photos', 's3');
                if ($path === false || empty($path)) {
                    throw new \Exception('Failed to store file on S3');
                }
                $validated['photo_url'] = Storage::disk('s3')->url($path);
            } catch (\Exception $e) {
                Log::error('S3 upload failed during update: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Failed to upload photo. Please try again.',
                    'details' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        $profile->update($validated);

        return response()->json($profile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        // Verify ownership
        if ($profile->device_id !== $request->header('X-Device-ID')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Soft delete by marking as inactive
        $profile->update(['is_active' => false]);

        return response()->json(['message' => 'Profile deactivated successfully']);
    }

    /**
     * Get profile statistics
     */
    public function stats($shortCode)
    {
        $profile = Profile::where('short_code', $shortCode)->firstOrFail();

        return response()->json([
            'view_count' => $profile->view_count,
            'swipe_count' => $profile->swipe_count,
            'right_swipe_count' => $profile->right_swipe_count,
            'match_rate' => $profile->swipe_count > 0
                ? round(($profile->right_swipe_count / $profile->swipe_count) * 100, 1)
                : 0,
        ]);
    }

    /**
     * Generate QR code for profile
     */
    private function generateQrCode(Profile $profile)
    {
        try {
            $qrCode = new QrCode($profile->getShareUrl());
            $qrCode->setSize(300);
            $qrCode->setMargin(10);
            $qrCode->setForegroundColor(new Color(0, 0, 0));
            $qrCode->setBackgroundColor(new Color(255, 255, 255));

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $filename = 'qr-codes/' . $profile->short_code . '.png';
            $stored = Storage::disk('s3')->put($filename, $result->getString());

            if (!$stored) {
                throw new \Exception('Failed to store QR code on S3');
            }

            return Storage::disk('s3')->url($filename);
        } catch (\Exception $e) {
            Log::error('Failed to generate or store QR code: ' . $e->getMessage());
            // Return null or a default URL - the profile can still be created without QR code
            return null;
        }
    }
}
