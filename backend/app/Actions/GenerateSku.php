<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Str;

class GenerateSku
{
    /**
     * @var string Model to generate SKUs for.
     */
    public function __construct(
        protected string $modelClass,
        protected string $prefix = 'PGP',
        protected string $separator = '-',
        protected string $skuField = 'sku',
        protected int $length = 8
    ) {}

    public function handle(): string
    {
        do {
            $sku = Str::upper($this->prefix.$this->separator.Str::random($this->length));
        } while ($this->exists($sku));

        return $sku;
    }

    /**
     * True if the value already exists in the DB.
     */
    protected function exists(string $sku): bool
    {
        return DB::table((new $this->modelClass)->getTable())
            ->where($this->skuField, $sku)
            ->exists();
    }
}
