<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductVariationResource;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $productVariationsQuery = ProductVariation::query();

        $skus = $request->query('skus', '');
        if (! empty($skus)) {
            $skus = is_string($skus) ? explode(',', $skus) : $skus;
            $skus = array_filter($skus);
            $productVariationsQuery->whereIn('sku', $skus);
        }

        return ProductVariationResource::collection(
            $productVariationsQuery->with(['product', 'productVariationAttributes'])->get()
        );
    }
}
