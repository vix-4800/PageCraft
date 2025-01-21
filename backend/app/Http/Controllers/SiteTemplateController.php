<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteTemplateRequest;
use App\Http\Resources\SiteTemplateResource;
use App\Models\SiteTemplate;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class SiteTemplateController extends Controller implements HasMiddleware
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
     * Display the specified resource.
     */
    public function show(): JsonResource
    {
        return SiteTemplateResource::collection(SiteTemplate::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteTemplateRequest $request): JsonResource
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            foreach ($validated as $setting) {
                SiteTemplate::firstWhere('block', $setting['block'])->update(['template' => $setting['template']]);
            }
        });

        return SiteTemplateResource::collection(SiteTemplate::all());
    }
}
