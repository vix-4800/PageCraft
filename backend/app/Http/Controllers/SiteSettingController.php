<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteSettingRequest;
use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class SiteSettingController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'admin', 'password.confirm'], only: ['update']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function show(): JsonResource
    {
        return SiteSettingResource::collection(SiteSetting::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteSettingRequest $request): JsonResource
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            foreach ($validated as $setting) {
                SiteSetting::firstWhere('key', $setting['key'])->update(['value' => $setting['value']]);
            }
        });

        return SiteSettingResource::collection(SiteSetting::all());
    }
}
