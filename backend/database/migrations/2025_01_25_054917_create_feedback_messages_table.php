<?php

declare(strict_types=1);

use App\Enums\FeedbackSubject;
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
        Schema::create('feedback_messages', function (Blueprint $table): void {
            $table->id();

            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->enum('subject', FeedbackSubject::values());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_messages');
    }
};
