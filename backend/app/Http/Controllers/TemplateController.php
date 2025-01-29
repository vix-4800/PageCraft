<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
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
        return TemplateResource::collection(Template::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateRequest $request): JsonResource
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            foreach ($validated as $setting) {
                Template::firstWhere('block', $setting['block'])->update(['template' => $setting['template']]);
            }
        });

        return TemplateResource::collection(Template::all());
    }
}
