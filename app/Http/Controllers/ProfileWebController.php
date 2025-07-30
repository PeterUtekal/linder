<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileWebController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function show(string $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();

        return view('profile', compact('profile'));
    }
}