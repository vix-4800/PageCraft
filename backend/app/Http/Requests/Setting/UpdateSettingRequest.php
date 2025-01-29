<?php

declare(strict_types=1);

namespace App\Http\Requests\Setting;

use App\Rules\SettingValueType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.key' => ['required', 'string', 'max:255'],
            '*.value' => ['nullable', new SettingValueType, 'max:255'],
        ];
    }
}
