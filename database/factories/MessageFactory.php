<?php

namespace Database\Factories;

use App\Modules\Chats\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'message' => $this->faker->text(),
            'chat_id' => Chat::inRandomOrder()->first()->id,
        ];
    }
}
