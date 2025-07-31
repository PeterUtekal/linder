<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PickupLineController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:18|max:100',
            'location' => 'nullable|string|max:255',
            'for_self' => 'nullable|boolean'
        ]);

        $name = $validated['name'];
        $forSelf = $validated['for_self'] ?? false;

        $pickupLine = $forSelf 
            ? $this->getSelfDescriptionLine() 
            : $this->getPickupLineForName($name);

        return response()->json([
            'pickup_line' => $pickupLine
        ]);
    }

    private function getPickupLineForName(string $name): string
    {
        $lines = [
            "Hey {$name}, are you a magician? Because whenever I look at your profile, everyone else disappears! ✨",
            "Is your name Wi-Fi? Because I'm really feeling a connection with you, {$name}! 📶",
            "{$name}, do you believe in love at first swipe? Or should I swipe right again? 😉",
            "Are you a time traveler, {$name}? Because I can see you in my future! ⏰",
            "If you were a vegetable, {$name}, you'd be a cute-cumber! 🥒",
            "Excuse me {$name}, but I think you dropped something: my jaw! 😮",
            "Are you made of copper and tellurium? Because you're Cu-Te, {$name}! 🧪",
            "{$name}, on a scale of 1 to 10, you're a 9 and I'm the 1 you need! 💯"
        ];

        return $lines[array_rand($lines)];
    }

    private function getSelfDescriptionLine(): string
    {
        $lines = [
            "Looking for someone who appreciates good conversation and bad jokes! 😄",
            "Swipe right if you think pineapple belongs on pizza! 🍕",
            "Let's skip the small talk and plan our first adventure! 🗺️",
            "Professional overthinker seeking someone to distract me! 🤔",
            "Warning: May spontaneously suggest midnight ice cream runs! 🍦",
            "Life's too short for boring conversations. Let's make it interesting! ✨",
            "Looking for my partner in wine... I mean crime! 🍷",
            "Fluent in sarcasm and movie quotes. You've been warned! 🎬"
        ];

        return $lines[array_rand($lines)];
    }
}
