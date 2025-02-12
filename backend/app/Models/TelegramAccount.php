<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $chat_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramAccount whereUserId($value)
 *
 * @mixin \Eloquent
 */
class TelegramAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'chat_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
