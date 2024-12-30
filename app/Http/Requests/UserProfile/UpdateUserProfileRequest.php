<?php

namespace App\Http\Requests\UserProfile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'min:2', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['numeric', 'digits:10', 'required'],
            'skills' => ['string', 'required', 'max:255'],
            'profile_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg']
        ];
    }
}
