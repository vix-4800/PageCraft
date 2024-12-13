<?php

declare(strict_types=1);

use App\Models\ProductAttribute;
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
        Schema::create('product_attributes', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
        });

        Schema::create('product_attribute_values', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(ProductAttribute::class)->constrained()->cascadeOnDelete();
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_attribute_values');
    }
};
