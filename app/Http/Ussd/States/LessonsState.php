<?php

namespace App\Http\Ussd\States;

use App\Models\Lessons;
use Sparors\Ussd\State;

class LessonsState extends State
{
    protected function beforeRendering(): void
    {
        $programId = $this->record->get('program_id'); // Get the selected program ID
        $languageChoice = $this->record->get('language'); // Get the chosen language (1 or 2)
        $lessonIndex = $this->record->get('lesson_index', 1); // Default to the first lesson

        $lessons = Lessons::where('program_id', $programId)->get(); // Get lessons for the selected program

        if ($lessons->isEmpty()) {
            $this->menu->text('No lessons available for this program.');
            return;
        }

        if ($lessonIndex > count($lessons)) {
            // User has completed all lessons
            $this->menu->text('You have completed all lessons.')
                ->lineBreak()
                ->line('1. Provide Feedback')
                ->line('0. Back to Program Menu');
            return;
        }

        // Display the current lesson based on the chosen language
        $lesson = $lessons[$lessonIndex - 1];
        $lessonText = $languageChoice == '1' ? $lesson->english : $lesson->swahili;

        $this->menu->text("($lessonIndex/" . count($lessons) . ") $lessonText")
            ->lineBreak()
            ->line('1. Next Lesson')
            ->line('0. Back to Program Menu');
    }

    protected function afterRendering(string $argument): void
    {
        $parts = explode('*', $argument);
        $navigation = end($parts); // Get the user's selection
        $lessonIndex = $this->record->get('lesson_index', 1); // Current lesson index
        $programId = $this->record->get('program_id'); // Selected program ID
        $lessons = Lessons::where('program_id', $programId)->get(); // Get lessons for the selected program

        if ($lessonIndex > count($lessons)) {
            // After all lessons, handle feedback or return to program menu
            if ($navigation === '1') {
                $this->decision->any(FeedbackState::class);
            } elseif ($navigation === '0') {
                $this->record->set('lesson_index', 1); // Reset for next use
                $this->decision->any(ProgramSelectionState::class);
            } else {
                $this->decision->any(LessonsState::class); // Re-render for invalid input
            }
            return;
        }

        if ($navigation === '1') {
            $this->record->set('lesson_index', $lessonIndex + 1); // Move to next lesson
            $this->decision->any(LessonsState::class);
        } elseif ($navigation === '0') {
            $this->record->set('lesson_index', 1); // Reset lesson index
            $this->decision->any(ProgramSelectionState::class);
        } else {
            // Invalid input, re-render the current lesson
            $this->decision->any(LessonsState::class);
        }
    }
}
