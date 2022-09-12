<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'message' => $this->faker->text(),
            'sender' => User::inRandomOrder()->first(),
            'by_user' => User::inRandomOrder()->first()
        ];
    }
}
