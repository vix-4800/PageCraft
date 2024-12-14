<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    /**
     * Get the values of the OrderStatus enum cases.
     *
     * @return array<string> The values of the OrderStatus enum cases.
     */
    public static function values(): array
    {
        return array_map(
            fn (self $case): string => $case->value,
            self::cases(),
        );
    }
}
