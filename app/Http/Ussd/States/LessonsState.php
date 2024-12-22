<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;
use App\Models\Lessons;

class LessonsState extends State
{
    protected function beforeRendering(): void
    {
        $programId = $this->record->get('program_id');
        $languageChoice = $this->record->get('language');
        $lessonIndex = $this->record->get('lesson_index', 1);

        $lessons = Lessons::where('program_id', $programId)->get();

        if ($lessons->isEmpty()) {
            $this->menu->text('No lessons available for this program.');
            return;
        }

        if ($lessonIndex > count($lessons)) {
            // Lessons complete, move to FeedbackState
            return FeedbackState::class;
        }

        $lesson = $lessons[$lessonIndex - 1];
        $lessonText = $languageChoice == '1' ? $lesson->swahili : $lesson->english;

        $this->menu->text("($lessonIndex/" . count($lessons) . ") $lessonText")
            ->line('1. Next Lesson')
            ->line('0. Back to Main Menu');
    }

    protected function afterRendering(string $argument): void
    {
        $input = $this->input;

        if ($input == '1') {
            // Move to the next lesson
            $lessonIndex = $this->record->get('lesson_index', 1);
            $this->record->set('lesson_index', $lessonIndex + 1);
            return LessonsState::class;
        } elseif ($input == '0') {
            // Back to ProgramSelectionState
            return ProgramSelectionState::class;
        }

        // Invalid input, re-render the current lesson
        return LessonsState::class;
    }
}
