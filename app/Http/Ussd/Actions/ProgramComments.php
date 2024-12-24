<?php

namespace App\Http\Ussd\Actions;

use App\Http\Ussd\States\RegistrationSuccessState;
use App\Models\Comment;
use Sparors\Ussd\Action;
use App\Models\Learners;
use App\Models\Program;

class ProgramComments extends Action
{
    public function run(): string
    {
        $programId = $this->record->get('program_id');
        $phoneNumber = $this->record->get('phoneNumber');
        $learner = Learners::where('phone_number', $phoneNumber)->first();
        $comment = $this->record->get('comment');

        // Save feedback to the database
        Comment::create([
            'learners_id' => $learner->id,
            'program_id' => $programId,
            'commentable_id' => $programId,
            'commentable_type' => Program::class,
            'comment' => $comment // Generating a random comment string
        ]);

          // Redirect to success state
          return RegistrationSuccessState::class;
    }
}
