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
<<<<<<< HEAD
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
=======
<body class="bg-base-100 h-screen overflow-hidden">
<div x-data="profileForm()" class="h-screen flex flex-col">
    <!-- Scrollable content area -->
    <div class="flex-1 overflow-y-auto">
        <div class="hero min-h-full bg-base-100">
            <div class="hero-content flex-col lg:flex-row-reverse p-4 w-full max-w-md mt-12">
                <div class="w-full">
                    <h2 class="text-5xl font-extrabold leading-tight mb-3 text-center">No small talk. <br> Just your <span class="text-primary">link</span>. <br> <span class="underline decoration-primary">Break the ice.</span></h2>
                     <p class="text-sm uppercase tracking-wider font-semibold text-primary text-center mb-4">30&nbsp;seconds • 3&nbsp;steps • Unlimited&nbsp;connections</p>
                
                    <ul class="timeline timeline-vertical mb-6 mt-5">
                        <li>
                            <div class="timeline-start timeline-box">Create Profile</div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr class="bg-primary" />
                        </li>
                        <li>
                            <hr class="bg-primary" />
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="timeline-end timeline-box">Add to Home Screen</div>
                            <hr class="bg-primary" />
                        </li>
                        <li>
                            <hr class="bg-primary" />
                            <div class="timeline-start timeline-box">Airdrop to the room</div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </li>
                    </ul>
                    
                    <p class="mb-6 text-base-content/70 leading-relaxed text-center">
                        That's it – let the connections roll in. 🍸
                    </p>
                    <form id="profileForm" @submit.prevent="submit" class="flex flex-col gap-4 pb-4">
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">What is your name?</span>
                            </label>
                            <input type="text" x-model="form.name" class="input input-bordered input-lg w-full" placeholder="Type your name" required />
>>>>>>> 67aa11d (fix: Correct typo in location field and enhance create profile view layout)
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">Upload your photo</span>
                            </label>
                            <input type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" class="file-input file-input-bordered file-input-lg w-full" />
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">Your message</span>
                            </label>
                            <textarea x-model="form.message" class="textarea textarea-bordered textarea-lg w-full" placeholder="Your personal message"></textarea>
                        </div>
                        <div class="flex gap-4">
                            <div class="form-control flex-1">
                                <label class="label pb-1">
                                    <span class="label-text text-lg font-semibold">Contact Type</span>
                                </label>
                                <select x-model="form.contact_type" class="select select-bordered select-lg w-full" required>
                                    <option value="tel">Phone</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="form-control flex-1">
                                <label class="label pb-1">
                                    <span class="label-text text-lg font-semibold">Contact Value</span>
                                </label>
                                <input type="text" x-model="form.contact_value" class="input input-bordered input-lg w-full" placeholder="Your contact info" required />
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text text-lg font-semibold">Location</span>
                            </label>
                            <input type="text" x-model="form.location" class="input input-bordered input-lg w-full" placeholder="Your location (optional)" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fixed button at bottom -->
    <div class="p-4 bg-base-100 border-t border-base-300">
        <div class="w-full max-w-md mx-auto">
            <button type="submit" form="profileForm" :disabled="loading" class="btn btn-primary btn-lg w-full">
                <span x-text="loading ? 'Creating...' : 'Create Profile'"></span>
            </button>
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
                
                // Redirect to add-to-home page with the profile URL
                window.location.href = `/add-to-home?url=${encodeURIComponent(data.url)}`;
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