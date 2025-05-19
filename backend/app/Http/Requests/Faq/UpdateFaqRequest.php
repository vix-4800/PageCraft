<?php

declare(strict_types=1);

namespace App\Http\Requests\Faq;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateFaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, (ValidationRule | array<mixed> | string)>
     */
    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }
}
