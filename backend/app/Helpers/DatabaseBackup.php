<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DatabaseBackup
{
    private readonly Carbon $date;

    private readonly string $name;

    private readonly float|int $size;

    public function __construct(
        private readonly string $filepath
    ) {
        $this->date = Carbon::createFromTimestamp(filemtime($filepath));
        $this->name = pathinfo($filepath, PATHINFO_BASENAME);
        $this->size = filesize($filepath);
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d H:i:s'),
            'name' => $this->name,
            'size' => round($this->size / 1048576, 2).' MB',
        ];
    }
}
