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
                'name' => 'header',
                'title' => 'Header',
                'description' => 'Header of the website',
                'template' => 'default',
            ],
            [
                'name' => 'footer',
                'title' => 'Footer',
                'description' => 'Footer of the website',
                'template' => 'default',
            ],
            [
                'name' => 'product_list',
                'title' => 'Product List',
                'description' => 'List of products',
                'template' => 'default',
            ],
            [
                'name' => 'product_detail',
                'title' => 'Product Detail',
                'description' => 'Product show page',
                'template' => 'default',
            ],
            [
                'name' => 'cart',
                'title' => 'Cart',
                'description' => 'Cart page',
                'template' => 'default',
            ],
            [
                'name' => 'contact',
                'title' => 'Contact',
                'description' => 'Contact us page',
                'template' => 'default',
            ],
            [
                'name' => 'about',
                'title' => 'About',
                'description' => 'About us page',
                'template' => 'default',
            ],
            [
                'name' => 'article_list',
                'title' => 'Article List',
                'description' => 'List of articles',
                'template' => 'default',
            ],
            [
                'name' => 'article_detail',
                'title' => 'Article Detail',
                'description' => 'Article show page',
                'template' => 'default',
            ],
        ]);
    }
}
