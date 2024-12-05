<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePageConfigurationRequest;
use App\Http\Resources\PageConfigurationResource;
use App\Models\PageConfiguration;
use Illuminate\Http\Resources\Json\JsonResource;

class PageConfigurationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(): JsonResource
    {
        return PageConfigurationResource::make(PageConfiguration::first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageConfigurationRequest $request): JsonResource
    {
        /** @var PageConfiguration $configuration */
        $configuration = PageConfiguration::first();

        $configuration->update($request->validated());

        return PageConfigurationResource::make($configuration);
    }
}
