<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Learners;
use App\Models\Program;

class LearnersInProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all learners and programs
        $learners = Learners::all();
        $programs = Program::all();

        // Assign each learner to a random number of programs
        foreach ($learners as $learner) {
            // Randomly select a subset of programs for each learner
            $programsToAssign = $programs->random(rand(1, $programs->count()));

            // Attach the learner to the selected programs
            foreach ($programsToAssign as $program) {
                $learner->programs()->attach($program->id);
            }
        }
    }
}