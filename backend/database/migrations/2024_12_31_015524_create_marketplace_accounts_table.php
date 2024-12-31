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
        Schema::create('marketplaces', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('base_url');
        });

        Schema::create('marketplace_accounts', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->foreignId('marketplace_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('marketplace_account_settings', function (Blueprint $table): void {
            $table->id();

            $table->string('key');
            $table->string('value');
            $table->foreignId('marketplace_account_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
        Schema::dropIfExists('marketplace_accounts');
        Schema::dropIfExists('marketplace_account_settings');
    }
};
