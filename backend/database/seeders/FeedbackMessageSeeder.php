<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FeedbackMessage;
use Illuminate\Database\Seeder;

final class FeedbackMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeedbackMessage::factory(10)->create();
    }
}
