<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'slug' => ['required', 'string', 'min:3', 'max:255', 'unique:products,slug'],
            'description' => ['required', 'string', 'min:3'],
            'product_images' => ['nullable', 'array'],
            'product_images.*' => ['image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],

            'variations' => ['required', 'array'],
            'variations.*.sku' => ['required', 'string', 'min:3', 'max:255'],
            'variations.*.price' => ['required', 'numeric', 'min:0'],
            'variations.*.stock' => ['required', 'integer', 'min:0'],
            'variations.*.attributes' => ['required', 'array'],
            'variations.*.attributes.*.name' => ['required', 'string', 'min:3', 'max:255'],
            'variations.*.attributes.*.value' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
