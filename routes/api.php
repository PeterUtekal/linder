<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;

Route::post('/profiles', [ProfileController::class, 'store']);
Route::get('/profiles/{slug}', [ProfileController::class, 'show']);
Route::post('/profiles/{slug}/swipe', [ProfileController::class, 'swipe']);