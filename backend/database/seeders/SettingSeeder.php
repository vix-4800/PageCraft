<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            [
                'key' => 'description',
                'value' => 'PageCraft is a lightweight, free and open source CMS for your website.',
            ],
            [
                'key' => 'keywords',
                'value' => 'pagecraft, cms, website, website builder, open source, free',
            ],
            [
                'key' => 'author',
                'value' => 'Vix',
            ],
            [
                'key' => 'email',
                'value' => 'email@example.com',
            ],
            [
                'key' => 'phone',
                'value' => '+41 79 123 45 67',
            ],
            [
                'key' => 'address',
                'value' => '123 Main Street, City, Country',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://www.facebook.com/pagecraft',
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/pagecraft',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://www.instagram.com/pagecraft',
            ],
            [
                'key' => 'social_vk',
                'value' => 'https://vk.com/pagecraft',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://www.youtube.com/channel/pagecraft',
            ],
            [
                'key' => 'social_telegram',
                'value' => 'https://t.me/pagecraft',
            ],
        ]);
    }
}
