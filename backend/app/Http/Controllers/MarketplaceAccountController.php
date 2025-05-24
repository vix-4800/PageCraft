<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\MarketplaceAccountRequest;
use App\Http\Resources\MarketplaceAccount\MarketplaceAccountResource;
use App\Models\Marketplace;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class MarketplaceAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return MarketplaceAccountResource::collection(
            MarketplaceAccount::with(['settings', 'marketplace'])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarketplaceAccountRequest $marketplaceAccountRequest): JsonResource
    {
        $validated = $marketplaceAccountRequest->validated();

        /** @var Marketplace|null $marketplace */
        $marketplace = Marketplace::firstWhere('name', $validated['marketplace']);

        /** @var MarketplaceAccount $model */
        $model = $marketplace->accounts()->create(['name' => $validated['name']]);

        $model->settings()->createMany($validated['settings']);

        return new MarketplaceAccountResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketplaceAccount $account): JsonResource
    {
        return new MarketplaceAccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarketplaceAccountRequest $marketplaceAccountRequest, MarketplaceAccount $marketplaceAccount): JsonResource
    {
        $validated = $marketplaceAccountRequest->validated();

        /** @var Marketplace|null $marketplace */
        $marketplace = Marketplace::firstWhere('name', $validated['marketplace']);

        $marketplaceAccount->update([
            'name' => $validated['name'],
            'marketplace_id' => $marketplace->id,
        ]);

        $marketplaceAccount->settings()->createMany($validated['settings']);

        return new MarketplaceAccountResource($marketplaceAccount);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketplaceAccount $marketplaceAccount): Response
    {
        $marketplaceAccount->delete();

        return ApiResponse::empty();
    }
}
