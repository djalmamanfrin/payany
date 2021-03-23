<?php

namespace Database\Factories;

use PayAny\Models\User;
use PayAny\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'uuid' => $this->faker->uuid,
        ];
    }
}
