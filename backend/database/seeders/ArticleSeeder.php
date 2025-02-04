<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(15)->published()->create()->each(function (Article $article): void {
            $tags = ArticleTag::factory(random_int(1, 3))->create();

            // $article->articleTags()->saveMany($tags);
        });
    }
}
