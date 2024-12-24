<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class RegistrationSuccessState extends State
{
    public function beforeRendering(): void
    {
        // Get the current year dynamically
        $currentYear = date('Y');

        // Set the menu text with the current year
        $this->menu->text("Success, Welcome!\n© Arifu $currentYear");
    }

    protected function afterRendering(string $argument): void
    {
        //
    }
}
