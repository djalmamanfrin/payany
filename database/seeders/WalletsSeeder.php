<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PayAny\Models\User;
use PayAny\Models\Wallet;

class WalletsSeeder extends Seeder
{
    public function run()
    {
        Wallet::factory()
            ->count(10)
            ->create();
    }
}
