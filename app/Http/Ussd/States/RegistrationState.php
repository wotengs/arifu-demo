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
            ->line('2. Learn more about Arifu');
    }

    /**
     * Handle user input after rendering.
     */
    protected function afterRendering(string $argument): void
    {
        $this->decision
            ->equal('1', RegisterNameState::class) // Navigate to RegisterNameState for option 1
            ->equal('2', 
                // Show information and stay in the current state
                $this->menu
                ->text(
                    "Arifu is a learning platform that provides free courses to learners. Visit our website at www.arifu.com"
                )
            )
            ->any(
                // Handle invalid input by reloading the current menu
                $this->menu
                ->text("Invalid choice. Please try again.")
                ->lineBreak()
                    ->line('1. Register')
                    ->line('2. Learn more about Arifu')
                            );
    }
}
