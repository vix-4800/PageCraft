<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SettingType;
use App\Models\SettingCategory;
use Illuminate\Database\Seeder;

final class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupedSettings = [
            'general' => [
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
                    'key' => 'is_maintenance',
                    'value' => false,
                    'type' => SettingType::BOOLEAN,
                ],
            ],
            'contact_info' => [
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
            ],
            'social_media' => [
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
            ],

        ];

        foreach ($groupedSettings as $categoryName => $categorySettings) {
            $category = SettingCategory::create(['name' => $categoryName]);
            $category->settings()->createMany($categorySettings);
        }
    }
}
