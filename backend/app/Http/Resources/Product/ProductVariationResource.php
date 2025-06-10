<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin ProductVariation
 */
final class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sku' => $this->sku,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => Storage::disk('public')->url($this->image),
            'attributes' => ProductVariationAttributeResource::collection($this->whenLoaded('productVariationAttributes')),
            'product' => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
