<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow request processing
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required|date',
            'country_code' => 'required|string', // Fixed the rule concatenation
            'contact' => 'required|numeric',
            // 'plate_form' => 'required|string',
            // 'ip_address' => 'required|ip',
            'password' => 'required|string|min:8'//|confirmed // Added 'confirmed' for password confirmation
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address is already registered.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Please provide a valid date for the date of birth.',
            'country_code.required' => 'Country code is required.',
            'country_code.string' => 'Country code must be a string.',
            'country_code.regex' => 'Country code must be exactly 2 uppercase letters.',
            'contact.required' => 'Contact number is required.',
            'contact.numeric' => 'Contact number must be a number.',
            // 'plate_form.required' => 'Plate form is required.',
            // 'plate_form.string' => 'Plate form must be a string.',
            // 'ip_address.required' => 'IP address is required.',
            // 'ip_address.ip' => 'Please provide a valid IP address.',
            'password.required' => 'A password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            // 'password.confirmed' => 'The password confirmation does not match.', // Ensuring password confirmation is checked
        ];
    }
    
}
