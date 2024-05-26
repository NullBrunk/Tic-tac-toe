<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Create the "a@a.a:a" user
            UserSeeder::class,
        ]);
        $users = \App\Models\User::factory(20)->create();
        $games = \App\Models\Game::factory(10)->create();

        foreach($users as $user) { 
            var_dump($user -> email);
            echo "\n\n";
        }
        
    }
}
