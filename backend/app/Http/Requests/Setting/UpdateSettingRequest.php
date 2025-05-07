<?php

declare(strict_types=1);

namespace App\Http\Requests\Setting;

use App\Rules\SettingValueType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, (ValidationRule | array<mixed> | string)>
     */
    public function rules(): array
    {
        return [
            '*.key' => ['required', 'string', 'max:255'],
            '*.value' => ['nullable', new SettingValueType, 'max:255'],
        ];
    }
}
