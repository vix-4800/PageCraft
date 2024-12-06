<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ApiNotFoundException extends Exception
{
    public function __construct(string $message = 'Not Found', ?\Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
