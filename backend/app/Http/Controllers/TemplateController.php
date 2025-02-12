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
     *
     * @return array<int, Middleware|string>
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
        $templates = $request->validated();

        DB::transaction(fn (): bool => array_walk($templates, function (array $template): void {
            Template::firstWhere('name', $template['name'])->update([
                'template' => $template['template'],
                'is_visible' => $template['is_visible'],
            ]);
        }));

        return TemplateResource::collection(Template::all());
    }
}
