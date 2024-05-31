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
        $users = \App\Models\User::factory(20)->create();
        $games = \App\Models\Game::factory(10_000)->create();

        foreach($games as $game) {
            $first_user = $users->random();
            $second_user = $users->random();

            \App\Models\User_join::factory(1)->create([
                'user_id' => $first_user->id,
                'game_id' => $game->id,
                'symbol' => "O",
            ]);

            \App\Models\User_join::factory(1)->create([
                'user_id' => $second_user->id,
                'game_id' => $game->id,
                'symbol' => "X",
            ]);
        }
    }
}
