<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

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
     * @param  array|Collection  $data  The response data.
     * @param  int  $status  The HTTP status code.
     */
    public static function create(array|Collection $data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse(['data' => is_array($data) ? $data : $data->toArray()], $status);
    }
}
