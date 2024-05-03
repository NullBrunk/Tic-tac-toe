<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        DB::table("users") -> insert([
            "email" => "a@a.a",
            "name" => $faker -> name(),
            // This hashed password corresponds to "a"
            "password" => "e9b35379a4a2155324153569bea58a99de746e9e1603da9721bdd06271bebb2512358b3a65dd5631f5251796f444cc7047d1aacd49d65e2928343c6b8aa79052",
            
            // Auto validate the mail of this test user
            "confirmation_token" => null,
        ]);
    }
}
