<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class ChooseLanguageState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('Choose your preferred language:')
            ->lineBreak()
            ->line('1. English')
            ->line('2. Swahili');
    }

    protected function afterRendering(string $argument): void
    {
        // Extract the last part of the input (this should be the language choice)
        $parts = explode('*', $argument);
        $languageChoice = end($parts);  // Get the last element of the array (language choice)

        // Handle pagination and language choice
        if ($languageChoice === '1') {
            // Set language as English
            $this->record->set('language', 1);
            $this->decision->any(LessonsState::class);
        } elseif ($languageChoice === '2') {
            // Set language as Swahili
            $this->record->set('language', 2);
            $this->decision->any(LessonsState::class);
        } else {
            // If the input is not recognized, ask the user again
            $this->decision->any(ChooseLanguageState::class);
        }
    }
}
