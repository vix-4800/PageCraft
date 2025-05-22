<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ArticleStatus;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $description
 * @property string|null $image
 * @property string $author
 * @property ArticleStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ArticleTag> $articleTags
 * @property-read int|null $article_tags_count
 *
 * @method static ArticleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article query()
 *
 * @mixin \Eloquent
 */
final class Article extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'author',
        'status',
        'image',
        'description',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->getKey(),
            'title' => $this->title,
            'content' => $this->content,
            'description' => $this->description,
            'author' => $this->author,
            'created_at' => $this->created_at,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isPublished();
    }

    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    public function setContentAttribute(string $value): void
    {
        $this->attributes['content'] = Purify::clean($value);
    }

    public function articleTags(): HasMany
    {
        return $this->hasMany(ArticleTag::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ArticleStatus::class,
        ];
    }
}
