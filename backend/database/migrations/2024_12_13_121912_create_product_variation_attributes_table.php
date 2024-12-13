<?php

declare(strict_types=1);

use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
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
        Schema::create('product_variation_attributes', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(ProductVariation::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductAttributeValue::class)->constrained()->cascadeOnDelete();

            $table->unique(['product_variation_id', 'product_attribute_value_id'], 'product_variation_attribute_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_attributes');
    }
};
