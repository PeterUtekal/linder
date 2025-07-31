<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class PickupLineController extends Controller
{
    public function __construct(
        private OpenAIService $openAIService
    ) {}

    public function generate(Request $request)
    {
        try {
            Log::info('PickupLine generation started', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'nullable|integer|min:18|max:100',
                'location' => 'nullable|string|max:255',
                'for_self' => 'nullable|boolean'
            ]);

            Log::info('Request validated', ['validated' => $validated]);

            $name = $validated['name'];
            $age = $validated['age'] ?? null;
            $location = $validated['location'] ?? null;
            $forSelf = $validated['for_self'] ?? false;

            Log::info('Calling OpenAI service', [
                'name' => $name,
                'age' => $age,
                'location' => $location,
                'for_self' => $forSelf
            ]);

            $pickupLine = $forSelf 
                ? $this->openAIService->generateSelfDescriptionLine($age, $location)
                : $this->openAIService->generatePickupLine($name, $age, $location);

            Log::info('OpenAI service completed', ['pickup_line' => $pickupLine]);

            return response()->json([
                'pickup_line' => $pickupLine
            ]);
            
        } catch (Exception $e) {
            Log::error('PickupLine generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'error' => 'Failed to generate pickup line',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
