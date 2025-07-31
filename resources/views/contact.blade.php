<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.match_title') }} - {{ $profile->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
</head>
<body class="bg-primary min-h-screen" x-data="contactPage()">

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-sm">
        
        <!-- Success animation -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-success/20 rounded-full mb-4">
                <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('app.match_title') }}</h1>
            <p class="text-gray-600">{{ $profile->name }} {{ __('app.likes_you_too') }}</p>
        </div>

        <!-- AI Generated Pickup Line -->
        <div class="card bg-gradient-to-br from-pink-50 to-orange-50 shadow-xl mb-6 animate-fade-in" style="animation-delay: 0.2s">
            <div class="card-body">
                <div class="flex items-center gap-2 mb-3">
                    <div class="badge badge-secondary badge-sm">AI Generated</div>
                    <span class="text-sm font-semibold text-gray-700">{{ __('app.pickup_line_for_you') }}</span>
                </div>
                <p class="text-lg font-medium text-gray-900 italic" x-text="pickupLine">
                    {{ __('app.loading_pickup_line') }}
                </p>
                <div class="text-right mt-4">
                    <button @click="regeneratePickupLine()" class="btn btn-sm btn-ghost" :disabled="loading">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('app.regenerate') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Contact Info Card -->
        <div class="card bg-white shadow-xl animate-fade-in" style="animation-delay: 0.4s">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">{{ __('app.contact_now') }}</h2>
                
                <div class="space-y-4">
                    <!-- Profile info reminder -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        @if($profile->photo_url)
                            <img src="{{ $profile->photo_url }}" class="w-16 h-16 rounded-full object-cover" />
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-200 to-orange-200 flex items-center justify-center">
                                <div class="text-2xl">👤</div>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-lg">{{ $profile->name }}@if($profile->age), {{ $profile->age }}@endif</h3>
                            @if($profile->location)
                                <p class="text-sm text-gray-500">{{ $profile->location }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contact button -->
                    <div class="text-center">
                        @switch($profile->contact_type)
                            @case('tel')
                                <a href="tel:{{ $profile->contact_value }}" class="btn btn-primary btn-lg w-full gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ __('app.call_now') }} {{ $profile->contact_value }}
                                </a>
                                @break
                            @case('whatsapp')
                                <a href="https://wa.me/{{ $profile->contact_value }}?text={{ urlencode(__('app.whatsapp_message', ['name' => $profile->name])) }}" target="_blank" class="btn btn-primary btn-lg w-full gap-2">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/>
                                    </svg>
                                    {{ __('app.whatsapp_now') }}
                                </a>
                                @break
                            @case('instagram')
                                <a href="https://instagram.com/{{ $profile->contact_value }}" target="_blank" class="btn btn-primary btn-lg w-full gap-2">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                    </svg>
                                    {{ __('app.instagram_dm') }} @{{ $profile->contact_value }}
                                </a>
                                @break
                            @case('email')
                                <a href="mailto:{{ $profile->contact_value }}?subject={{ urlencode(__('app.email_subject', ['name' => $profile->name])) }}" class="btn btn-primary btn-lg w-full gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('app.email_now') }}
                                </a>
                                @break
                        @endswitch
                    </div>

                    <!-- Tips -->
                    <div class="divider">{{ __('app.tips') }}</div>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>💡 {{ __('app.tip_1') }}</p>
                        <p>🎯 {{ __('app.tip_2') }}</p>
                        <p>✨ {{ __('app.tip_3') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back link -->
        <div class="text-center mt-6">
            <a href="/p/{{ $profile->slug }}" class="link link-hover text-gray-600">{{ __('app.back_to_profile') }}</a>
        </div>
    </div>
</div>

<script>
function contactPage() {
    return {
        pickupLine: '{{ __('app.loading_pickup_line') }}',
        loading: false,
        profileData: {
            name: @json($profile->name),
            age: @json($profile->age),
            location: @json($profile->location),
            message: @json($profile->message)
        },
        
        async init() {
            await this.generatePickupLine();
        },
        
        async generatePickupLine() {
            this.loading = true;
            try {
                const response = await fetch('/api/generate-pickup-line', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.profileData)
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.pickupLine = data.pickup_line;
                } else {
                    this.pickupLine = this.getDefaultPickupLine();
                }
            } catch (error) {
                this.pickupLine = this.getDefaultPickupLine();
            }
            this.loading = false;
        },
        
        async regeneratePickupLine() {
            await this.generatePickupLine();
        },
        
        getDefaultPickupLine() {
            const lines = [
                "Hey {{ $profile->name }}, are you a magician? Because whenever I look at your profile, everyone else disappears! ✨",
                "Is your name Wi-Fi? Because I'm really feeling a connection! 📶",
                "Do you believe in love at first swipe? Or should I swipe right again? 😉",
                "Are you a time traveler? Because I can see you in my future! ⏰",
                "If you were a vegetable, you'd be a cute-cumber! 🥒"
            ];
            return lines[Math.floor(Math.random() * lines.length)];
        }
    }
}
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.8s cubic-bezier(.4,0,.2,1) both;
}
</style>
</body>
</html>