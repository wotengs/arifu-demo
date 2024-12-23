<?php

namespace App\Http\Ussd\States;

use App\Models\Lessons;
use Error;
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
           // Extract the name part by splitting the input at the '*' character
           //$name = explode('*', $argument)[1];  // Get the part after the '*' (i.e., the name)
         // Pagination controls
         if ($argument == "1") {
            $this->record->set('language', 1);
        }elseif ($argument == "2") {
            $this->record->set('language', 2);
        }
       
        $this->decision->in([1, 2], LessonsState::class)
        ->any(Error::class); // Navigate to a state that handles invalid inputs
    }
}