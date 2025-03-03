<?php

declare(strict_types=1);

namespace App\Mixins;

use Illuminate\Support\Facades\DB;
use Str;

final class StrMixin
{
    public function sku(): callable
    {
        return function (string $modelClass, string $prefix = 'PGP', string $separator = '-', string $skuField = 'sku', int $length = 8): string {
            $exists = function (string $sku) use ($modelClass, $skuField): bool {
                /** @var \Illuminate\Database\Eloquent\Model $model */
                $model = new $modelClass;

                return DB::table($model->getTable())->where($skuField, $sku)->exists();
            };

            do {
                $sku = Str::upper($prefix.$separator.Str::random($length));
            } while ($exists($sku));

            return $sku;
        };
    }
}
