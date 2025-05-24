<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class MethodNotAllowed extends Exception
{
    public function __construct(string $message = 'Method Not Allowed', int $code = Response::HTTP_METHOD_NOT_ALLOWED)
    {
        parent::__construct($message, $code);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return new JsonResponse([
            'data' => [],
            'error' => true,
            'message' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}
