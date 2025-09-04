<?php

namespace App\Http\Requests\Rate;

use Illuminate\Foundation\Http\FormRequest;

class CreateRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'integer', 'exists:users,id'],
            'user_name' => ['required', 'nullable'],
            'rate' => ['required', 'integer'],
            'note' => ['nullable', 'string'],
        ];
    }
}
