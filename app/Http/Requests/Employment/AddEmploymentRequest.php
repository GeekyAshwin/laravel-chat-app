<?php

namespace App\Http\Requests\Employment;

use Illuminate\Foundation\Http\FormRequest;

class AddEmploymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employment' => 'array',
            'employment.*.employer_name' => 'required|string|max:255', // Each employer name is required and should be a string with max length 255
            'employment.*.position' => 'required|string|max:255', // Each position is required and should be a string with max length 255
            'employment.*.occupation' => 'required|string|max:255', // Each occupation is required and should be a string with max length 255
            'employment.*.manager_name' => 'required|string|max:255', // Each manager name is required and should be a string with max length 255
            'employment.*.manager_email' => 'required|email|max:255', // Each email is required and should be a valid email with max length 255
        ];
    }
}
