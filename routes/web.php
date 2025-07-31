<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileWebController;

Route::get('/', [ProfileWebController::class, 'create']);
Route::get('/create', [ProfileWebController::class, 'create']);
Route::get('/add-to-home', function () {
    return view('add-to-home');
});
Route::get('/p/{slug}', [ProfileWebController::class, 'show']);
