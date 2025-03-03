<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $icon
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 * @property-read int|null $articles_count
 *
 * @method static \Database\Factories\ArticleTagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleTag query()
 *
 * @mixin \Eloquent
 */
final class ArticleTag extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleTagFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
