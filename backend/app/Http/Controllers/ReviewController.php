<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReviewStatus;
use App\Http\Requests\UpdateProductReviewStatusRequest;
use App\Http\Resources\ReviewResource;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $query = ProductReview::query()->with(['user', 'product.productCategory']);
        $limit = $request->input('limit', 10);

        if ($request->has('status') && in_array($request->get('status'), ReviewStatus::values())) {
            $query->where('status', $request->get('status'));
        }

        return ReviewResource::collection($query->paginate($limit));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductReview $productReview): ReviewResource
    {
        return new ReviewResource(
            $productReview->load(['user', 'product'])
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductReviewStatusRequest $updateProductReviewStatusRequest, ProductReview $productReview): ReviewResource
    {
        $productReview->update($updateProductReviewStatusRequest->validated());

        return new ReviewResource(
            $productReview->load(['user', 'product'])
        );
    }
}
