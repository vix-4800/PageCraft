<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use SplFileInfo;

final readonly class DatabaseBackup implements Arrayable
{
    private Carbon $date;

    private string $name;

    private float|int $size;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getSize(): float|int
    {
        return $this->size;
    }
}
