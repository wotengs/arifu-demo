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
        
          
        // Check if the user input is "2" to skip email
        if ($argument === "2") {
            // Save email as null and navigate to ProgramSelectionState
            $this->record->set('email', null);
            $this->decision->equal('2', ProgramSelectionState::class);
        } else {

            // Extract the name part by splitting the input at the '*' character
         $email = explode('*', $argument)[2];  // Get the part after the '*' (i.e., the name)
            // Save the email input
            $this->record->set('email', $email);

            // Process registration and navigate to ProcessRegistrationNameAction
            $this->decision->custom(function () {
                return true; // Always execute
            }, ProcessRegistrationNameAction::class);
        }
}
}
