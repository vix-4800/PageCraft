<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

final class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(): JsonResource
    {
        return SettingResource::collection(Setting::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request): JsonResource
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            foreach ($validated as $setting) {
                Setting::firstWhere('key', $setting['key'])->update(['value' => $setting['value']]);
            }
        });

        return SettingResource::collection(Setting::all());
    }
}
