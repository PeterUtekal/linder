<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PickupLineController;

Route::post('/profiles', [ProfileController::class, 'store']);
Route::get('/profiles/{slug}', [ProfileController::class, 'show']);
Route::post('/profiles/{slug}/swipe', [ProfileController::class, 'swipe']);

Route::post('/generate-pickup-line', [PickupLineController::class, 'generate']);
