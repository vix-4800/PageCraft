<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarketplaceAccountSettingRequest;
use App\Http\Requests\UpdateMarketplaceAccountSettingRequest;
use App\Models\MarketplaceAccountSetting;

class MarketplaceAccountSettingController extends Controller
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
    public function store(StoreMarketplaceAccountSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketplaceAccountSetting $marketplaceAccountSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarketplaceAccountSettingRequest $request, MarketplaceAccountSetting $marketplaceAccountSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketplaceAccountSetting $marketplaceAccountSetting)
    {
        //
    }
}
