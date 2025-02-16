<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class SearchIndexController extends Controller
{
    public function articles(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => "App\Models\Article",
        ]);

        return ApiResponse::empty();
    }

    public function products(): Response
    {
        Artisan::call('scout:update-indexes', [
            'model' => "App\Models\Product",
        ]);

        return ApiResponse::empty();
    }
}
