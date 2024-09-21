<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddOrderRequest extends FormRequest
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
             'subject' => 'required|string',
             'service' => 'required|exists:services,id',
             'university' => 'required|string',
             'referencingStyle' => 'required|exists:referencing_styles,id',
             'educationLevel' => 'required|exists:referencing_styles,id',
             'pages' => 'required|numeric',
         ];
     }
     
     public function messages(): array
     {
         return [
             'subject.required' => 'Subject is required.',
             'subject.string' => 'Subject must be a valid name.',
             'service.required' => 'Service is required.',
             'service.exists' => 'The selected service is invalid.',
             'university.required' => 'University is required.',
             'university.string' => 'University must be a valid name.',
             'referencingStyle.required' => 'Referencing Style is required.',
             'referencingStyle.exists' => 'The selected Referencing Style is invalid.',
             'educationLevel.required' => 'Education Level is required.',
             'educationLevel.exists' => 'The selected Education Level is invalid.',
         ];
     }
}
