<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::inRandomOrder()->take(random_int(1, 5))->each(function (User $user): void {
            $user->userAddresses()->saveMany(UserAddress::factory(random_int(1, 5))->make());
        });
    }
}
