<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductReviewController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'store']),
        ];
    }

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
    public function store(StoreProductReviewRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductReviewRequest $request, ProductReview $productReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductReview $productReview)
    {
        //
    }
}
