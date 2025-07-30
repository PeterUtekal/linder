<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
<div x-data="profileForm()" class="bg-white shadow-md rounded p-6 w-full max-w-md">
    <template x-if="!created">
        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" x-model="form.name" required class="mt-1 p-2 w-full border rounded" />
            </div>
            <div>
                <label class="block text-sm font-medium">Photo</label>
                <input type="file" @change="handlePhoto" accept="image/*" class="mt-1 w-full" />
            </div>
            <div>
                <label class="block text-sm font-medium">Message</label>
                <textarea x-model="form.message" required class="mt-1 p-2 w-full border rounded"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Contact Type</label>
                <select x-model="form.contact_type" required class="mt-1 p-2 w-full border rounded">
                    <option value="tel">Phone</option>
                    <option value="wa">WhatsApp</option>
                    <option value="ig">Instagram</option>
                    <option value="email">Email</option>
                    <option value="url">Website</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Contact Value</label>
                <input type="text" x-model="form.contact_value" required class="mt-1 p-2 w-full border rounded" />
            </div>
            <div>
                <label class="block text-sm font-medium">Location</label>
                <input type="text" x-model="form.location" class="mt-1 p-2 w-full border rounded" />
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded" x-bind:disabled="loading">
                <span x-show="!loading">Create Profile</span>
                <span x-show="loading">Creating...</span>
            </button>
        </form>
    </template>
    <template x-if="created">
        <div class="text-center space-y-4">
            <p class="text-lg">Your profile is ready!</p>
            <input type="text" :value="url" readonly class="w-full p-2 border rounded" />
            <a :href="url" target="_blank" class="text-blue-600 underline">Open Link</a>
            <button @click="copy" class="mt-2 text-sm bg-green-600 text-white py-1 px-3 rounded">Copy to Clipboard</button>
        </div>
    </template>
</div>

<script>
function profileForm() {
    return {
        form: {
            name: '',
            photo: null,
            message: '',
            contact_type: 'tel',
            contact_value: '',
            location: '',
        },
        loading: false,
        created: false,
        url: '',
        handlePhoto(e) {
            this.form.photo = e.target.files[0];
        },
        async submit() {
            this.loading = true;
            try {
                const body = new FormData();
                Object.entries(this.form).forEach(([key, value]) => {
                    if (value !== null && value !== '') body.append(key, value);
                });
                const response = await fetch('/api/profiles', {
                    method: 'POST',
                    body,
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Failed');
                this.url = data.url;
                this.created = true;
            } catch (err) {
                alert(err.message);
            } finally {
                this.loading = false;
            }
        },
        copy() {
            navigator.clipboard.writeText(this.url);
            alert('Copied!');
        }
    }
}
</script>
</body>
</html>