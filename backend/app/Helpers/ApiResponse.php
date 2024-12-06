<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse extends JsonResponse
{
    /**
     * Return an empty response.
     */
    public static function empty(): Response
    {
        return response()->noContent();
    }

    /**
     * Return a JSON response.
     *
     * @param  array<string, mixed>  $data  The response data.
     * @param  int  $status  The HTTP status code.
     */
    public static function create(array $data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse(['data' => $data], $status);
    }
}
