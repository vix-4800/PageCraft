<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePageConfigurationRequest;
use App\Http\Resources\PageConfigurationResource;
use App\Models\PageConfiguration;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PageConfigurationController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['update']),
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(): JsonResource
    {
        return new PageConfigurationResource(
            PageConfiguration::first()
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageConfigurationRequest $request): JsonResource
    {
        /** @var PageConfiguration $configuration */
        $configuration = PageConfiguration::first();

        $configuration->update($request->validated());

        return new PageConfigurationResource(
            $configuration
        );
    }
}
