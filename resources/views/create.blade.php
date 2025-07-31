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