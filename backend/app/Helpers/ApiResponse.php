<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse extends JsonResponse
{
    /**
     * Return an error response.
     *
     * @param  string  $message  The error message.
     * @param  int  $code  The HTTP status code.
     */
    public static function error(string $message = 'Something went wrong', int $code = 500): JsonResponse
    {
        return response()->json([
            'data' => [],
            'error' => true,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

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
    public static function response(array $data = [], int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }
}
