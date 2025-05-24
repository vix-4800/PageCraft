<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateBannerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, (ValidationRule | array<mixed> | string)>
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'url:http,https', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
