<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReviewReactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_review_id
 * @property int $user_id
 * @property ReviewReactionType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductReview $productReview
 * @property-read User $user
 *
 * @method static \Database\Factories\ProductReviewReactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereProductReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewReaction whereUserId($value)
 *
 * @mixin \Eloquent
 */
class ProductReviewReaction extends Model
{
    /** @use HasFactory<\Database\Factories\ProductReviewReactionFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'product_review_id',
        'user_id',
    ];

    protected $casts = [
        'type' => ReviewReactionType::class,
    ];

    public function productReview(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
