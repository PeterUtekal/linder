@extends('layouts.app')

@section('content')
    <div x-data="swipeComponent()" class="max-w-md mx-auto space-y-6">
        <div class="card bg-base-100 shadow-xl image-full">
            @if($profile->photo_url)
                <figure><img src="{{ $profile->photo_url }}" alt="photo" /></figure>
            @endif
            <div class="card-body justify-end bg-gradient-to-t from-black/70 to-transparent">
                <h2 class="card-title text-3xl text-white">{{ $profile->name }}</h2>
                <p class="text-white">{{ $profile->message }}</p>
            </div>
        </div>

        <div class="flex justify-between">
            <button class="btn btn-error w-1/3" @click="swipe(false)">Dislike</button>
            <button class="btn btn-success w-1/3" @click="swipe(true)">Like</button>
        </div>

        <template x-if="contact">
            <div class="alert alert-success shadow-lg mt-4">
                <div>
                    <span>It's a match! Contact via <strong x-text="contact.method"></strong>: </span>
                    <a class="link" :href="contact.url" x-text="contact.value" target="_blank"></a>
                </div>
            </div>
        </template>
    </div>

    <script>
        function swipeComponent() {
            return {
                contact: null,
                swipe(isRight) {
                    fetch('{{ route('swipe.store', ['shortCode' => $profile->short_code]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            profile_code: '{{ $profile->short_code }}',
                            is_right_swipe: isRight
                        })
                    }).then(r => r.json()).then(data => {
                        if (data.contact) {
                            this.contact = data.contact;
                        } else {
                            alert(data.message || 'Thanks!');
                        }
                    }).catch(() => alert('Something went wrong'));
                }
            }
        }
    </script>
@endsection