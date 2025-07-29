<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page - Create profile
Route::get('/', function () {
    return Inertia::render('CreateProfile');
})->name('home');

// View profile by short code
Route::get('/p/{shortCode}', function ($shortCode) {
    $profile = Profile::where('short_code', $shortCode)
        ->where('is_active', true)
        ->firstOrFail();
    
    return Inertia::render('ViewProfile', [
        'profile' => $profile->only(['name', 'photo_url', 'message', 'location', 'short_code']),
    ]);
})->name('profile.view');

// Success page after creating profile
Route::get('/success/{shortCode}', function ($shortCode) {
    $profile = Profile::where('short_code', $shortCode)
        ->where('is_active', true)
        ->firstOrFail();
    
    return Inertia::render('Success', [
        'profile' => $profile,
        'shareUrl' => $profile->getShareUrl(),
        'airdropName' => $profile->getAirdropName(),
    ]);
})->name('profile.success');

// Analytics page
Route::get('/analytics/{shortCode}', function ($shortCode) {
    $profile = Profile::where('short_code', $shortCode)
        ->where('is_active', true)
        ->firstOrFail();
    
    return Inertia::render('Analytics', [
        'profileCode' => $shortCode,
    ]);
})->name('profile.analytics');
