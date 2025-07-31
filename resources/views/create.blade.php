<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

</head>
<body class="bg-base-100 h-screen overflow-hidden">
<!-- Language Switcher -->
<div class="absolute top-4 right-4 z-10">
    <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-sm btn-ghost">
            @if(app()->getLocale() == 'sk')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 2v6H6.83a8.005 8.005 0 0 1 10.34 0H12zm0 8h5.17a8.005 8.005 0 0 1-10.34 0H12zm0-2V4a8 8 0 0 1 0 16v-6z"/></svg>
                SK
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/></svg>
                EN
            @endif
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/></svg>
        </label>
        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-32">
            <li><a href="{{ route('locale.switch', 'en') }}">🇬🇧 English</a></li>
            <li><a href="{{ route('locale.switch', 'sk') }}">🇸🇰 Slovenčina</a></li>
        </ul>
    </div>
</div>
<div x-data="profileForm()" class="h-screen flex flex-col max-w-screen mx-auto">
    <!-- Scrollable content area -->
    <div class="flex-1 overflow-y-auto">
        <div class="hero min-h-full bg-base-100">
            <div class="hero-content flex-col lg:flex-row-reverse p-4 w-full max-w-md mt-12">
                <div class="w-full">
                    <h2 class="text-5xl font-extrabold leading-tight mb-3 text-center">{{ __('app.tagline') }} <br> {{ __('app.tagline_just') }} <span class="text-primary">{{ __('app.tagline_link') }}</span>. <br> <span class="underline decoration-primary">{{ __('app.tagline_break') }}</span></h2>
                     <p class="text-sm uppercase tracking-wider font-semibold text-primary text-center mb-4">{{ __('app.subtitle') }}</p>
                
                    <ul class="timeline timeline-vertical mb-6 mt-5">
                        <li>
                            <div class="timeline-start timeline-box">{{ __('app.step_create') }}</div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr class="bg-primary" />
                        </li>
                        <li>
                            <hr class="bg-primary" />
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="timeline-end timeline-box">{{ __('app.step_add_home') }}</div>
                            <hr class="bg-primary" />
                        </li>
                        <li>
                            <hr class="bg-primary" />
                            <div class="timeline-start timeline-box">{{ __('app.step_airdrop') }}</div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </li>
                    </ul>
                    
                    <p class="mb-6 text-base-content/70 leading-relaxed text-center">
                        {{ __('app.step_complete') }}
                    </p>
                    <form id="profileForm" @submit.prevent="submit" class="flex flex-col gap-4 pb-4">
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.form_name') }}</span>
                            </label>
                            <input type="text" x-model="form.name" class="input input-bordered input-lg w-full" placeholder="{{ __('app.form_name_placeholder') }}" required />
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.form_photo') }}</span>
                            </label>
                            <input type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" class="file-input file-input-bordered file-input-lg w-full" />
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.form_message') }}</span>
                                <button type="button" @click="suggestPickupLine()" class="btn btn-xs btn-ghost" :disabled="loadingPickupLine">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    <span class="hidden sm:inline" x-text="loadingPickupLine ? '{{ __('app.suggesting') }}' : '{{ __('app.suggest_pickup_line') }}'"></span>
                                </button>
                            </label>
                            <textarea x-model="form.message" class="textarea textarea-bordered textarea-lg w-full" placeholder="{{ __('app.form_message_placeholder') }}" rows="3"></textarea>
                        </div>
                        <!-- Notification preference -->
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.how_to_notify') }}</span>
                            </label>
                            <input type="tel"
                                   x-model="form.contact_value"
                                   class="input input-bordered input-lg w-full"
                                   placeholder="{{ __('app.phone_placeholder') }}"
                                   required />
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.form_age') }}</span>
                            </label>
                            <input type="number" x-model="form.age" class="input input-bordered input-lg w-full" placeholder="{{ __('app.form_age_placeholder') }}" min="18" max="100" required />
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">{{ __('app.form_location') }}</span>
                            </label>
                            <div class="relative">
                                <input type="text" x-model="form.location" class="input input-bordered input-lg w-full pr-12" placeholder="{{ __('app.form_location_placeholder') }}" />
                                <button type="button" @click="getLocation" :disabled="gettingLocation" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-sm btn-circle btn-ghost">
                                    <svg x-show="!gettingLocation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span x-show="gettingLocation" class="loading loading-spinner loading-xs"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fixed button at bottom -->
    <div class="p-4 bg-base-100 border-t border-base-300">
        <div class="w-full max-w-md mx-auto">
            <button type="button" :disabled="loading" class="btn btn-primary btn-lg w-full" @click="submit()">
                <span x-text="loading ? '{{ __('app.btn_creating') }}' : '{{ __('app.btn_create') }}'"></span>
            </button>
        </div>
    </div>
</div>
     
<script>
function profileForm() {
    return {
        form: {
            name: '',
            photo: null,
            message: '',
            contact_type: 'email',
            contact_value: '',
            location: '',
            age: '',
        },
        loading: false,
        loadingPickupLine: false,
        gettingLocation: false,
        link: '',
        async suggestPickupLine() {
            if (!this.form.name) {
                alert('{{ __('app.enter_name_first') }}');
                return;
            }
            
            this.loadingPickupLine = true;
            try {
                const response = await fetch('/api/generate-pickup-line', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: this.form.name,
                        age: this.form.age || null,
                        location: this.form.location || null,
                        for_self: true
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.form.message = data.pickup_line;
                } else {
                    console.error('API Error:', data);
                    alert('Error generating pickup line: ' + (data.message || data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error generating pickup line:', error);
                alert('Error generating pickup line: ' + error.message);
            }
            this.loadingPickupLine = false;
        },
        async getLocation() {
            if (!navigator.geolocation) {
                alert('{{ __('app.error_location_support') }}');
                return;
            }
            
            this.gettingLocation = true;
            
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`);
                        const data = await response.json();
                        
                        // Extract city and country from the response
                        const city = data.address.city || data.address.town || data.address.village || '';
                        const country = data.address.country || '';
                        
                        this.form.location = city ? `${city}, ${country}` : country;
                    } catch (error) {
                        console.error('Error getting location name:', error);
                        this.form.location = `${position.coords.latitude}, ${position.coords.longitude}`;
                    }
                    this.gettingLocation = false;
                },
                (error) => {
                    console.error('Error getting location:', error);
                    alert('{{ __('app.error_location_fetch') }}');
                    this.gettingLocation = false;
                }
            );
        },
        async submit() {
            console.log('Submit function called');
            console.log('Form data:', this.form);
            
            this.loading = true;
            try {
                const fd = new FormData();
                for (const key in this.form) {
                    if (this.form[key] !== null && this.form[key] !== '') {
                        fd.append(key, this.form[key]);
                        console.log(`Added to FormData: ${key} =`, this.form[key]);
                    }
                }

                console.log('Making API request to /api/profiles');
                const res = await fetch('/api/profiles', { 
                    method: 'POST', 
                    body: fd
                });
                
                console.log('Response status:', res.status);
                console.log('Response ok:', res.ok);
                
                if (!res.ok) {
                    const errorText = await res.text();
                    console.error('Error response:', errorText);
                    throw new Error(`HTTP ${res.status}: ${errorText}`);
                }
                
                const data = await res.json();
                console.log('Response data:', data);
                this.link = data.url;
                
                // Redirect to add-to-home page with the profile URL
                console.log('Redirecting to:', `/add-to-home?url=${encodeURIComponent(data.url)}`);
                window.location.href = `/add-to-home?url=${encodeURIComponent(data.url)}`;
            } catch (err) {
                console.error('Submit error:', err);
                alert('{{ __('app.error_create') }}: ' + err.message);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
</body>
</html>