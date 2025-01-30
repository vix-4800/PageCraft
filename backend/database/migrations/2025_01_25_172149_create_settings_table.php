<?php

declare(strict_types=1);

use App\Enums\SettingType;
use App\Models\SettingCategory;
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
        Schema::create('setting_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
        });

        Schema::create('settings', function (Blueprint $table): void {
            $table->id();

            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->enum('type', SettingType::values())->default(SettingType::TEXT);
            $table->foreignIdFor(SettingCategory::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
