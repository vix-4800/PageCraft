<?php

declare(strict_types=1);

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateTemplateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string', 'max:255'],
            '*.template' => ['required', 'string', 'max:255'],
            '*.is_visible' => ['required', 'boolean'],
        ];
    }
}
