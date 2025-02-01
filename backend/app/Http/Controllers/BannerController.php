<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BannerController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array<int, Middleware|string>
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'admin'], except: ['show']),
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(): JsonResource
    {
        return new BannerResource(Banner::first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request): JsonResource
    {
        $banner = Banner::first();
        $banner->update($request->validated());

        return new BannerResource($banner);
    }
}
