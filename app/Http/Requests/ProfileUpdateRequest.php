<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:png,jpg|max:2048',
            'country_code' => 'sometimes|string',
            'contact' => 'sometimes|numeric',
        ];
    }
    
    public function messages(): array
    {
        return [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be in PNG or JPG format.',
            'image.max' => 'The image may not be greater than 2 MB.',
            'name.string' => 'The name must be a string.',
            'country_code.string' => 'The country code must be a string.',
            'contact.numeric' => 'The contact must be a number.',
        ];
    }
    
}
