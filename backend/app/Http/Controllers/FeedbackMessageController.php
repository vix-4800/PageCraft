<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackMessageRequest;
use App\Http\Resources\FeedbackMessageResource;
use App\Models\FeedbackMessage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FeedbackMessageController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array<int, Middleware|string>
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'admin'], except: ['store']),
        ];
    }

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
    public function store(StoreFeedbackMessageRequest $request): JsonResource
    {
        return new FeedbackMessageResource(
            FeedbackMessage::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedbackMessage $message): JsonResource
    {
        return new FeedbackMessageResource($message);
    }
}
