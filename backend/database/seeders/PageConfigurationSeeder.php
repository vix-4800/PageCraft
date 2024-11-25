<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PageConfiguration;
use Illuminate\Database\Seeder;

class PageConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageConfiguration::create([
            'header_template' => 'default',
            'footer_template' => 'default',
            'product_list_template' => 'default',
        ]);
    }
}
