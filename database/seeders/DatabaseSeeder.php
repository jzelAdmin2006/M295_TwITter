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
        User::factory()
            ->count(60)
            ->create()
            ->each(function ($user) {
                Tweet::factory()
                    ->count(random_int(0, 50))
                    ->create([
                        'user_id' => $user->id
                    ]);
                $user->likes()->attach(
                    Tweet::inRandomOrder()
                        ->limit(random_int(0, 50))
                        ->pluck('id')
                );
            });
        User::first()->update([
            'email' => 'user@example.com',
            'password' => bcrypt(getenv('EXAMPLE_USER_PASSWORD'))
        ]);
    }
}
