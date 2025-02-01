<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'product_images' => collect($this->product_images)->map(fn (string $image): string => Storage::disk('public')->url($image)),
            'description' => $this->description,
            'variations' => ProductVariationResource::collection($this->whenLoaded('variations')),
            'reviews' => (new ProductService)->getProductReviewsStatistics($this->id),
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
