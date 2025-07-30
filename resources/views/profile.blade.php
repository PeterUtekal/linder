<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile['name'] }} - Profile</title>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-50 flex flex-col items-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white shadow rounded p-6" x-data="swipeComponent()">
        <div class="space-y-4">
            <img src="{{ $profile['photo_url'] ?? 'https://placehold.co/400x400?text=No+Photo' }}" alt="photo" class="w-full h-64 object-cover rounded" />
            <h1 class="text-2xl font-bold">{{ $profile['name'] }}</h1>
            <p>{{ $profile['message'] }}</p>
            <p class="text-sm text-gray-500">{{ $profile['location'] }}</p>
        </div>
        <div class="flex justify-between mt-6">
            <button @click="swipe('left')" class="bg-red-500 text-white px-6 py-2 rounded">Left</button>
            <button @click="swipe('right')" class="bg-green-500 text-white px-6 py-2 rounded">Right</button>
        </div>
        <template x-if="showContact">
            <div class="mt-6 p-4 bg-green-100 rounded text-center" x-html="contactHtml"></div>
        </template>
        <template x-if="showThanks">
            <div class="mt-6 p-4 bg-blue-100 rounded text-center">
                <p>Thanks for viewing!</p>
                <a href="/" class="underline text-blue-600">Create your own profile</a>
            </div>
        </template>
    </div>

<script>
function swipeComponent() {
    return {
        showContact: false,
        showThanks: false,
        contactHtml: '',
        async swipe(direction) {
            const res = await fetch('/api/profiles/{{ $profile['slug'] }}/swipe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ direction })
            });
            const data = await res.json();
            if (direction === 'right') {
                this.contactHtml = this.renderContact(data);
                this.showContact = true;
            } else {
                this.showThanks = true;
            }
        },
        renderContact(data) {
            switch (data.contact_type) {
                case 'tel':
                    return `<a href="tel:${data.contact_value}" class="text-lg font-bold text-green-700 underline">Call ${data.contact_value}</a>`;
                case 'wa':
                    return `<a href="https://wa.me/${data.contact_value}" target="_blank" class="text-lg font-bold text-green-700 underline">WhatsApp Chat</a>`;
                case 'ig':
                    return `<a href="https://instagram.com/${data.contact_value}" target="_blank" class="text-lg font-bold text-pink-600 underline">Instagram @${data.contact_value}</a>`;
                case 'email':
                    return `<a href="mailto:${data.contact_value}" class="text-lg font-bold text-blue-700 underline">Email ${data.contact_value}</a>`;
                case 'url':
                    return `<a href="${data.contact_value}" target="_blank" class="text-lg font-bold text-blue-700 underline">Visit Website</a>`;
                default:
                    return `<p>${data.contact_value}</p>`;
            }
        }
    }
}
</script>
</body>
</html>