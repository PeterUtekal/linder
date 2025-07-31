<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenAI;

class PickupLineController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'nullable|integer',
            'location' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        try {
            $apiKey = config('services.openai.key');
            
            if (!$apiKey) {
                // Return a default pickup line if OpenAI is not configured
                return response()->json([
                    'pickup_line' => $this->getDefaultPickupLine($request->name)
                ]);
            }

            $client = OpenAI::client($apiKey);
            
            $prompt = $this->buildPrompt($request);
            
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a witty and charming assistant that creates personalized, fun, and respectful pickup lines. Keep them light-hearted, creative, and appropriate.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 100,
                'temperature' => 0.8,
            ]);

            $pickupLine = $response['choices'][0]['message']['content'];
            
            return response()->json([
                'pickup_line' => trim($pickupLine)
            ]);
            
        } catch (\Exception $e) {
            // Fallback to default pickup line on error
            return response()->json([
                'pickup_line' => $this->getDefaultPickupLine($request->name)
            ]);
        }
    }

    private function buildPrompt(Request $request): string
    {
        $prompt = "Create a fun and charming pickup line for someone named {$request->name}";
        
        if ($request->age) {
            $prompt .= " who is {$request->age} years old";
        }
        
        if ($request->location) {
            $prompt .= " from {$request->location}";
        }
        
        if ($request->message) {
            $prompt .= ". Their profile says: \"{$request->message}\"";
        }
        
        $prompt .= ". Make it personalized, creative, and respectful. Keep it under 30 words.";
        
        return $prompt;
    }

    private function getDefaultPickupLine(string $name): string
    {
        $lines = [
            "Hey {$name}, are you a magician? Because whenever I look at your profile, everyone else disappears! ✨",
            "Is your name Wi-Fi? Because I'm really feeling a connection with you, {$name}! 📶",
            "{$name}, do you believe in love at first swipe? Or should I swipe right again? 😉",
            "Are you a time traveler, {$name}? Because I can see you in my future! ⏰",
            "If you were a vegetable, {$name}, you'd be a cute-cumber! 🥒"
        ];
        
        return $lines[array_rand($lines)];
    }
}
