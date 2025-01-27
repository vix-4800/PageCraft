<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::insert([
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
            ],
            [
                'block' => 'contact',
                'template' => 'default',
            ],
            [
                'block' => 'about',
                'template' => 'default',
            ],
            [
                'block' => 'article_list',
                'template' => 'default',
            ],
            [
                'block' => 'article_detail',
                'template' => 'default',
            ],
        ]);
    }
}
