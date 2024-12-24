<?php

namespace App\Http\Ussd\Actions;

use App\Http\Ussd\States\CommentState;
use App\Http\Ussd\States\RegistrationSuccessState;
use Sparors\Ussd\Action;
use App\Models\Learners;
use App\Models\Program;
use App\Models\Satisfactions;

class FeedBackAction extends Action
{
    public function run(): string
    {
        $programId = $this->record->get('program_id');
        $phoneNumber = $this->record->get('phoneNumber');
        $learner = Learners::where('phone_number', $phoneNumber)->first();
        $feedback = $this->record->get('feedback');


        // Save feedback to the database
        Satisfactions::create([
            'learners_id' => $learner->id,
            'program_id' => $programId,
            'satisfiable_id' => $programId,
            'satisfiable_type' => Program::class,
            'satisfaction_level' => $feedback, // Randomly select a satisfaction level between 1 and 4
        ]);

        // Increment programs completed
        $learner->increment('programs_completed');

         // Redirect to success state
       return CommentState::class;
    }
}
