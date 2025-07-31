<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get supported locales from config
        $supportedLocales = config('linkwme.supported_locales', ['en']);
        
        // Check if locale is in session
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } else {
            // Get browser languages
            $browserLangs = $request->getLanguages();
            
            // Find first supported language
            $locale = 'en'; // default
            foreach ($browserLangs as $lang) {
                // Extract language code (e.g., 'sk' from 'sk-SK')
                $langCode = substr($lang, 0, 2);
                if (in_array($langCode, $supportedLocales)) {
                    $locale = $langCode;
                    break;
                }
            }
            
            // Store in session
            $request->session()->put('locale', $locale);
        }
        
        // Set application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}