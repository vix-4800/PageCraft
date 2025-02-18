<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Setting> $settings
 * @property-read int|null $settings_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingCategory query()
 *
 * @mixin \Eloquent
 */
class SettingCategory extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
