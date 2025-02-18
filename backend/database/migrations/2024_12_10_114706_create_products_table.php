<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductCategory;
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
        Schema::create('product_categories', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
        });

        Schema::create('products', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->json('product_images')->nullable();
            $table->boolean('is_archived')->default(false);

            $table->foreignIdFor(ProductCategory::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('product_variations', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_variations');
    }
};
