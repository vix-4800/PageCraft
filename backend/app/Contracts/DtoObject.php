<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface DtoObject extends Arrayable
{
    /**
     * Create a new instance from an array.
     */
    public static function fromArray(array $data): self;
}
