@extends('layouts.app')

@section('content')
    <div class="text-center space-y-4">
        <h1 class="text-3xl font-bold">Link Created!</h1>
        <p class="text-lg">Share this link with people around you:</p>
        <div class="flex justify-center">
            <input type="text" class="input input-bordered w-full max-w-md" value="{{ $shareUrl }}" readonly onclick="this.select()" />
        </div>
        <a href="{{ $shareUrl }}" class="btn btn-secondary">Open Link</a>
    </div>
@endsection