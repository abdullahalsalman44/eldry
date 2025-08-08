<?php

namespace App\Http\Requests\Eldery;

use Illuminate\Foundation\Http\FormRequest;

class GetElderyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'full_name' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'room_id' => ['nullable', 'integer'],
            'login_at' => ['nullable', 'date'],
            'caregivr' => ['nullable', 'integer'],
        ];
    }
}
