<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    private $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.api_key'));
    }

    /**
     * Generate a pickup line based on the provided information
     */
    public function generatePickupLine(string $name, ?int $age = null, ?string $location = null): string
    {
        $cacheKey = 'pickup_line_' . md5($name . ($age ?? '') . ($location ?? ''));
        
        // Check cache first to avoid unnecessary API calls
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $prompt = $this->buildPickupLinePrompt($name, $age, $location);
            
            $response = $this->client->chat()->create([
                'model' => config('openai.default_model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a witty and charming assistant that creates clever, respectful, and fun pickup lines for dating apps. Keep them light-hearted, appropriate, and engaging. Always include relevant emojis to make them more playful.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => config('openai.max_tokens'),
                'temperature' => config('openai.temperature'), // Higher creativity
            ]);

            $pickupLine = trim($response->choices[0]->message->content);
            
            // Cache the result for configured time
            Cache::put($cacheKey, $pickupLine, config('openai.cache_ttl'));
            
            return $pickupLine;
            
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            
            // Fallback to predefined pickup lines
            return $this->getFallbackPickupLine($name);
        }
    }

    /**
     * Generate a self-description line for user profiles
     */
    public function generateSelfDescriptionLine(?int $age = null, ?string $location = null): string
    {
        $cacheKey = 'self_description_' . md5(($age ?? '') . ($location ?? ''));
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $prompt = $this->buildSelfDescriptionPrompt($age, $location);
            
            $response = $this->client->chat()->create([
                'model' => config('openai.default_model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a creative assistant that helps people write engaging and authentic bio/description lines for their dating profiles. Make them fun, genuine, and appealing while avoiding clichés. Include relevant emojis.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => config('openai.max_tokens'),
                'temperature' => config('openai.temperature') * 0.9, // Slightly less creative for bios
            ]);

            $description = trim($response->choices[0]->message->content);
            
            Cache::put($cacheKey, $description, config('openai.cache_ttl'));
            
            return $description;
            
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            
            return $this->getFallbackSelfDescription();
        }
    }

    /**
     * Build the prompt for pickup line generation
     */
    private function buildPickupLinePrompt(string $name, ?int $age, ?string $location): string
    {
        $prompt = "Create a creative and charming pickup line for someone named {$name}";
        
        if ($age) {
            $prompt .= " who is {$age} years old";
        }
        
        if ($location) {
            $prompt .= " from {$location}";
        }
        
        $prompt .= ". Make it witty, respectful, and dating-app appropriate. Include the person's name and add relevant emojis.";
        
        return $prompt;
    }

    /**
     * Build the prompt for self-description generation
     */
    private function buildSelfDescriptionPrompt(?int $age, ?string $location): string
    {
        $prompt = "Create an engaging and authentic bio line for a dating profile";
        
        if ($age) {
            $prompt .= " for someone who is {$age} years old";
        }
        
        if ($location) {
            $prompt .= " living in {$location}";
        }
        
        $prompt .= ". Make it fun, genuine, and appealing. Include relevant emojis and avoid clichés.";
        
        return $prompt;
    }

    /**
     * Fallback pickup lines when OpenAI is unavailable
     */
    private function getFallbackPickupLine(string $name): string
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

    /**
     * Fallback self-description lines when OpenAI is unavailable
     */
    private function getFallbackSelfDescription(): string
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
