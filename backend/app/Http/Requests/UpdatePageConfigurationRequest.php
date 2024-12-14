<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageConfigurationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'header_template' => ['nullable', 'string'],
            'product_list_template' => ['nullable', 'string'],
            'footer_template' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'header_template' => $this->filled('header') ? $this->input('header') : 'default',
            'product_list_template' => $this->filled('product_list') ? $this->input('product_list') : 'default',
            'footer_template' => $this->filled('footer') ? $this->input('footer') : 'default',
        ]);
    }
}
