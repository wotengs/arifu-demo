<?php

namespace App\Http\Ussd\States;

use Filament\Actions\DeleteAction;
use Sparors\Ussd\State;

class DeleteAccountState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu
            ->text('Sad to see you Leave (`._.`)')
            ->lineBreak()
            ->line('1. Confirm Account Deletion')
            ->line('2. Back to Main Menu');
    
    }

    protected function afterRendering(string $argument): void
    {
        $parts = explode('*', $argument);
        $navigation = end($parts); // Get the user's selection
             // Store the user's input (full name) in the record


    
            // After all lessons, handle feedback or return to program menu
            if ($navigation === '1') {
                $this->decision->any(DeleteAction::class);
            } elseif ($navigation === '2') {
                $this->decision->any(RegistrationState::class);
            } else {
                $this->decision->any(DeleteAccountState::class); // Re-render for invalid input
            }
            
        
      
    }
}

