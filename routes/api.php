<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;

Route::post('/profiles', [ProfileController::class, 'store']);
Route::get('/profiles/{slug}', [ProfileController::class, 'show']);
Route::post('/profiles/{slug}/swipe', [ProfileController::class, 'swipe']);
Route::post('/profiles/{slug}/contact', [ProfileController::class, 'submitContact']);

// Pickup line generation
Route::post('/generate-pickup-line', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string',
        'age' => 'nullable|integer',
        'location' => 'nullable|string',
        'for_self' => 'nullable|boolean'
    ]);
    
    $name = $request->name;
    $forSelf = $request->for_self ?? false;
    
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
    
    if ($forSelf) {
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
    }
    
    return response()->json([
        'pickup_line' => $lines[array_rand($lines)]
    ]);
});

// Pickup line generation
Route::post('/generate-pickup-line', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string',
        'age' => 'nullable|integer',
        'location' => 'nullable|string',
        'for_self' => 'nullable|boolean'
    ]);
    
    $name = $request->name;
    $forSelf = $request->for_self ?? false;
    
    $lines = [
        "Hey {$name}, are you a magician? Because whenever I look at your profile, everyone else disappears! ✨",
        "Is your name Wi-Fi? Because I'm really feeling a connection with you, {$name}! 📶",
        "{$name}, do you believe in love at first swipe? Or should I swipe right again? 😉",
        "Are you a time traveler, {$name}? Because I can see you in my future! ⏰",
        "If you were a vegetable, {$name}, you'd be a cute-cumber! 🥒"
    ];
    
    if ($forSelf) {
        $lines = [
            "Looking for someone who appreciates good conversation and bad jokes! 😄",
            "Swipe right if you think pineapple belongs on pizza! 🍕",
            "Let's skip the small talk and plan our first adventure! 🗺️",
            "Professional overthinker seeking someone to distract me! 🤔",
            "Warning: May spontaneously suggest midnight ice cream runs! 🍦"
        ];
    }
    
    return response()->json([
        'pickup_line' => $lines[array_rand($lines)]
    ]);
});

// Contact submission
Route::post('/profiles/{slug}/contact', function (\Illuminate\Http\Request $request, $slug) {
    $request->validate([
        'name' => 'required|string',
        'contact_type' => 'required|in:instagram,selfie',
        'contact_value' => 'required_if:contact_type,instagram',
        'selfie' => 'required_if:contact_type,selfie|image',
        'message' => 'nullable|string'
    ]);
    
    // Here you would normally:
    // 1. Find the profile by slug
    // 2. Send SMS/Email to profile owner
    // 3. Store the contact attempt
    
    return response()->json(['success' => true]);
});
