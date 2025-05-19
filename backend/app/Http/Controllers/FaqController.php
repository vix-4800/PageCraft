<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return FaqResource::collection(Faq::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request): JsonResource
    {
        $model = Faq::create($request->validated());

        return new JsonResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq): JsonResource
    {
        return new FaqResource($faq);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq): JsonResource
    {
        $faq->update($request->validated());

        return new FaqResource($faq);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq): Response
    {
        $faq->delete();

        return ApiResponse::empty();
    }
}
