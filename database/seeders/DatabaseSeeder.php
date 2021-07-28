<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use App\Models\Profile;
use App\Models\Chat_Reply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();
         \App\Models\Profile::factory(10)->create();
         \App\Models\Chat::factory(10)->create();
         \App\Models\Chat_Reply::factory(10)->create();
    }
}
