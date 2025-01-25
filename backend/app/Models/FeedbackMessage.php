<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string|null $phone
 * @property string $message
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\FeedbackMessageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedbackMessage whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class FeedbackMessage extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackMessageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'message',
        'subject',
    ];
}
