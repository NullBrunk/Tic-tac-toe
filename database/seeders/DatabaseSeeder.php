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
        $game_number = $this->command->ask("How many game do you want to generate", 10000);
        $user_number = $this->command->ask("How many users do you want to generate", 20);

        $this->command->info(" Generating {$user_number} users");
        $users = \App\Models\User::factory($user_number)->create();

        $this->command->info(" Generating {$game_number} games");
        $games = \App\Models\Game::factory($game_number)->create();


        $this->command->info(" Adding random users to random games");
        $this->command->withProgressBar($game_number, function ($bar) use ($game_number, $games, $users) {
            foreach ($games as $game) {
                $bar->advance();
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
        });

        $this->command->info("\n\n You may log-in using '{$users->random()->email}' with password 'a'");
    }
}
