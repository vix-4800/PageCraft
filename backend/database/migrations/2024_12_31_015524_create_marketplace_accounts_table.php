<?php

declare(strict_types=1);

use App\Models\Marketplace;
use App\Models\MarketplaceAccount;
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
            $table->foreignIdFor(Marketplace::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('marketplace_account_settings', function (Blueprint $table): void {
            $table->id();

            $table->string('key');
            $table->string('value');
            $table->foreignIdFor(MarketplaceAccount::class)->constrained()->cascadeOnDelete();

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
