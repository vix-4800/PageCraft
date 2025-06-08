<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Article
 */
final class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'description' => $this->description,
            'status' => $this->status,
            'image' => Storage::disk('public')->url($this->image),
            'author' => $this->author,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
