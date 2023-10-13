<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Visit;

class visitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Visit::create([
                'links_id' => $faker->numberBetween(1, 10),
                'visitor_ip' => $faker->ipv4,
                'country' => $faker->countryCode,
                'referrer' => $faker->url,
                'user_agent' => $faker->userAgent,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}
