<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResource
    {
        return ReviewResource::collection($product->reviews->load('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductReviewRequest $storeProductReviewRequest, Product $product): JsonResource
    {
        $validated = $storeProductReviewRequest->validated();

        return new ReviewResource($product->reviews()->create(
            array_merge($validated, ['user_id' => $storeProductReviewRequest->user()->id])
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductReviewRequest $updateProductReviewRequest, ProductReview $productReview): void
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductReview $productReview): Response
    {
        // TODO

        return ApiResponse::empty();
    }
}
