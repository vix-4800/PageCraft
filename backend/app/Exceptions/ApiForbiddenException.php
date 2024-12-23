<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ApiForbiddenException extends ApiException
{
    public function __construct(string $message = 'Forbidden')
    {
        parent::__construct($message, 403);
    }
}
