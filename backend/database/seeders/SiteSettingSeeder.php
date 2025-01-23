<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::insert([
            [
                'key' => 'site_description',
                'value' => 'PageCraft is a lightweight, free and open source CMS for your website.',
            ],
            [
                'key' => 'site_keywords',
                'value' => 'pagecraft, cms, website, website builder, open source, free',
            ],
            [
                'key' => 'site_author',
                'value' => 'Vix',
            ],
            [
                'key' => 'site_email',
                'value' => 'email@example.com',
            ],
            [
                'key' => 'site_phone',
                'value' => '+41 79 123 45 67',
            ],
            [
                'key' => 'site_address',
                'value' => '123 Main Street, City, Country',
            ],
        ]);
    }
}
