<?php

declare(strict_types=1);

namespace App\Http\Resources\MarketplaceAccount;

use App\Models\MarketplaceAccountSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MarketplaceAccountSetting
 */
final class MarketplaceAccountSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
