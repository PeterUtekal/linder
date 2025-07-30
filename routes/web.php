<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'create');
Route::view('/create', 'create');

use App\Models\Profile;

Route::get('/p/{slug}', function (string $slug) {
    $profile = Profile::where('slug', $slug)->firstOrFail()->toArray();
    return view('profile', ['profile' => $profile]);
});
