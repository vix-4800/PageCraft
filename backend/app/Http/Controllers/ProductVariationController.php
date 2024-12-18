<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductVariationResource;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productVariationsQuery = ProductVariation::query();

        $skus = explode(',', $request->query('skus', ''));
        if (! empty($skus)) {
            $productVariationsQuery->whereIn('sku', $skus);
        }

        return ProductVariationResource::collection(
            $productVariationsQuery->with(['product', 'productVariationAttributes'])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariation $productVariation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariation $productVariation)
    {
        //
    }
}
