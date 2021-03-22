<?php

namespace Database\Factories;

use PayAny\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $cnpj = $this->faker->unique()->bothify('########0001##');
        $cpf =  $this->faker->unique()->bothify('0##########');
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
            'document' => $this->faker->randomElement([$cnpj, $cpf]),
        ];
    }
}
