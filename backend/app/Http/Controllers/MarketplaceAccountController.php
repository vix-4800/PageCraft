<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\MarketplaceAccountRequest;
use App\Http\Resources\MarketplaceAccount\MarketplaceAccountResource;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class MarketplaceAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return MarketplaceAccountResource::collection(MarketplaceAccount::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarketplaceAccountRequest $request): JsonResource
    {
        $validated = $request->validated();

        /** @var MarketplaceAccount $account */
        $account = MarketplaceAccount::create($validated['name']);

        $account->settings()->createMany($validated['settings']);

        return new MarketplaceAccountResource($account);
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
    public function update(MarketplaceAccountRequest $request, MarketplaceAccount $account): JsonResource
    {
        $validated = $request->validated();

        $account->update(['name' => $validated['name']]);

        $account->settings()->delete();
        $account->settings()->createMany($validated['settings']);

        return new MarketplaceAccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketplaceAccount $account): Response
    {
        $account->delete();

        return ApiResponse::empty();
    }
}
