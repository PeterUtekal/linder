<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:' . config('linkwme.profile.max_photo_size') . '|mimes:jpeg,png,jpg,gif',
            'message' => 'nullable|string|max:' . config('linkwme.profile.max_message_length'),
            'contact_type' => 'required|string|in:' . implode(',', array_keys(config('linkwme.contact_types'))),
            'contact_value' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'age' => 'required|integer|min:' . config('linkwme.age.min') . '|max:' . config('linkwme.age.max'),
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('app.form_name')]),
            'age.required' => __('validation.required', ['attribute' => __('app.form_age')]),
            'age.min' => __('validation.min.numeric', ['attribute' => __('app.form_age'), 'min' => 18]),
            'age.max' => __('validation.max.numeric', ['attribute' => __('app.form_age'), 'max' => 100]),
            'contact_type.required' => __('validation.required', ['attribute' => __('app.form_contact_type')]),
            'contact_value.required' => __('validation.required', ['attribute' => __('app.form_contact_value')]),
            'photo.image' => __('validation.image', ['attribute' => __('app.form_photo')]),
            'photo.max' => __('validation.max.file', ['attribute' => __('app.form_photo'), 'max' => 2048]),
        ];
    }
}