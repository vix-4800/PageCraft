<?php

declare(strict_types=1);

use App\Enums\ReviewReactionType;
use App\Models\ProductReview;
use App\Models\User;
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
        Schema::create('product_review_reactions', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(ProductReview::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->enum('type', ReviewReactionType::values());

            $table->timestamps();

            $table->unique(['product_review_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_review_reactions');
    }
};
