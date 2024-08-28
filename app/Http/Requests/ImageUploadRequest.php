<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
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
            'image' => 'required|image|mimes:png,jpg|max:2048',

        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Image address is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be in PNG or JPG format.',
            'image.max' => 'The image may not be greater than 2 MB.',
        ];
    }
}
