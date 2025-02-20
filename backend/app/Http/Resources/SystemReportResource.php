<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\SystemReport
 */
class SystemReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'is_database_up' => $this->is_database_up,
            'is_cache_up' => $this->is_cache_up,
            'uptime' => $this->uptime,
            'collected_at' => $this->collected_at->format('Y-m-d H:i'),
        ];
    }
}
