<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-10" x-data="profileForm()">
    <form @submit.prevent="submit" class="bg-white p-6 rounded shadow">
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" x-model="form.name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Photo</label>
            <input type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" class="w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Message</label>
            <textarea x-model="form.message" class="w-full border rounded p-2"></textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Contact Type</label>
            <select x-model="form.contact_type" class="w-full border rounded p-2" required>
                <option value="tel">Phone</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="instagram">Instagram</option>
                <option value="email">Email</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Contact Value</label>
            <input type="text" x-model="form.contact_value" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input type="text" x-model="form.location" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white rounded p-2" :disabled="loading">Create</button>
    </form>

    <template x-if="link">
        <div class="mt-6 bg-green-100 text-green-800 p-4 rounded">
            Profile created! Share this link:
            <a :href="link" x-text="link" class="block underline"></a>
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
        link: '',
        async submit() {
            this.loading = true;
            try {
                const fd = new FormData();
                for (const key in this.form) {
                    if (this.form[key] !== null) {
                        fd.append(key, this.form[key]);
                    }
                }

                const res = await fetch('/api/profiles', {method: 'POST', body: fd});
                const data = await res.json();
                this.link = data.url;
            } catch (err) {
                alert('Error creating profile');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
</body>
</html>