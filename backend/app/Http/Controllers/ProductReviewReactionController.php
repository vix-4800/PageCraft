<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProductReviewReactionRequest;
use App\Models\ProductReview;
use Illuminate\Http\Response;

class ProductReviewReactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductReviewReactionRequest $request, ProductReview $productReview): Response
    {
        $validated = $request->validated();

        $reaction = $productReview->reactions()->where('user_id', $request->user()->id)->first();

        if ($reaction) {
            if ($reaction->type !== $validated['type']) {
                $reaction->update([
                    'type' => $validated['type'],
                ]);
            } else {
                $reaction->delete();
            }
        } else {
            $productReview->reactions()->create([
                'type' => $validated['type'],
                'user_id' => $request->user()->id,
            ]);
        }

        return ApiResponse::empty();
    }
}
