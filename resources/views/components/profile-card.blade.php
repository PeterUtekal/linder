@props(['profile' => null, 'preview' => false])

<div class="card bg-white shadow-xl rounded-3xl overflow-hidden w-full max-w-sm mx-auto">
    <!-- Photo section -->
    <div class="relative h-80 overflow-hidden">
        @if($profile && $profile->photo_url)
            <img src="{{ $profile->photo_url }}" class="w-full h-full object-cover" alt="{{ $profile->name }}" />
        @elseif($preview)
            <div class="w-full h-full bg-gradient-to-br from-pink-200 to-orange-200 flex items-center justify-center">
                <div class="text-6xl">👤</div>
            </div>
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                <div class="text-6xl opacity-50">📸</div>
            </div>
        @endif
        
        <!-- Gradient overlay for text readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        <!-- Name and age at bottom of photo -->
        <div class="absolute bottom-4 left-4 right-4">
            <h2 class="text-white text-2xl font-bold mb-1">
                @if($profile)
                    {{ $profile->name }}@if($profile->age), {{ $profile->age }}@endif wants to hangout
                @else
                    Your Name, Age wants to hangout
                @endif
            </h2>
        </div>
    </div>
    
    <!-- Info section -->
    <div class="p-6">
        <div class="mb-4">
            <p class="text-gray-700 text-base leading-relaxed">
                @if($profile && $profile->message)
                    {{ $profile->message }}
                @else
                    Your personal message will appear here to introduce yourself to potential connections.
                @endif
            </p>
            
            @if($profile && $profile->location)
                <p class="text-gray-500 text-sm mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    {{ $profile->location }}
                </p>
            @elseif($preview)
                <p class="text-gray-500 text-sm mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Your location
                </p>
            @endif
        </div>
        
        @if($preview)
            <!-- Preview contact section -->
            <div class="alert alert-info">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <div class="font-bold">Swipe right to connect!</div>
                    <div class="text-sm">Your contact info will be revealed when someone likes your profile</div>
                </div>
            </div>
        @endif
    </div>
</div>
