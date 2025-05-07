<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Models\ProductVariationAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ProductVariationAttribute
 */
final class ProductVariationAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->productAttributeValue->productAttribute->name,
            'value' => $this->productAttributeValue->value,
        ];
    }
}
