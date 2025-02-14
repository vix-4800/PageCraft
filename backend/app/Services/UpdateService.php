<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\GitHub\Release;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UpdateService
{
    /**
     * @return Collection<Release>
     */
    public function getReleases(): Collection
    {
        return Cache::remember('latest_version', now()->addHour(), function (): Collection {
            $response = Http::github()->get('releases')->throw()->json();

            return collect($response)->map(fn (array $release): Release => Release::fromArray($release));
        });
    }

    public function latestVersion(): ?Release
    {
        return $this->getReleases()->first();
    }
}
