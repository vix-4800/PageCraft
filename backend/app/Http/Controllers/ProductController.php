<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * TODO Pagination
     */
    public function index(): JsonResource
    {
        return ProductResource::collection(Product::active()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * TODO Creation logic
     */
    public function store(StoreProductRequest $request): JsonResource
    {
        return ProductResource::make(Product::create());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResource
    {
        return ProductResource::make($product->load('variations.productVariationAttributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * TODO Update logic
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResource
    {
        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
