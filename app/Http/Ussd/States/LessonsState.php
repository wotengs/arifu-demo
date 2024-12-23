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

        // Ensure the lesson index is within the available range
        if ($lessonIndex > count($lessons)) {
            // If the user is past the available lessons, transition to another state like FeedbackState
            $this->decision->any(FeedbackState::class);
            return;
        }

        // Display the current lesson based on the chosen language
        $lesson = $lessons[$lessonIndex - 1];
        $lessonText = $languageChoice == '1' ? $lesson->english : $lesson->swahili;

        $this->menu->text("($lessonIndex/" . count($lessons) . ") $lessonText")
            ->line('1. Next Lesson')
            ->line('0. Back to Program Menu');
    }

    protected function afterRendering(string $argument): void
    {
        $lessonIndex = $this->record->get('lesson_index', 1); // Default to the first lesson
        $programId = $this->record->get('program_id'); // Get the selected program ID
        $lessons = Lessons::where('program_id', $programId)->get(); // Get lessons for the selected program

        // Ensure the lesson index is within the available range
        if ($lessonIndex > count($lessons)) {
            // If the lesson index exceeds the available lessons, move to another state like FeedbackState
            $this->decision->any(FeedbackState::class);
            return;
        }

        if ($argument == '1') {
            // User wants to go to the next lesson
            $lessonIndex = $this->record->get('lesson_index', 1);
            $this->record->set('lesson_index', $lessonIndex + 1);
            $this->decision->any(LessonsState::class); // Keep in the current state, show next lesson
        } elseif ($argument == '0') {
            // User wants to go back to ProgramSelectionState
            $this->decision->any(ProgramSelectionState::class);
        }
    }
}
