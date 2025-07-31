<!DOCTYPE html>
<html lang="en" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

</head>
<body class="bg-base-200">
<div x-data="profileForm()" class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse p-0 rounded-none">
        <div class="card w-full max-w-md bg-base-100 rounded-none">
            <div class="card-body">
                <h2 class="card-title text-4xl font-extrabold leading-tight mb-3 text-center">Drop Your Link. Meet The Club.</h2>
                <p class="text-sm uppercase tracking-wider font-semibold text-primary text-center mb-4">30&nbsp;seconds • 3&nbsp;steps • Unlimited&nbsp;connections</p>
                <p class="mb-4 text-base-content/70 leading-relaxed text-center">
                    1.&nbsp;Fill this in. 2.&nbsp;Add the link to your Home&nbsp;Screen. 3.&nbsp;Airdrop it to the room.<br>
                    That's it – let the connections roll in. 🍸
                </p>
                <form @submit.prevent="submit" class="flex flex-col gap-2">
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold">What is your name?</legend>
                        <input type="text" x-model="form.name" class="input input-bordered input-lg w-full" placeholder="Type your name" required />
                    </fieldset>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold">Upload your photo</legend>
                        <input type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" class="file-input file-input-bordered file-input-lg w-full" />
                    </fieldset>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold">Your message</legend>
                        <textarea x-model="form.message" class="textarea textarea-bordered textarea-lg w-full" placeholder="Your personal message"></textarea>
                    </fieldset>
                    <div class="flex gap-4">
                        <fieldset class="fieldset flex-1 p-0 border-0">
                            <legend class="fieldset-legend text-lg font-semibold">Contact Type</legend>
                            <select x-model="form.contact_type" class="select select-bordered select-lg w-full" required>
                                <option value="tel">Phone</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="instagram">Instagram</option>
                                <option value="email">Email</option>
                            </select>
                        </fieldset>
                        <fieldset class="fieldset flex-1 p-0 border-0">
                            <legend class="fieldset-legend text-lg font-semibold">Contact Value</legend>
                            <input type="text" x-model="form.contact_value" class="input input-bordered input-lg w-full" placeholder="Your contact info" required />
                        </fieldset>
                    </div>
                    <fieldset class="fieldset p-0 border-0">
                        <legend class="fieldset-legend text-lg font-semibold">Location</legend>
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
                        <p class="py-4 break-all text-center">
                            <span class="font-semibold">Your Link</span><br>
                            <a :href="link" x-text="link" class="link link-primary"></a>
                        </p>
                        <p class="text-sm text-base-content/60 mb-4 leading-relaxed text-center">
                            • Tap the <span class="font-bold">Share&nbsp;icon</span> in Safari<br>
                            • Choose <span class="font-bold">“Add&nbsp;to&nbsp;Home&nbsp;Screen”</span><br>
                            • Open it anytime and <span class="font-bold">Airdrop</span> to new friends
                        </p>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button type="button" class="btn btn-outline btn-primary btn-sm" @click="navigator.clipboard.writeText(link);$el.innerText='Copied!'">Copy Link</button>
                            <button type="button" x-show="!!navigator.share" class="btn btn-primary btn-sm" @click="navigator.share({title:'Check my link',url:link}).catch(()=>{})">Share…</button>
                        </div>
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