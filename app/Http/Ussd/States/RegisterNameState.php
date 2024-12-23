<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class RegisterNameState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu
            ->line('Please enter your full name:');
    }

    protected function afterRendering(string $argument): void
    {

          // Extract the name part by splitting the input at the '*' character
         $name = explode('*', $argument)[1];  // Get the part after the '*' (i.e., the name)
        // Store the user's input (full name) in the record
        $this->record->set('full_name', $name);

        // Navigate to RegisterEmailState
        $this->decision
            ->any(RegisterEmailState::class);
    }
}
