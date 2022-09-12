<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         \App\Models\User::factory(5)->create();
         \App\Models\Message::factory(20)->create();
    }
}
