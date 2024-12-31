<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'details' => 'required|array',
            'details.name' => 'required|string',
            'details.email' => 'required|email',
            'details.phone' => 'required|string',

            'products' => 'required|array',

            'tax' => 'required|numeric',
            'shipping' => 'required|numeric',

            'note' => 'nullable|string',
        ];
    }
}
