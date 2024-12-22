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
            "2" => "Skip If you don't have an email address"
        ]);
    }

    protected function afterRendering(string $argument): void
    {
          // Access the user input using the request object
          $input = $this->record->get('text'); 
          

        if ($input == "1") {
            
            return ProcessRegistrationNameAction::class;
        } elseif ($input == "2") {
            // Return Program List
             return ProgramSelectionState::class;
    }
}
