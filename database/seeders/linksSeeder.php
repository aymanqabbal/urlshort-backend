<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class linksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Create fake users
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create fake links
        for ($i = 0; $i < 20; $i++) {
            DB::table('links')->insert([
                'users_id' => $faker->numberBetween(1, 10),
                'name' => $faker->firstName,
                'visits' => $faker->randomNumber(),
                'original' => $faker->url,
                'shortened' => $faker->unique()->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
