<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(Request $request, string $locale)
    {
        $supportedLocales = ['en', 'sk'];
        
        if (in_array($locale, $supportedLocales)) {
            $request->session()->put('locale', $locale);
            App::setLocale($locale);
        }
        
        return redirect()->back();
    }
}