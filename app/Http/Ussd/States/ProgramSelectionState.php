<?php

namespace App\Http\Ussd\States;

use App\Models\Program;
use Sparors\Ussd\State;
use Sparors\Ussd\Menu;

class ProgramSelectionState extends State
{
    // The current page number for pagination
    private $currentPage = 1;

    protected function beforeRendering(): void
    {
        $this->listPrograms($this->currentPage);
    }

    protected function afterRendering(string $argument): void
    {
        
        if (is_numeric("input")) {
            $input = (int) "input";

            if ($input === 9) {
                // Next page
                return  $this->currentPage++;
            } elseif ($input === 0) {
                // Back to the previous state or menu
                return ProgramSelectionState::class;  // Replace with the actual state for back
            } elseif ($input > 0) {
                // Handle program selection
                $program = Program::find($input);

                if ($program) {
                    // If a valid program is selected, go to LessonsState
                    return ChooseLanguageState::class;  // Make sure to pass program if needed
                }
            }
        }

        // If the input is invalid, re-render the list of programs
        return ProgramSelectionState::class;
    }

    private function listPrograms(int $page): void
    {
        $programs = Program::paginate(3, ['*'], 'page', $page);  // 3 programs per page

        $menu =  $this->menu->text('Select a Program')
        ->lineBreak(1);

       
                       
        // Display the programs
        foreach ($programs as $index => $program) {
            $menu->line(($index + 1) . ". " . $program->name);
        }

        // Pagination controls
        if ($programs->hasMorePages()) {
            $menu->line("9. Next Page");
        }

        $menu->line('0. Back to Main Menu');  // Option for going back to the main menu

        $this->menu = $menu;
    }
}

