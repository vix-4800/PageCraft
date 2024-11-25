<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $header_template
 * @property string $footer_template
 * @property string $product_list_template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereFooterTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereHeaderTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereProductListTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageConfiguration whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PageConfiguration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'header_template',
        'footer_template',
        'product_list_template',
    ];
}
