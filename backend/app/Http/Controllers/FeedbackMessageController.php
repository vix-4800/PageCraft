<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackMessageRequest;
use App\Http\Resources\FeedbackMessageResource;
use App\Models\FeedbackMessage;
use Illuminate\Http\Resources\Json\JsonResource;

final class FeedbackMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $limit = request()->get('limit', 10);

        return FeedbackMessageResource::collection(
            FeedbackMessage::paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackMessageRequest $storeFeedbackMessageRequest): JsonResource
    {
        return new FeedbackMessageResource(
            FeedbackMessage::create($storeFeedbackMessageRequest->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedbackMessage $feedbackMessage): JsonResource
    {
        return new FeedbackMessageResource($feedbackMessage);
    }
}
