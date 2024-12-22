<?php

namespace App\Http\Ussd\States;

use App\Http\Ussd\Actions\ProgramComments;
use Sparors\Ussd\State;

class CommentState extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('Please leave a comment for this program:');
    }

    protected function afterRendering(string $argument): void
    {
      

        if (!empty("input")) {
            $this->record->set('comment', "input");
            return ProgramComments::class;
        }

        // Re-render the comment input if no comment is provided
        return CommentState::class;
    }
}
