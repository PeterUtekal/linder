<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $profile->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white" x-data="swipeCard()">
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm">
        <div
            class="relative bg-gray-800 rounded-lg shadow-lg overflow-hidden"
            @touchstart="start($event)"
            @touchmove="move($event)"
            @touchend="end($event)"
            x-ref="card">
            @if($profile->photo_url)
                <img src="{{ $profile->photo_url }}" alt="" class="w-full h-64 object-cover">
            @endif
            <div class="p-4">
                <h1 class="text-2xl font-bold mb-2">{{ $profile->name }}</h1>
                <p class="mb-4">{{ $profile->message }}</p>

                <template x-if="showContact">
                    <div>
                        <p class="text-sm uppercase text-gray-400 mb-1">Contact</p>
                        <span x-html="contactLink()"></span>
                    </div>
                </template>

                <template x-if="!showContact">
                    <p class="text-center text-gray-400">Swipe right to reveal contact &raquo;</p>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
function swipeCard() {
    const slug = "{{ $profile->slug }}";
    const contact = {
        type: @json($profile->contact_type),
        value: @json($profile->contact_value)
    };

    return {
        startX: 0,
        currentX: 0,
        swiped: false,
        showContact: false,
        start(evt) {
            this.startX = evt.touches[0].clientX;
        },
        move(evt) {
            this.currentX = evt.touches[0].clientX;
        },
        async end() {
            const delta = this.currentX - this.startX;
            if (!this.swiped && delta > 40) {
                this.swiped = true;
                this.showContact = true;

                await fetch(`/api/profiles/${slug}/swipe`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({direction: 'right'})
                });
            } else if (!this.swiped && delta < -40) {
                this.swiped = true;
                await fetch(`/api/profiles/${slug}/swipe`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({direction: 'left'})
                });
            }
        },
        contactLink() {
            switch (contact.type) {
                case 'tel': return `<a href="tel:${contact.value}" class="underline">${contact.value}</a>`;
                case 'whatsapp': return `<a href="https://wa.me/${contact.value}" target="_blank" class="underline">WhatsApp</a>`;
                case 'instagram': return `<a href="https://instagram.com/${contact.value}" target="_blank" class="underline">@${contact.value}</a>`;
                case 'email': return `<a href="mailto:${contact.value}" class="underline">${contact.value}</a>`;
                default: return contact.value;
            }
        }
    }
}
</script>
</body>
</html>