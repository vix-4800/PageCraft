<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $block
 * @property string $template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteTemplate whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'block',
        'template',
    ];
}
