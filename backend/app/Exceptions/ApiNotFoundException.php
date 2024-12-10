<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ApiNotFoundException extends ApiException
{
    public function __construct(string $message = 'Not Found', ?\Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
