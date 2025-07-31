<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>Profile Ready - Linder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-base-100 min-h-screen">
<div x-data="addToHomeData()" class="min-h-screen p-4">
    
    <div class="max-w-md mx-auto">
        <!-- Big success text -->
        <div class="text-center mb-8 mt-12">
            <h1 class="text-5xl font-extrabold leading-tight text-center mb-8">
                {{ __('app.add_home_success') }}
            </h1>
        </div>

        <!-- CTA to Add to home screen -->
        <div class="mb-6">
            <button 
                class="btn btn-primary btn-lg w-full text-lg font-bold"
                @click="shareProfile()"
            >
                {{ __('app.add_home_title') }}
            </button>
        </div>

        <!-- Small grey instructions link -->
        <div class="text-center mb-8">
            <a href="/instructions" class="link link-neutral text-sm opacity-70">
                {{ __('app.add_home_how') }} →
            </a>
        </div>

        <!-- Profile card preview -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-center mb-4 opacity-70">Preview</h3>
            
            <template x-if="loading">
                <div class="card bg-white shadow-xl rounded-3xl overflow-hidden w-full max-w-sm mx-auto">
                    <div class="h-80 bg-base-200 animate-pulse"></div>
                    <div class="p-6">
                        <div class="h-4 bg-base-200 rounded animate-pulse mb-2"></div>
                        <div class="h-4 bg-base-200 rounded animate-pulse w-3/4"></div>
                    </div>
                </div>
            </template>
            
            <template x-if="!loading && profile">
                <div class="card bg-white shadow-xl rounded-3xl overflow-hidden w-full max-w-sm mx-auto">
                    <!-- Photo section -->
                    <div class="relative h-80 overflow-hidden">
                        <template x-if="profile.photo_url">
                            <img :src="profile.photo_url" class="w-full h-full object-cover" :alt="profile.name" />
                        </template>
                        <template x-if="!profile.photo_url">
                            <div class="w-full h-full bg-gradient-to-br from-pink-200 to-orange-200 flex items-center justify-center">
                                <div class="text-6xl">👤</div>
                            </div>
                        </template>
                        
                        <!-- Gradient overlay for text readability -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Name and age at bottom of photo -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <h2 class="text-white text-2xl font-bold mb-1" x-text="`${profile.name}${profile.age ? ', ' + profile.age : ''} {{ __('app.profile_wants_hangout') }}`"></h2>
                        </div>
                    </div>
                    
                    <!-- Info section -->
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-gray-700 text-base leading-relaxed" x-text="profile.message || 'Your personal message will appear here to introduce yourself to potential connections.'"></p>
                            
                            <template x-if="profile.location">
                                <p class="text-gray-500 text-sm mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span x-text="profile.location"></span>
                                </p>
                            </template>
                        </div>
                        
                        <!-- Preview contact section -->
                        <div class="alert alert-info">
                            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="font-bold">{{ __('app.swipe_like') }}!</div>
                                <div class="text-sm">{{ __('app.swipe_info') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
            <template x-if="!loading && !profile">
                <x-profile-card :preview="true" />
            </template>
        </div>
    </div>
</div>

<script>
function addToHomeData() {
    return {
        profileUrl: new URLSearchParams(window.location.search).get('url') || '{{ $profileUrl ?? 'https://yoursite.com/profile/123' }}',
        profile: null,
        loading: true,
        
        async init() {
            await this.fetchProfile();
        },
        
        async fetchProfile() {
            try {
                const profileId = this.profileUrl.split('/').pop();
                const response = await fetch(`/api/profiles/${profileId}`);
                if (response.ok) {
                    this.profile = await response.json();
                }
            } catch (error) {
                console.error('Error fetching profile:', error);
            } finally {
                this.loading = false;
            }
        },
        
        shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: 'Add to Home Screen',
                    url: this.profileUrl
                }).catch(() => {});
            } else {
                alert('Copy this link and add it to your home screen: ' + this.profileUrl);
            }
        }
    }
}
</script>
</body>
</html>
               