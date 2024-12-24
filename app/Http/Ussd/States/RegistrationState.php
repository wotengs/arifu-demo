<?php

namespace App\Http\Ussd\States;


use Sparors\Ussd\State;

class RegistrationState extends State
{
    /**
     * Prepare the menu before rendering.
     */
    protected function beforeRendering(): void
    {
        $this->menu
            ->text('Welcome to Arifu!')
            ->lineBreak()
            ->line('1. Register')
            ->line('2. Delete Account')
            ->line('3. Learn more about Arifu');
    }

    /**
     * Handle user input after rendering.
     */
    protected function afterRendering(string $argument): void
    {
        $this->decision
        ->equal('1', RegisterNameState::class) // Navigate to RegisterNameState for option 1
        ->equal('2', DeleteAccountState::class) // Navigate to a dedicated LearnMoreState
        ->equal('3', LearnMoreState::class) // Navigate to a dedicated LearnMoreState
        ->any(RegistrationState::class); // Navigate to a state that handles invalid inputs
    }
}
