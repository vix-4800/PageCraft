<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'additional_images' => $this->additional_images,
            'description' => $this->description,
            'variations' => ProductVariationResource::collection($this->whenLoaded('variations')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
