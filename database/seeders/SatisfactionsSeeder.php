<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Learners;
use App\Models\Program;
use App\Models\Satisfactions;
use Faker\Factory as Faker;

class SatisfactionsSeeder extends Seeder
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

        // Seed random satisfactions
        foreach ($learners as $learner) {
            $program = $programs->random();

            Satisfactions::create([
                'learners_id' => $learner->id,
                'program_id' => $program->id,
                'satisfiable_id' => $program->id,
                'satisfiable_type' => Program::class,
                'satisfaction_level' => $faker->numberBetween(1, 4), // Randomly select a satisfaction level between 1 and 4
            ]);
        }
    }
}
