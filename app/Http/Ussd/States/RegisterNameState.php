<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;
use Sparors\Ussd\Menu;

class RegisterNameState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu = new Menu([
            "1" => "Please enter your full name:",
        ]);
    }

    protected function afterRendering(string $argument): void
    {
        $input = $this->record->get('text');
        // Here, you'd validate the name and move to the next state
        return RegisterEmailState::class;
    }
}
