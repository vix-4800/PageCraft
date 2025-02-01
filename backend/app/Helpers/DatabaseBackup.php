<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Carbon;
use SplFileInfo;

class DatabaseBackup
{
    private readonly Carbon $date;

    private readonly string $name;

    private readonly float|int $size;

    public function __construct(string $filepath)
    {
        $fileInfo = new SplFileInfo($filepath);

        $creationDate = $fileInfo->getMTime();
        $this->date = $creationDate ? Carbon::createFromTimestamp($creationDate) : new Carbon;

        $this->name = $fileInfo->getBasename();
        $this->size = $fileInfo->getSize();
    }

    /**
     * @return array{
     *     date: string,
     *     name: string,
     *     size: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d H:i:s'),
            'name' => $this->name,
            'size' => round($this->size / 1048576, 2).' MB',
        ];
    }
}
