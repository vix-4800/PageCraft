<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Str;

class GenerateSku
{
    /**
     * @param  string  $modelClass  the class of the model to generate a SKU for
     * @param  string  $prefix  the prefix for the SKU (defaults to 'PGP')
     * @param  string  $separator  the separator between the prefix and the random part of the SKU (defaults to '-')
     * @param  string  $skuField  the field on the model to store the SKU (defaults to 'sku')
     * @param  int  $length  the length of the random part of the SKU (defaults to 8)
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
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $this->modelClass;

        return DB::table($model->getTable())
            ->where($this->skuField, $sku)
            ->exists();
    }
}
