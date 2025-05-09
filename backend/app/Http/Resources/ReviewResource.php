<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\User\UserShortResource;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ProductReview
 */
final class ReviewResource extends JsonResource
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
            'user' => UserShortResource::make($this->whenLoaded('user')),
            'product' => ProductResource::make($this->whenLoaded('product')),
            'rating' => $this->rating,
            'text' => $this->text,
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
