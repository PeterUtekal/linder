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
            <p class="text-gray-600">{{ __('app.like_them_back') }}</p>
        </div>

        <!-- Contact Form Card -->
        <div class="card bg-white shadow-xl animate-fade-in" style="animation-delay: 0.2s" x-show="!submitted">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">{{ __('app.give_them_context') }}</h2>
                
                <form @submit.prevent="submitContact">
                    <!-- Name Input -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold">{{ __('app.your_name') }}</span>
                        </label>
                        <input type="text" 
                               x-model="form.name" 
                               class="input input-bordered input-lg w-full" 
                               placeholder="{{ __('app.enter_your_name') }}" 
                               required />
                    </div>

                    <!-- Choice: Instagram or Selfie -->
                    <div class="divider">{{ __('app.choose_one') }}</div>
                    
                    <!-- Instagram Option -->
                    <div class="card bg-pink-50 border-2 border-pink-200 mb-4">
                        <div class="card-body p-3 sm:p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                </svg>
                                <h3 class="font-semibold text-lg">{{ __('app.share_instagram') }}</h3>
                            </div>
                            <input type="text" 
                                   x-model="form.instagram" 
                                   @input="form.selfie = null; selfiePreview = null"
                                   class="input input-bordered w-full" 
                                   placeholder="@yourusername" />
                            <p class="text-sm text-gray-600 mt-2">{{ __('app.instagram_hint') }}</p>
                        </div>
                    </div>

                    <div class="text-center text-gray-500 mb-4">{{ __('app.or') }}</div>

                    <!-- Selfie Option -->
                    <div class="card bg-blue-50 border-2 border-blue-200 mb-6">
                        <div class="card-body p-3 sm:p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="font-semibold text-lg">{{ __('app.take_selfie') }}</h3>
                            </div>
                            
                            <div x-show="!selfiePreview" class="text-center">
                                <label for="selfie-input" class="btn btn-outline btn-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ __('app.open_camera') }}
                                </label>
                                <input id="selfie-input" 
                                       type="file" 
                                       accept="image/*" 
                                       capture="user"
                                       @change="handleSelfie($event)" 
                                       class="hidden" />
                            </div>
                            
                            <div x-show="selfiePreview" class="relative">
                                <img :src="selfiePreview" class="w-full rounded-lg" />
                                <button type="button" 
                                        @click="form.selfie = null; selfiePreview = null" 
                                        class="btn btn-sm btn-circle absolute top-2 right-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <p class="text-sm text-gray-600 mt-2">{{ __('app.selfie_hint') }}</p>
                        </div>
                    </div>
                    
                    <!-- Optional message -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold">{{ __('app.add_message') }}</span>
                        </label>
                        <textarea x-model="form.message" 
                                  class="textarea textarea-bordered w-full" 
                                  placeholder="{{ __('app.message_placeholder') }}"
                                  rows="2"></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="btn btn-primary btn-lg w-full" 
                                :disabled="loading || (!form.instagram && !form.selfie)">
                            <span x-show="!loading">{{ __('app.send_like_back') }}</span>
                            <span x-show="loading">{{ __('app.sending') }}...</span>
                        </button>
                        <p class="text-xs text-center text-gray-500 mt-2">{{ __('app.privacy_note') }}</p>
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
                <h3 class="text-2xl font-bold mb-2">{{ __('app.like_sent') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('app.like_sent_message') }}</p>
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
        form: {
            name: '',
            instagram: '',
            selfie: null,
            message: ''
        },
        selfiePreview: null,
        loading: false,
        submitted: false,
        
        handleSelfie(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.selfie = file;
                this.form.instagram = ''; // Clear Instagram if selfie is selected
                
                // Create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.selfiePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        async submitContact() {
            this.loading = true;
            
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('message', this.form.message || '');
                
                if (this.form.instagram) {
                    formData.append('contact_type', 'instagram');
                    formData.append('contact_value', this.form.instagram);
                } else if (this.form.selfie) {
                    formData.append('contact_type', 'selfie');
                    formData.append('selfie', this.form.selfie);
                }
                
                const response = await fetch('/api/profiles/{{ $profile->slug }}/contact', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
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