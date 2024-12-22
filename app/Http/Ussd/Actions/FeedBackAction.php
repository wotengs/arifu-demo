<?php

namespace App\Http\Ussd\Actions;

use App\Http\Ussd\States\CommentState;
use Sparors\Ussd\Action;
use App\Models\Learners;

class FeedBackAction extends Action
{
    public function run(): string
    {
        $programId = $this->record->get('program_id');
        $learner = Learners::where('phone_number', $this->$phoneNumber)->first();
        $feedback = $this->record->get('feedback');

        // Save feedback to the database
        $learner->feedbacks()->create([
            'program_id' => $programId,
            'feedback' => $feedback,
        ]);

        // Increment programs completed
        $learner->increment('programs_completed');

        return CommentState::class;
    }
}
