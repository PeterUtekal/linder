<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.share_contact_title') }} - {{ $profile->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
</head>
<body class="bg-primary min-h-screen" x-data="contactForm()">

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-sm">
        
        <!-- Success animation -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-success/20 rounded-full mb-4">
                <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('app.you_like') }} {{ $profile->name }}!</h1>
            <p class="text-gray-600">{{ __('app.share_your_contact') }}</p>
        </div>

        <!-- Contact Form Card -->
        <div class="card bg-white shadow-xl animate-fade-in" style="animation-delay: 0.2s" x-show="!submitted">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">{{ __('app.choose_contact_method') }}</h2>
                
                <form @submit.prevent="submitContact">
                    <!-- Contact type selection -->
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <button type="button" 
                                @click="contactType = 'instagram'" 
                                :class="contactType === 'instagram' ? 'ring-4 ring-primary' : 'hover:bg-gray-50'"
                                class="card bg-base-100 shadow-md p-4 cursor-pointer transition-all">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                </svg>
                                <span class="text-sm font-semibold">Instagram</span>
                            </div>
                        </button>
                        
                        <button type="button" 
                                @click="contactType = 'tel'" 
                                :class="contactType === 'tel' ? 'ring-4 ring-primary' : 'hover:bg-gray-50'"
                                class="card bg-base-100 shadow-md p-4 cursor-pointer transition-all">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-sm font-semibold">{{ __('app.phone') }}</span>
                            </div>
                        </button>
                        
                        <button type="button" 
                                @click="contactType = 'email'" 
                                :class="contactType === 'email' ? 'ring-4 ring-primary' : 'hover:bg-gray-50'"
                                class="card bg-base-100 shadow-md p-4 cursor-pointer transition-all">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-semibold">Email</span>
                            </div>
                        </button>
                    </div>
                    
                    <!-- Input fields -->
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">{{ __('app.your_name') }}</span>
                            </label>
                            <input type="text" 
                                   x-model="form.name" 
                                   class="input input-bordered input-lg w-full" 
                                   placeholder="{{ __('app.enter_your_name') }}" 
                                   required />
                        </div>
                        
                        <div class="form-control" x-show="contactType">
                            <label class="label">
                                <span class="label-text font-semibold" x-text="getContactLabel()"></span>
                            </label>
                            <input :type="getInputType()" 
                                   x-model="form.contact_value" 
                                   class="input input-bordered input-lg w-full" 
                                   :placeholder="getPlaceholder()" 
                                   required />
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">{{ __('app.optional_message') }}</span>
                            </label>
                            <textarea x-model="form.message" 
                                      class="textarea textarea-bordered w-full" 
                                      placeholder="{{ __('app.optional_message_placeholder') }}"
                                      rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" 
                                class="btn btn-primary btn-lg w-full" 
                                :disabled="loading || !contactType || !form.contact_value">
                            <span x-show="!loading">{{ __('app.send_my_contact') }}</span>
                            <span x-show="loading">{{ __('app.sending') }}...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success message -->
        <div class="card bg-white shadow-xl animate-fade-in" x-show="submitted">
            <div class="card-body text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-success/20 rounded-full mb-4 mx-auto">
                    <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">{{ __('app.contact_sent') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('app.contact_sent_message') }}</p>
                <a href="/" class="btn btn-primary">{{ __('app.create_your_profile') }}</a>
            </div>
        </div>

        <!-- Back link -->
        <div class="text-center mt-6" x-show="!submitted">
            <a href="/p/{{ $profile->slug }}" class="link link-hover text-gray-600">{{ __('app.back_to_profile') }}</a>
        </div>
    </div>
</div>

<script>
function contactForm() {
    return {
        contactType: 'instagram',
        form: {
            name: '',
            contact_value: '',
            message: ''
        },
        loading: false,
        submitted: false,
        
        getContactLabel() {
            switch(this.contactType) {
                case 'instagram': return '{{ __('app.your_instagram') }}';
                case 'tel': return '{{ __('app.your_phone') }}';
                case 'email': return '{{ __('app.your_email') }}';
            }
        },
        
        getInputType() {
            switch(this.contactType) {
                case 'email': return 'email';
                case 'tel': return 'tel';
                default: return 'text';
            }
        },
        
        getPlaceholder() {
            switch(this.contactType) {
                case 'instagram': return '@username';
                case 'tel': return '+1234567890';
                case 'email': return 'your@email.com';
            }
        },
        
        async submitContact() {
            this.loading = true;
            
            try {
                const response = await fetch('/api/profiles/{{ $profile->slug }}/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        contact_type: this.contactType,
                        ...this.form
                    })
                });
                
                if (response.ok) {
                    this.submitted = true;
                } else {
                    alert('{{ __('app.error_sending_contact') }}');
                }
            } catch (error) {
                alert('{{ __('app.error_sending_contact') }}');
            }
            
            this.loading = false;
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