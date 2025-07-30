<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\Api\SwipeController as ApiSwipeController;

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

Route::get('/', [LinkController::class, 'create'])->name('home');
Route::post('/', [LinkController::class, 'store'])->name('link.store');
Route::get('/p/{shortCode}', [LinkController::class, 'show'])->name('profile.view');
Route::get('/success/{shortCode}', [LinkController::class, 'success'])->name('profile.success');

// Handle swipe post (AJAX)
Route::post('/swipe/{shortCode}', [ApiSwipeController::class, 'store'])->name('swipe.store');
