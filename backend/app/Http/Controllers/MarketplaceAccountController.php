<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarketplaceAccountRequest;
use App\Http\Requests\UpdateMarketplaceAccountRequest;
use App\Models\MarketplaceAccount;

class MarketplaceAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarketplaceAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketplaceAccount $marketplaceAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarketplaceAccountRequest $request, MarketplaceAccount $marketplaceAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketplaceAccount $marketplaceAccount)
    {
        //
    }
}
