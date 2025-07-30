<!DOCTYPE html>
<html lang="en" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

</head>
<body class="bg-base-200">
<div x-data="profileForm()" class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse p-4">
        <div class="card w-full max-w-md bg-base-100 shadow-2xl">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold mb-2">Create Your Club Link</h2>
                <p class="mb-4 text-base-content/70">
                    Instantly create your own shareable link. <br>
                    <span class="font-semibold text-primary">Save it to your iPhone home screen</span>, then <span class="font-semibold text-primary">Airdrop it to everyone in the club</span> and make new friends fast.
                </p>
                <form @submit.prevent="submit" class="flex flex-col gap-2">
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">What is your name?</legend>
                        <input type="text" x-model="form.name" class="input input-bordered input-lg w-full" placeholder="Type your name" required />
                    </fieldset>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">Upload your photo</legend>
                        <input type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" class="file-input file-input-bordered file-input-lg w-full" />
                    </fieldset>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">Your message</legend>
                        <textarea x-model="form.message" class="textarea textarea-bordered textarea-lg w-full" placeholder="Your personal message"></textarea>
                    </fieldset>
                    <div class="flex gap-4">
                        <fieldset class="fieldset flex-1 p-0 border-0">
                            <legend class="fieldset-legend text-lg font-semibold mb-2">Contact Type</legend>
                            <select x-model="form.contact_type" class="select select-bordered select-lg w-full" required>
                                <option value="tel">Phone</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="instagram">Instagram</option>
                                <option value="email">Email</option>
                            </select>
                        </fieldset>
                        <fieldset class="fieldset flex-1 p-0 border-0">
                            <legend class="fieldset-legend text-lg font-semibold mb-2">Contact Value</legend>
                            <input type="text" x-model="form.contact_value" class="input input-bordered input-lg w-full" placeholder="Your contact info" required />
                        </fieldset>
                    </div>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">Location</legend>
                        <input type="text" x-model="form.location" class="input input-bordered input-lg w-full" placeholder="Your location (optional)" />
                    </fieldset>
                    <button type="submit" :disabled="loading" class="btn btn-primary btn-lg w-full mt-2">
                        <span x-text="loading ? 'Creating...' : 'Create Profile'"></span>
                    </button>
                </form>
                <dialog id="successDialog" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Profile created!
                        </h3>
                        <p class="py-4 break-all">
                            <span class="font-semibold">Your link:</span><br>
                            <a :href="link" x-text="link" class="link link-primary"></a>
                        </p>
                        <div class="flex gap-2">
                            <button type="button" class="btn btn-outline btn-success" @click="navigator.clipboard.writeText(link)">Copy</button>
                            <button type="button" class="btn btn-success" @click="document.getElementById('successDialog').close()">Close</button>
                        </div>
                    </div>
                </dialog>
            </div>
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

                const res = await fetch('/api/profiles', { method: 'POST', body: fd });
                const data = await res.json();
                this.link = data.url;
                document.getElementById('successDialog').showModal();
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