<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductCategoryController extends Controller
{
    public function products(Request $request, ProductCategory $productCategory): JsonResource
    {
        $limit = request()->get('limit', 10);

        $products = $productCategory->products()->active();

        $slugs = $request->query('slugs', '');
        if (! empty($slugs)) {
            $slugs = is_string($slugs) ? explode(',', $slugs) : $slugs;
            $slugs = array_filter($slugs);
            $products->whereIn('slug', $slugs);
        }

        return ProductResource::collection(
            $products->paginate($limit)
        );
    }
}
