<?php

namespace Database\Factories;

use App\Modules\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'sender_id' => User::inRandomOrder()->first()->id,
            'recipient_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
