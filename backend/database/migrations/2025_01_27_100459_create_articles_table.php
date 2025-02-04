<?php

declare(strict_types=1);

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table): void {
            $table->id();

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->string('description');
            $table->string('image')->nullable();
            $table->string('author');
            $table->enum('status', ArticleStatus::values())->default(ArticleStatus::DRAFT);

            $table->timestamps();
        });

        Schema::create('article_tags', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('icon')->nullable();
        });

        Schema::create('article_article_tag', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Article::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ArticleTag::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_tags');
        Schema::dropIfExists('article_article_tag');
    }
};
