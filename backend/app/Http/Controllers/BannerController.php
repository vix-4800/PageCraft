<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Resources\Json\JsonResource;

final class BannerController extends Controller
{
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
