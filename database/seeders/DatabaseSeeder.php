<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         \App\Modules\Users\User::factory(5)->create();
         \App\Modules\Chats\Chat::factory(5)->create();
         \App\Modules\Messages\Message::factory(20)->create();
    }
}
