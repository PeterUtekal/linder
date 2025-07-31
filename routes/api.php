<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PickupLineController;
use App\Http\Controllers\API\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Profile routes
Route::post('/profiles', [ProfileController::class, 'store']);
Route::get('/profiles/{slug}', [ProfileController::class, 'show']);
Route::post('/profiles/{slug}/swipe', [ProfileController::class, 'swipe']);

// Contact submission
Route::post('/profiles/{slug}/contact', [ContactController::class, 'submit']);

// Pickup line generation (with rate limiting)
Route::post('/generate-pickup-line', [PickupLineController::class, 'generate'])->middleware('openai.ratelimit');
