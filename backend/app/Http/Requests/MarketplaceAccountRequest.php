<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\MarketplaceType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class MarketplaceAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, (ValidationRule | array<mixed> | string)>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'marketplace' => ['required', 'string', Rule::in(MarketplaceType::values())],

            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string', 'max:255'],
            'settings.*.value' => ['required', 'string', 'max:255'],
        ];
    }
}
