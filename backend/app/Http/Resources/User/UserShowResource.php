<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserShowResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'is_email_verified' => $this->hasVerifiedEmail(),
            'email_verified_at' => $this->email_verified_at?->toDateTimeString() ?? null,
            'phone' => $this->phone,
            'registered_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
