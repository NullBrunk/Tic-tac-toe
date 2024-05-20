<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        // Create the a@a.a:a user
        User::create([
            "email" => "a@a.a",
            "name" => $faker->name(),
            // This hashed password = a
            "password" => "e9b35379a4a2155324153569bea58a99de746e9e1603da9721bdd06271bebb2512358b3a65dd5631f5251796f444cc7047d1aacd49d65e2928343c6b8aa79052",
            // Auto validate the mail of the user
            "confirmation_token" => null,
            // User is not using TFA (totp)
            "secret" => null,
        ]);
    }
}
