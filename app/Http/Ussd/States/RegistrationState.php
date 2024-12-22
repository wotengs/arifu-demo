<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;
use Sparors\Ussd\Menu;


class RegistrationState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu = new Menu([
            "1" => "Register",
            "2" => "Learn more about Arifu"
        ]);
    }

    protected function afterRendering(string $argument): void
    {
         // Access the user input using the request object
         $input = $this->record->get('text');
         
         if ($input == "1") {
            return RegisterNameState::class;
        } elseif ($input == "2") {
            // Return information about Arifu
            return "Arifu is a learning platform that provides free courses to learners. Visit our website at www.arifu.com";
        }
    }
}
