<?php

namespace App\Http\Ussd\States;

use App\Http\Ussd\Actions\FeedBackAction;
use Sparors\Ussd\State;

class FeedbackState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('How satisfied are you with this training? Reply with a number:')
            ->lineBreak()
            ->line('1. Very satisfied')
            ->line('2. A little satisfied')
            ->line('3. Not so satisfied')
            ->line('4. Not at all satisfied');
    }

    protected function afterRendering(string $argument): void
    {
        $parts = explode('*', $argument);
        $input = end($parts); // Get the user's selection

        if (in_array($input, ['1', '2', '3', '4'])) {
            $this->record->set('feedback', $input); // Save feedback
            $this->decision->any(FeedBackAction::class); // Handle the feedback
        } else {
            // Invalid input, re-render feedback options
            $this->decision->any(FeedbackState::class);
        }
    }
}
