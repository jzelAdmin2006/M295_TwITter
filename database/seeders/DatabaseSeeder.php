<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(60)->has(Tweet::factory()->count(50))->create();
        User::first()->update([
            'email' => 'user@example.com',
            'password' => bcrypt(getenv('EXAMPLE_USER_PASSWORD'))
        ]);
    }
}
