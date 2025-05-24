<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(1)->for(Role::firstWhere('name', UserRole::ADMIN))->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ])
            ->first()->preferences()->create();

        User::factory(10)->for(Role::firstWhere('name', UserRole::CUSTOMER))->create()->each(function (User $user): void {
            $user->preferences()->create();
        });
    }
}
