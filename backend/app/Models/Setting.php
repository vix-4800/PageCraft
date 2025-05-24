<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SettingType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $key
 * @property string|bool|null $value
 * @property SettingType $type
 * @property int $setting_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read SettingCategory $settingCategory
 *
 * @method static Builder<static>|Setting newModelQuery()
 * @method static Builder<static>|Setting newQuery()
 * @method static Builder<static>|Setting query()
 *
 * @mixin \Eloquent
 */
final class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public function getValueAttribute(string|bool|null $value): string|bool|null
    {
        return $this->type === SettingType::BOOLEAN ? (bool) $value : $value;
    }

    public function settingCategory(): BelongsTo
    {
        return $this->belongsTo(SettingCategory::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => SettingType::class,
        ];
    }
}
