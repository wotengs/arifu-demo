<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class RegistrationSuccessState extends State
{
   
        public function beforeRendering(): void
{
    $this->menu->text('Welcome!');
}
    

    protected function afterRendering(string $argument): void
    {
        //
    }
}
