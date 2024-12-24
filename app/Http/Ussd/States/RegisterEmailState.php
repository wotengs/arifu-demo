<?php

namespace App\Http\Ussd\States;

use App\Http\Ussd\Actions\ProcessRegistrationNameAction;
use Sparors\Ussd\State;

class RegisterEmailState extends State
{
    public function beforeRendering(): void
    {
        $errorMessage = $this->record->get('error_message', null);
    
        $this->menu->text(
            $errorMessage ?: 'Enter your email address. To skip, enter 2 if you don\'t have an email address.'
        );
    }
 
    protected function afterRendering(string $argument): void
    {
        
           // Extract the last part of the input (this should be the language choice)
        $parts = explode('*', $argument);
        $email = end($parts);  // Get the last element of the array (language choice)
        // Check if the user input is "2" to skip email
        if ($email === '2') {
            // Save email as null and navigate to ProgramSelectionState
            $this->record->set('email', null);
            $this->decision->any(ProcessRegistrationNameAction::class);
        } else {

            $this->record->set('email', $email);

            // Process registration and navigate to ProcessRegistrationNameAction
            $this->decision->custom(function () {
                return true; // Always execute
            }, ProcessRegistrationNameAction::class);
        }
}
}
