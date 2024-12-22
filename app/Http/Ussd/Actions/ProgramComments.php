<?php

namespace App\Http\Ussd\Actions;

use Sparors\Ussd\Action;
use App\Models\Learners;

class ProgramComments extends Action
{
    public function run(): string
    {
        $programId = $this->record->get('program_id');
        $comment = $this->record->get('comment');
        $learner = Learners::where('phone_number', $this->session->phoneNumber)->first();

        // Save the comment to the database
        $learner->comments()->create([
            'program_id' => $programId,
            'comment' => $comment,
        ]);

        return 'Thank you for your feedback! Returning to the main menu.';
    }
}
