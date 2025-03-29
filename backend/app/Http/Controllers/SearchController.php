<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $search = trim($request->get('q') ?? '');

        return ApiResponse::create([
            'products' => ProductResource::collection(Product::search($search)->get()),
            'articles' => ArticleResource::collection(Article::search($search)->get()),
        ]);
    }
}
