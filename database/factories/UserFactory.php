<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email()
        ];
    }
}
