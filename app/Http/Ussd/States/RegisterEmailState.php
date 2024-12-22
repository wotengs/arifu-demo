<?php

namespace App\Http\Ussd\States;

use App\Http\Ussd\Actions\ProcessRegistrationNameAction;
use Sparors\Ussd\Menu;
use Sparors\Ussd\Action;
use Sparors\Ussd\State;

class RegisterEmailState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu = new Menu([
            "1" => "Please enter your email address:",
            "2" => "Put 2 to Skip If you don't have an email address"
        ]);
    }
 
    protected $email = $this->record->get('input');

    protected function afterRendering(string $argument): void
    {
        
          
        if (!is_numeric($email)) {
            
            return ProcessRegistrationNameAction::class;
        } elseif ($email == "2") {
            // Return Program List
             return ProgramSelectionState::class;
    }
}
}
