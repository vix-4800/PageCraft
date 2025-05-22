<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

final class SearchIndexController extends Controller
{
    public function articles(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => Article::class,
        ]);

        return ApiResponse::empty();
    }

    public function products(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => Product::class,
        ]);

        return ApiResponse::empty();
    }
}
