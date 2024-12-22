<?php

namespace App\Http\Ussd\States;

use App\Http\Ussd\Actions\FeedBackAction;
use Sparors\Ussd\State;

class FeedbackState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('How satisfied are you with this training? Reply with a number:')
            ->line('1. Very satisfied')
            ->line('2. A little satisfied')
            ->line('3. Not so satisfied')
            ->line('4. Not at all satisfied');
    }

    protected function afterRendering(string $argument): void
    {
        $feedback = $this->input;
        if (in_array($feedback, ['1', '2', '3', '4'])) {
            $this->record->set('feedback', $feedback);
            return FeedBackAction::class;
        }

        // Invalid input, re-render feedback options
        return FeedbackState::class;
    }
}
