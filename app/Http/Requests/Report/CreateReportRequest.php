<?php

namespace App\Http\Requests\Report;

use App\Enums\ApetitieEnum;
use App\Enums\HealthEnum;
use App\Enums\MoodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateReportRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'apetitie' => ['nullable', Rule::enum(ApetitieEnum::class)],
            'mood' => ['nullable', Rule::enum(MoodEnum::class)],
            'health' => ['nullable', Rule::enum(HealthEnum::class)],
            'sleep_rate' => ['nullable', 'numeric'],
            'take_shower' => ['required', 'in:yes,no'],
            'eldery_id' => ['required', 'integer', Rule::exists('elderly_people' , 'id')->where('caregiver_id', Auth::user()->id)],
        ];
    }
}
