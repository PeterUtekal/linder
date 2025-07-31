<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class OpenAIRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'openai_rate_limit:' . ($request->ip() ?? 'unknown');
        $maxAttempts = 10;
        $decayMinutes = 1;
        
        // Get current attempts
        $attempts = Cache::get($key, 0);
        
        if ($attempts >= $maxAttempts) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => 60 // 1 minute
            ], HttpResponse::HTTP_TOO_MANY_REQUESTS);
        }

        // Increment attempts and set expiry
        Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));

        return $next($request);
    }
}
