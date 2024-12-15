<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ApiUnauthenticatedException extends ApiException
{
    public function __construct(string $message = 'Unauthenticated')
    {
        parent::__construct($message, 401);
    }
}
