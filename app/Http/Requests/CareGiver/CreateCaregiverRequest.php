<?php

namespace App\Http\Requests\CareGiver;

use Illuminate\Foundation\Http\FormRequest;

class CreateCaregiverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'image' => ['nullable', 'image'],
            'phone' => [
                'nullable',
                'regex:/^(?:\+|00)[1-9]\d{7,14}$/',
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/',
            ],
        ];
    }
}
