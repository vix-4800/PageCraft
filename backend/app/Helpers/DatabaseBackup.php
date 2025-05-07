<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use SplFileInfo;

final readonly class DatabaseBackup implements Arrayable
{
    private Carbon $carbon;

    private string $name;

    private float|int $size;

    public function __construct(string $filepath)
    {
        $fileInfo = new SplFileInfo($filepath);

        $creationDate = $fileInfo->getMTime();
        $this->carbon = $creationDate ? Carbon::createFromTimestamp($creationDate) : new Carbon;

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
            'date' => $this->carbon->format('Y-m-d H:i:s'),
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
        return $this->carbon;
    }

    public function getSize(): float|int
    {
        return $this->size;
    }
}
