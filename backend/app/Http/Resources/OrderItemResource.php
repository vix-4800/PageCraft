<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\OrderItem
 */
class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(ProductVariationResource::make($this->productVariation)->toArray($request), [
            'quantity' => $this->quantity,
        ]);
    }
}
