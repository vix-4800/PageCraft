<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ArticleTagFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $icon
 * @property-read Collection<int, Article> $articles
 * @property-read int|null $articles_count
 *
 * @method static ArticleTagFactory factory($count = null, $state = [])
 * @method static Builder<static>|ArticleTag newModelQuery()
 * @method static Builder<static>|ArticleTag newQuery()
 * @method static Builder<static>|ArticleTag query()
 *
 * @mixin \Eloquent
 */
final class ArticleTag extends Model
{
    /** @use HasFactory<ArticleTagFactory> */
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
