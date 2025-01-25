<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\FeedbackSubject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFeedbackMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:6', 'max:255'],
            'message' => ['required', 'string', 'min:3'],
            'subject' => ['required', 'string', Rule::in(FeedbackSubject::values())],
        ];
    }
}
