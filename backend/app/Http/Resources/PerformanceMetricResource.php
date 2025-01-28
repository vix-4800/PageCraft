<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\PerformanceMetric
 */
class PerformanceMetricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cpu_usage' => $this->cpu_usage,
            'memory_usage' => $this->memory_usage,
            'collected_at' => $this->collected_at?->format('Y-m-d H:i') ?? null,
        ];
    }
}
