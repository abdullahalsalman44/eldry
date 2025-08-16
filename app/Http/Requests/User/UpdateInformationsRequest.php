<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'email' => ['nullable', 'email'],
            'image' => ['nullable', 'image'],
            'phone' => [
                'nullable',
                'regex:/^(?:\+|00)[1-9]\d{7,14}$/',
            ],
        ];
    }
}
