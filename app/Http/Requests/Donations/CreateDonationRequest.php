<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;

class CreateDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'InvoiceValue' => ['required', 'numeric'],
            'CustomerName' => ['required', 'string'],
            'CustomerMobile' => ['required', 'string'],
            'CustomerEmail' => ['required', 'email'],
        ];
    }
}
