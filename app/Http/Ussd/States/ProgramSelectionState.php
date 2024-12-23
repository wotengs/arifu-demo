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
        $this->record->set('current_page', 1);
        $this->record->set('program_id', $argument);

        
        if ($argument === '98') {
            // Increment current page and store it in the session
            $currentPage = $this->record->get('current_page') + 1;
            $this->record->set('current_page', $currentPage);

            // Stay in the same state and re-render
            $this->decision->any(ProgramSelectionState::class);
        } elseif ($argument === '0') {
            // Reset current page when going back to main menu
            $this->record->set('current_page', 1);
            $this->decision->any(ProgramSelectionState::class);  // Assuming MainMenuState is the starting point
        } else {
            // For choosing a program or other selections, continue with the next decision
            $this->decision->between(1, Program::count(), ChooseLanguageState::class)
                ->any(ProgramSelectionState::class);
        }
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
