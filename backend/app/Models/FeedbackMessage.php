<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\FeedbackMessageObserver;
use Database\Factories\FeedbackMessageFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $email
 * @property string|null $phone
 * @property string $message
 * @property string $subject
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static FeedbackMessageFactory factory($count = null, $state = [])
 * @method static Builder<static>|FeedbackMessage newModelQuery()
 * @method static Builder<static>|FeedbackMessage newQuery()
 * @method static Builder<static>|FeedbackMessage query()
 *
 * @mixin \Eloquent
 */
#[ObservedBy(FeedbackMessageObserver::class)]
final class FeedbackMessage extends Model
{
    /** @use HasFactory<FeedbackMessageFactory> */
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
