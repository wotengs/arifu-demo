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
        $languageChoice = $this->input;  // Store language choice (1 or 2)

        if (in_array($languageChoice, ['1', '2'])) {
            $this->record->set('language', $languageChoice);
            return LessonsState::class;
        }

        // Invalid input, re-render the same state
        return ChooseLanguageState::class;
    }
}
