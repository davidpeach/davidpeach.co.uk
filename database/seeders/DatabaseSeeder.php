<?php

namespace Database\Seeders;

use App\Models\User;
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
        // $this->call(PostSeeder::class);
        User::factory()->create([
            'name' => env('MY_NAME'),
            'email' => env('MY_EMAIL'),
            'password' => bcrypt(env('MY_PASSWORD')),
        ]);
    }
}
