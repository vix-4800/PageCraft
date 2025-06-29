<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $limit = request()->get('limit', 10);

        $products = Product::query()->with('productCategory')->active();

        $slugs = $request->query('slugs', '');
        if (filled($slugs)) {
            $slugs = is_string($slugs) ? explode(',', $slugs) : $slugs;
            $slugs = array_filter($slugs);
            $products->whereIn('slug', $slugs);
        }

        return ProductResource::collection(
            $products->paginate($limit)
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function best(): JsonResource
    {
        $limit = request()->get('limit', 10);

        return ProductResource::collection(
            Product::active()
                ->with('productCategory')
                ->withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->paginate($limit)
        );
    }

    public function popular(): JsonResource
    {
        $limit = request()->get('limit', 10);

        return ProductResource::collection(
            Product::active()
                ->with('productCategory')
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->paginate($limit)
        );
    }

    public function new(): JsonResource
    {
        $limit = request()->get('limit', 10);

        return ProductResource::collection(
            Product::active()
                ->with('productCategory')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $storeProductRequest): JsonResource
    {
        /**
         * @var array{
         *     name: string,
         *     slug: string,
         *     description: string,
         *     product_images: array<string>|null,
         *     variations: array<array<string>>
         * } $validated
         */
        $validated = $storeProductRequest->validated();

        return new ProductResource(
            $this->productService->storeProduct($validated)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResource
    {
        return new ProductResource(
            $product->load('variations.productVariationAttributes.productAttributeValue.productAttribute')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $updateProductRequest, Product $product): JsonResource
    {
        /**
         * @var array{
         *     name: string,
         *     slug: string,
         *     description: string,
         *     product_images: array<string>|null,
         *     variations: array<array<string>>
         * } $validated
         */
        $validated = $updateProductRequest->validated();

        return new ProductResource(
            $this->productService->updateProduct($validated, $product)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return ApiResponse::empty();
    }
}
