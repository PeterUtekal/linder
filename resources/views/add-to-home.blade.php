<!DOCTYPE html>
<html lang="en" data-theme="bumblebee">
<head>
    <meta charset="UTF-8">
    <title>Add to Home Screen - Linder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-base-100 min-h-screen">
<div x-data="{ copied: false, profileUrl: new URLSearchParams(window.location.search).get('url') || '{{ $profileUrl ?? 'https://yoursite.com/profile/123' }}' }" class="min-h-screen flex flex-col">
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold leading-tight mb-3">Add to <span class="text-primary">Home Screen</span></h1>
                <p class="text-base-content/70 mb-6">Follow these simple steps to save your profile link</p>
            </div>

            <!-- iOS Instructions -->
            <div class="card bg-base-200 mb-6">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                        </svg>
                        For iPhone/iPad (Safari)
                    </h2>
                    
                    <ul class="timeline timeline-vertical">
                        <li>
                            <div class="timeline-start timeline-box text-sm">Open your profile link in Safari</div>
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <div class="timeline-end timeline-box text-sm">Tap the Share button at the bottom</div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-start timeline-box text-sm">Select "Add to Home Screen"</div>
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <div class="timeline-end timeline-box text-sm">Tap "Add" to confirm</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Android Instructions -->
            <div class="card bg-base-200 mb-6">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993.0001.5511-.4482.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.2439 13.8533 7.8508 12 7.8508s-3.5902.3931-5.1367 1.0989L4.841 5.4467a.4161.4161 0 00-.5677-.1521.4157.4157 0 00-.1521.5676l1.9973 3.4592C2.6889 11.1867.3432 14.6589 0 18.761h24c-.3435-4.1021-2.6892-7.5743-6.1185-9.4396"/>
                        </svg>
                        For Android (Chrome)
                    </h2>
                    
                    <ul class="timeline timeline-vertical">
                        <li>
                            <div class="timeline-start timeline-box text-sm">Open your profile link in Chrome</div>
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <div class="timeline-end timeline-box text-sm">Tap the menu (3 dots) in top right</div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-start timeline-box text-sm">Select "Add to Home screen"</div>
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <hr />
                        </li>
                        <li>
                            <hr />
                            <div class="timeline-middle">
                                <div class="bg-primary rounded-full w-3 h-3"></div>
                            </div>
                            <div class="timeline-end timeline-box text-sm">Tap "Add" to confirm</div>
                        </li>
                    </ul>
                </div>
            </div>

                <div class="card bg-primary/10 border border-primary/20">
                <div class="card-body text-center">
                    <h3 class="font-bold text-lg mb-2">Your Profile Link</h3>
                    <div class="bg-base-100 p-3 rounded-lg mb-4 break-all">
                        <span x-show="loading" class="loading loading-dots loading-md"></span>
                        <span x-show="!loading" class="text-sm font-mono" x-text="profileUrl"></span>
                    </div>
                    <div class="flex gap-2 justify-center" x-show="!loading">
                        <button 
                            class="btn btn-primary" 
                            @click="navigator.clipboard.writeText(profileUrl); copied = true; setTimeout(() => copied = false, 2000)"
                        >
                            <span x-show="!copied">Copy Link</span>
                            <span x-show="copied" class="text-success-content">✓ Copied!</span>
                        </button>
                        <button 
                            class="btn btn-outline btn-primary" 
                            x-show="!!navigator.share" 
                            @click="navigator.share({title:'My Profile', url: profileUrl}).catch(()=>{})"
                        >
                            Share
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pro Tips -->
            <div class="alert alert-info mt-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold">Pro Tips!</h3>
                    <div class="text-sm">
                        • The icon will appear on your home screen<br>
                        • Tap it anytime to open your profile<br>
                        • Use AirDrop to share with nearby friends
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-8">
                <a href="/" class="btn btn-ghost">
                    ← Back to Create Profile
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
