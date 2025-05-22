<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\FeedbackMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FeedbackMessage
 */
final class FeedbackMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'subject' => $this->subject,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
