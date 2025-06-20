<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $limit = $request->input('limit', 10);

        // TODO All articles for admin panel

        return ArticleResource::collection(
            Article::published()
                ->paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $articleRequest): JsonResource
    {
        $article = Article::create($articleRequest->validated());

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): JsonResource
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $articleRequest, Article $article): JsonResource
    {
        $article->update($articleRequest->validated());

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): Response
    {
        $article->delete();

        return ApiResponse::empty();
    }
}
