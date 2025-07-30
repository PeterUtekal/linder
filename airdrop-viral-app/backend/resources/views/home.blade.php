@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-center">Create Your AirDrop Link</h1>
        <form method="POST" action="{{ route('link.store') }}" class="space-y-4">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text">Name</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full" required>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Short Message</span></label>
                <textarea name="message" class="textarea textarea-bordered w-full" required>{{ old('message') }}</textarea>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Contact Method</span></label>
                <select name="contact_method" class="select select-bordered w-full">
                    <option value="whatsapp">WhatsApp</option>
                    <option value="instagram">Instagram</option>
                    <option value="phone">Phone</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Contact Value</span></label>
                <input type="text" name="contact_value" value="{{ old('contact_value') }}" class="input input-bordered w-full" required>
            </div>

            <button class="btn btn-primary w-full" type="submit">Generate Link</button>
        </form>
    </div>
@endsection