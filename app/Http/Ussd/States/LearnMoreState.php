<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class LearnMoreState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu
        ->text('Arifu is a learning platform that provides free access to courses on various farming related topics. Visit https://www.arifu.com/ to learn more.');
    }

    protected function afterRendering(string $argument): void
    {
        //
    }
}
