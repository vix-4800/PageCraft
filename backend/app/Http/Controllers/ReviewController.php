<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReviewStatus;
use App\Http\Resources\ReviewResource;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $query = ProductReview::query();

        if ($request->has('status') && in_array($request->get('status'), ReviewStatus::values())) {
            $query->where('status', $request->get('status'));
        }

        return ReviewResource::collection($query->get()->load(['user', 'product']));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductReview $productReview): JsonResource
    {
        return new ReviewResource(
            $productReview->load(['user', 'product'])
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductReview $productReview)
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
