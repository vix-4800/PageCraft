<?php

declare(strict_types=1);

namespace App\Http\Resources\Order;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Order
 */
final class OrderResource extends JsonResource
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
            'status' => $this->status,
            'sub_total' => $this->sub_total,
            'tax' => $this->tax,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'user' => UserResource::make($this->whenLoaded('user')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'note' => $this->note,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
