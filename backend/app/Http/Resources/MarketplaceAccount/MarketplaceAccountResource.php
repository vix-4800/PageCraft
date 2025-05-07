<?php

declare(strict_types=1);

namespace App\Http\Resources\MarketplaceAccount;

use App\Models\MarketplaceAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MarketplaceAccount
 */
final class MarketplaceAccountResource extends JsonResource
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
            'settings' => MarketplaceAccountSettingResource::collection($this->settings),
            'marketplace' => $this->marketplace->name,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
