<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>{{ $profile->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
</head>
<body class="bg-primary min-h-screen" x-data="tinderCard()">

<!-- Main card container -->
<div class="flex items-center p-4">
    <div class="relative w-full max-w-sm">
        
        <!-- Swipe card -->
        <div 
            class="card bg-white shadow rounded-3xl overflow-hidden relative cursor-grab active:cursor-grabbing transform transition-transform duration-300"
            :class="{ 'rotate-12 translate-x-full opacity-0': swipeDirection === 'right', '-rotate-12 -translate-x-full opacity-0': swipeDirection === 'left' }"
            :style="`transform: translateX(${dragX}px) rotate(${dragX * 0.1}deg); opacity: ${1 - Math.abs(dragX) / 300}`"
            @mousedown="startDrag($event)"
            @touchstart="startDrag($event)"
            @mousemove="drag($event)"
            @touchmove="drag($event)"
            @mouseup="endDrag()"
            @touchend="endDrag()"
            @mouseleave="endDrag()"
            x-ref="card">
            
            <!-- Photo section -->
            <div class="relative h-96 overflow-hidden">
                @if($profile->photo_url)
                    <img src="{{ $profile->photo_url }}" class="w-full h-full object-cover" />
                @else
                    <div class="w-full h-full bg-gradient-to-br from-pink-200 to-orange-200 flex items-center justify-center">
                        <div class="text-6xl">👤</div>
                    </div>
                @endif
                
                <!-- Gradient overlay for text readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                
                <!-- Name and age at bottom of photo -->
                <div class="absolute bottom-4 left-4 right-4">
                    <h2 class="text-white text-2xl font-bold mb-1">
                        {{ $profile->name }}@if($profile->age), {{ $profile->age }}@endif {{ __('app.profile_wants_hangout') }}
                    </h2>
                </div>
                
                <!-- Swipe indicators -->
                <div class="absolute top-8 left-8 right-8 flex justify-between pointer-events-none">
                    <div class="badge badge-error badge-lg opacity-0 transition-opacity duration-200" 
                         :class="{ 'opacity-100': dragX < -50 }">
                        {{ __('app.swipe_nope') }}
                    </div>
                    <div class="badge badge-success badge-lg opacity-0 transition-opacity duration-200" 
                         :class="{ 'opacity-100': dragX > 50 }">
                        {{ __('app.swipe_like') }}
                    </div>
                </div>
            </div>
            
            <!-- Info section -->
            <div class="p-6">
                <div class="mb-4">
                    <p class="text-gray-700 text-base leading-relaxed">{{ $profile->message }}</p>
                    @if($profile->location)
                        <p class="text-gray-500 text-sm mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            {{ $profile->location }}
                        </p>
                    @endif
                </div>
                

            </div>
        </div>
        
        <!-- Tinder-style action buttons -->
        <div class="flex justify-center gap-3 sm:gap-3 sm:gap-6 mt-6">
            <div class="flex flex-col items-center gap-1">
                <button class="btn btn-circle btn-md sm:btn-lg bg-white hover:bg-gray-50 border-2 border-gray-200 shadow-lg" 
                        @click="swipeLeft()">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
                <span class="text-xs sm:text-xs sm:text-sm font-semibold text-gray-600">{{ __('app.btn_nope') }}</span>
            </div>
            
            <div class="flex flex-col items-center gap-1">
                <button class="btn btn-circle btn-md sm:btn-lg bg-white hover:bg-gray-50 border-2 border-gray-200 shadow-lg" 
                        @click="copyLink()" x-text="copied ? '✓' : '🔗'">
                </button>
                <span class="text-xs sm:text-xs sm:text-sm font-semibold text-gray-600">{{ __('app.btn_share') }}</span>
            </div>
            
            <div class="flex flex-col items-center gap-1">
                <button class="btn btn-circle btn-md sm:btn-lg bg-white hover:bg-gray-50 border-2 border-gray-200 shadow-lg" 
                        @click="swipeRight()">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5 2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"/>
                    </svg>
                </button>
                <span class="text-xs sm:text-xs sm:text-sm font-semibold text-gray-600">{{ __('app.btn_like') }}</span>
            </div>
        </div>
        
        <div class="flex justify-center mt-12">
            <span class="badge badge-accent badge-lg shadow-md">Create your own link here!</span>
        </div>

    </div>
</div>

<script>
function tinderCard() {
    const slug = "{{ $profile->slug }}";
    const contact = {
        type: @json($profile->contact_type),
        value: @json($profile->contact_value)
    };

    return {
        dragX: 0,
        dragY: 0,
        isDragging: false,
        startX: 0,
        startY: 0,
        showContact: false,
        swipeDirection: null,
        showActions: false,
        copied: false,
        
        startDrag(evt) {
            this.isDragging = true;
            const clientX = evt.touches ? evt.touches[0].clientX : evt.clientX;
            const clientY = evt.touches ? evt.touches[0].clientY : evt.clientY;
            this.startX = clientX;
            this.startY = clientY;
            
            // Prevent text selection
            evt.preventDefault();
        },
        
        drag(evt) {
            if (!this.isDragging) return;
            
            const clientX = evt.touches ? evt.touches[0].clientX : evt.clientX;
            const clientY = evt.touches ? evt.touches[0].clientY : evt.clientY;
            
            this.dragX = clientX - this.startX;
            this.dragY = clientY - this.startY;
            
            evt.preventDefault();
        },
        
        async endDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;
            
            const threshold = 100;
            
            if (this.dragX > threshold) {
                await this.swipeRight();
            } else if (this.dragX < -threshold) {
                await this.swipeLeft();
            } else {
                // Snap back to center
                this.dragX = 0;
                this.dragY = 0;
            }
        },
        
        async swipeRight() {
            this.swipeDirection = 'right';
            
            // Track the swipe
            await fetch(`/api/profiles/${slug}/swipe`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({direction: 'right'})
            }).catch(() => {});
            
            // Redirect to contact page after animation
            setTimeout(() => {
                window.location.href = `/p/${slug}/contact`;
            }, 500);
        },
        
        async swipeLeft() {
            this.swipeDirection = 'left';
            
            // Track the swipe
            await fetch(`/api/profiles/${slug}/swipe`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({direction: 'left'})
            }).catch(() => {});
            
            // Redirect to home after animation completes
            setTimeout(() => {
                window.location.href = '/';
            }, 500);
        },
        
        async copyLink() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = window.location.href;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        },
        
        contactLink() {
            switch (contact.type) {
                case 'tel': return `<a href="tel:${contact.value}" class="font-bold text-primary">${contact.value}</a>`;
                case 'whatsapp': return `<a href="https://wa.me/${contact.value}" target="_blank" class="font-bold text-primary">WhatsApp: ${contact.value}</a>`;
                case 'instagram': return `<a href="https://instagram.com/${contact.value}" target="_blank" class="font-bold text-primary">@${contact.value}</a>`;
                case 'email': return `<a href="mailto:${contact.value}" class="font-bold text-primary">${contact.value}</a>`;
                default: return `<span class="font-bold text-primary">${contact.value}</span>`;
            }
        }
    }
}
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
  animation: fade-in 1.2s cubic-bezier(.4,0,.2,1) both;
}
</style>
</body>
</html>