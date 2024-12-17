<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Str;

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

        try {
            DB::beginTransaction();

            /** @var Product $product */
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'image' => $validated['image'] ?? null,
            ]);

            collect($validated['variations'])->each(function (array $variation) use ($product): void {
                /** @var ProductVariation $createdVariation */
                $createdVariation = $product->variations()->create([
                    'sku' => $variation['sku'],
                    'price' => $variation['price'],
                    'stock' => $variation['stock'],
                    'image' => $variation['image'] ?? null,
                ]);

                collect($variation['attributes'])->each(function (array $attribute) use ($createdVariation): void {
                    /** @var ProductAttribute $attributeFromDb */
                    $attributeFromDb = ProductAttribute::firstOrCreate(['name' => $attribute['name']]);

                    /** @var ProductAttributeValue $attributeValueFromDb */
                    $attributeValueFromDb = $attributeFromDb->values()->firstOrCreate(['value' => $attribute['value']]);

                    ProductVariationAttribute::insert([
                        'product_variation_id' => $createdVariation->id,
                        'product_attribute_value_id' => $attributeValueFromDb->id,
                    ]);
                });
            });

            DB::commit();

            return ProductResource::make($product);
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
            // throw new ApiException;
        }
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
