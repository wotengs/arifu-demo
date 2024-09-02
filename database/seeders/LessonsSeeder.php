<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lessons;
use App\Models\Program;
use App\Models\User;
use Faker\Factory as Faker;

class LessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        $programs = Program::all();

        foreach (range(1, 50) as $index) {
            Lessons::create([
                '#' => $faker->unique()->randomNumber, // Generates a unique random number
                'color' => $faker->safeColorName, // Generates a random color name
                'user_id' => $users->random()->id, // Associates the lesson with a random user
                'program_id' => $programs->random()->id, // Associates the lesson with a random program
                'sent' => $faker->boolean, // Randomly true or false
                'english' => $faker->sentence, // Generates a random English sentence
                'swahili' => $faker->sentence, // Generates a random Swahili sentence
            ]);
        }
    }
}
