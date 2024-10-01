<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\User;
use Faker\Factory as Faker;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        foreach (range(1, 10) as $index) {
            Program::create([
                'name' => $faker->words(3, true), // Generates a random program name
                'lessons' => $faker->numberBetween(1, 50), // Generates a random small integer for lessons
                'published_at' => $faker->optional()->dateTime, // Randomly generate a timestamp or null
                'user_id' => $users->random()->id, // Associates the program with a random user
            ]);
        }
    }
}
