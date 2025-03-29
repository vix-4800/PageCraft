<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ApiException extends Exception
{
    public function __construct(string $message = 'Internal Server Error', int $code = 500)
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
