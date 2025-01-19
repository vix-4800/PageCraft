<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ReviewReactionType;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductReviewReactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:'.implode(',', ReviewReactionType::values())],
        ];
    }
}
