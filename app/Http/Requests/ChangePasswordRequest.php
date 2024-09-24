<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string|min:8|current_password:api',
            'newPassword' => 'required|string|min:8',
            'confirmPassword' => 'required|string|min:8|confirmed:newPassword',
        ];
    }
    
    public function messages(): array
    {
        return [
            'password.required' => 'A password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            
            'newPassword.required' => 'A new password is required.',
            'newPassword.string' => 'New password must be a string.',
            'newPassword.min' => 'The new password must be at least 8 characters long.',
            
            'confirmPassword.confirmed' => 'The confirm password does not match the new password.'
        ];
    }
    
}    
