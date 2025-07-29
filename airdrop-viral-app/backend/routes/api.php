<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SwipeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Profile routes
Route::apiResource('profiles', ProfileController::class);
Route::get('profiles/code/{shortCode}', [ProfileController::class, 'showByCode']);
Route::get('profiles/{shortCode}/stats', [ProfileController::class, 'stats']);

// Swipe routes
Route::post('swipes', [SwipeController::class, 'store']);
Route::post('swipes/viral-conversion', [SwipeController::class, 'markViralConversion']);
Route::get('swipes/analytics/{profileCode}', [SwipeController::class, 'analytics']);
