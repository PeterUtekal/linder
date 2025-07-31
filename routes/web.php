<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileWebController;
use App\Http\Controllers\LocaleController;

Route::get('/', [ProfileWebController::class, 'create']);
Route::get('/create', [ProfileWebController::class, 'create']);
Route::get('/add-to-home', function () {
    return view('add-to-home');
});
Route::get('/p/{slug}', [ProfileWebController::class, 'show']);
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
