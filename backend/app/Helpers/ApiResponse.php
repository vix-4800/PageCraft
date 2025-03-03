<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

final class ApiResponse extends JsonResponse
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
     * @param  array<string|int, mixed>|Collection  $data  The response data.
     * @param  int  $status  The HTTP status code.
     * @param  array<string, mixed>|Collection  $meta  The response meta data.
     */
    public static function create(array|Collection $data = [], int $status = 200, array|Collection $meta = []): JsonResponse
    {
        $response = [];
        $response['data'] = is_array($data) ? $data : $data->toArray();

        if (! empty($meta)) {
            $response['meta'] = is_array($meta) ? $meta : $meta->toArray();
        }

        return new JsonResponse($response, $status);
    }
}
