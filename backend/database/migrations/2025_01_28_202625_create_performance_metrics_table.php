<?php

declare(strict_types=1);

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
        Schema::create('performance_metrics', function (Blueprint $table): void {
            $table->id();

            $table->float('cpu_usage', 2);

            $table->float('ram_usage', 2);
            $table->float('ram_total', 2);

            $table->float('network_incoming', 2);
            $table->float('network_outgoing', 2);

            $table->timestamp('collected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
