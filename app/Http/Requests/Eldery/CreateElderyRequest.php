<?php

namespace App\Http\Requests\Eldery;

use Illuminate\Foundation\Http\FormRequest;

class CreateElderyRequest extends FormRequest
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
            'full_name' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'room_id' => ['required', 'integer'],
            'login_at' => ['required', 'date'],
            'caregiver_id' => ['nullable', 'integer'],
            'image' => ['nullable', 'image']
        ];
    }
}
