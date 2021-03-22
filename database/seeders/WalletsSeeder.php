<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PayAny\Models\User;
use PayAny\Models\Wallet;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(10)
            ->has(Wallet::factory()->count(1))
            ->create();
    }
}
