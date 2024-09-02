<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Learners;
use App\Models\Program;
use App\Models\Comment;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all learners and programs
        $learners = Learners::all();
        $programs = Program::all();

        // Seed random comments
        foreach ($learners as $learner) {
            // Assign a random number of comments for each learner
            $numberOfComments = rand(1, 5); // For example, each learner creates 1 to 5 comments

            for ($i = 0; $i < $numberOfComments; $i++) {
                $program = $programs->random();

                Comment::create([
                    'learners_id' => $learner->id,
                    'program_id' => $program->id,
                    'commentable_id' => $program->id,
                    'commentable_type' => Program::class,
                    'comment' => $faker->sentence, // Generating a random comment string
                ]);
            }
        }
    }
}
