<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\ProductVariation;
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
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->enum('status', OrderStatus::values())->default(OrderStatus::CREATED);

            $table->decimal('sub_total', 8, 2);
            $table->decimal('shipping', 8, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('total', 8, 2);

            $table->text('note')->nullable();

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductVariation::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
};
