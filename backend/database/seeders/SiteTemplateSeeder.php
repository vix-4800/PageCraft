<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SiteTemplate;
use Illuminate\Database\Seeder;

class SiteTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteTemplate::insert([
            [
                'block' => 'header',
                'template' => 'default',
            ],
            [
                'block' => 'footer',
                'template' => 'default',
            ],
            [
                'block' => 'product_list',
                'template' => 'default',
            ],
            [
                'block' => 'product_detail',
                'template' => 'default',
            ],
            [
                'block' => 'cart',
                'template' => 'default',
            ]
        ]);
    }
}
