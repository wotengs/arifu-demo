<?php

namespace App\Http\Ussd\States;

use App\Models\Program;
use Sparors\Ussd\State;

class ProgramSelectionState extends State
{
    protected function beforeRendering(): void
    {
        // Retrieve the current page from the session, defaulting to 1
        $currentPage = $this->record->get('current_page', 1); 

        $this->menu = $this->menu->text('Select a Program')
            ->lineBreak(1);

        $this->listPrograms($currentPage);
    }

    protected function afterRendering(string $argument): void
    {
         // Extract the last part of the input (this should be the language choice)
         $parts = explode('*', $argument);
         $input = end($parts);  // Get the last element of the array (language choice)

        $this->record->set('current_page', 1);
        $this->record->set('program_id', $input);

        
        if ($input === '98') {
            // Increment current page and store it in the session
            $currentPage = $this->record->get('current_page') + 1;
            $this->record->set('current_page', $currentPage);

            // Stay in the same state and re-render
            $this->decision->any(ProgramSelectionState::class);
        } elseif ($input === '0') {
            // Reset current page when going back to main menu
            $this->record->set('current_page', 1);
            $this->decision->any(ProgramSelectionState::class);  // Assuming MainMenuState is the starting point
        } elseif($input > 0 && $input <= Program::count()) {
            // For choosing a program or other selections, continue with the next decision
            $this->decision
                ->any(ChooseLanguageState::class);
        }
           // For choosing a program or other selections, continue with the next decision
           $this->decision
           ->any(ProgramSelectionState::class);
    }

    private function listPrograms(int $page): void
    {
        $programs = Program::paginate(10, ['*'], 'page', $page);
        $startingIndex = ($page - 1) * 10; // Calculate starting index based on the page

        foreach ($programs as $index => $program) {
            $this->menu->line(($startingIndex + $index + 1) . ". " . $program->name);
        }

        // Pagination controls
        if ($programs->hasMorePages()) {
            $this->menu->line("98. Next Page");
        }

        $this->menu->line('0. Back to Main Menu');
    }
}
