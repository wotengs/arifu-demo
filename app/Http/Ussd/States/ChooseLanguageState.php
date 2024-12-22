<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class ChooseLanguageState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('Choose your preferred language:')
            ->line('1. Swahili')
            ->line('2. English');
    }

    protected function afterRendering(string $argument): void
    {
       

        if (in_array("input", ['1', '2'])) {
            $this->record->set('language', "input");
            return LessonsState::class;
        }

        // Invalid input, re-render the same state
        return ChooseLanguageState::class;
    }
}
