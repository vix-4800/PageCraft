<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ApiNotFoundException extends ApiException
{
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, 404);
    }
}
