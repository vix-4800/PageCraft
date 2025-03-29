<?php

declare(strict_types=1);

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\OrderItem
 */
final class OrderItemResource extends JsonResource
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
