<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

final class SearchIndexController extends Controller
{
    public function articles(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => \App\Models\Article::class,
        ]);

        return ApiResponse::empty();
    }

    public function products(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => \App\Models\Product::class,
        ]);

        return ApiResponse::empty();
    }
}
