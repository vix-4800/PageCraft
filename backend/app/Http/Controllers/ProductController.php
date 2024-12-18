<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public function __construct(
        private readonly ProductService $service
    ) {
        //
    }

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
     */
    public function store(StoreProductRequest $request): JsonResource
    {
        $validated = $request->validated();

        return ProductResource::make($this->service->storeProduct($validated));
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
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResource
    {
        $validated = $request->validated();

        return ProductResource::make($this->service->updateProduct($validated, $product));
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
