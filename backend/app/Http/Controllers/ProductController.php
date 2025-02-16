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

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $limit = request()->get('limit', 10);

        $products = Product::query()->active();

        $slugs = $request->query('slugs', '');
        if (! empty($slugs)) {
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
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResource
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
        $validated = $request->validated();

        return new ProductResource(
            $this->service->storeProduct($validated)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResource
    {
        return new ProductResource(
            $product->load('variations.productVariationAttributes')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResource
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
        $validated = $request->validated();

        return new ProductResource(
            $this->service->updateProduct($validated, $product)
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
