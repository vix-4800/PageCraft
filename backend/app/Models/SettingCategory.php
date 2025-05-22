<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, Setting> $settings
 * @property-read int|null $settings_count
 *
 * @method static Builder<static>|SettingCategory newModelQuery()
 * @method static Builder<static>|SettingCategory newQuery()
 * @method static Builder<static>|SettingCategory query()
 *
 * @mixin \Eloquent
 */
final class SettingCategory extends Model
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
