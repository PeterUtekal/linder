<!DOCTYPE html>
<html lang="en" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>{{ $profile->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-base-200 text-base-content" x-data="swipeCard()">
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm">
        <div
            class="card bg-base-100 shadow-xl relative overflow-hidden"
            @touchstart="start($event)"
            @touchmove="move($event)"
            @touchend="end($event)"
            x-ref="card">
            @if($profile->photo_url)
                <figure><img src="{{ $profile->photo_url }}" alt="" class="w-full h-64 object-cover" /></figure>
            @endif
            <div class="card-body">
                <h1 class="card-title text-2xl font-bold mb-2">{{ $profile->name }}</h1>
                <p class="mb-4">{{ $profile->message }}</p>
                <div>
                    <template x-if="showContact">
                        <div class="alert alert-info flex flex-col gap-2">
                            <span class="text-xs uppercase font-semibold">Contact</span>
                            <span x-html="contactLink()"></span>
                        </div>
                    </template>
                    <template x-if="!showContact">
                        <div class="alert alert-warning text-center">Swipe right to reveal contact &raquo;</div>
                    </template>
                </div>
                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    <button class="btn btn-outline btn-primary btn-sm" @click="navigator.clipboard.writeText(window.location.href);$event.target.innerText='Copied!'">Copy&nbsp;Link</button>
                    <button class="btn btn-primary btn-sm" x-show="!!navigator.share" @click="navigator.share({title:'{{ $profile->name }} on LinkwMe',url:window.location.href}).catch(()=>{})">Share…</button>
                    <button class="btn btn-ghost btn-xs" onclick="alert('Tip: On iPhone tap the share icon and choose \"Add to Home Screen\" to keep this link handy.')">Add&nbsp;to&nbsp;Home&nbsp;Screen?</button>
                </div>
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