<?php

declare(strict_types=1);

use App\Enums\ArticleStatus;
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
            $table->string('image')->nullable();
            $table->string('author');
            $table->enum('status', ArticleStatus::values())->default(ArticleStatus::DRAFT);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
