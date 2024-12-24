<?php

namespace App\Http\Ussd\States;


use App\Http\Ussd\Actions\ProgramComments;
use Sparors\Ussd\State;

class CommentState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu
        ->text('What else did you want to learn about in this training? Reply with 1-3 sentences.');
    }

    protected function afterRendering(string $argument): void
    {
         // Extract the last part of the input (this should be the language choice)
         $parts = explode('*', $argument);
         $input = end($parts);  // Get the last element of the array (language choice)
      
         $this->record->set('comment', $input); // Save the user's feedback

         $this->decision->any(ProgramComments::class); // Navigate to a state that handles invalid inputs
        
    }
}
