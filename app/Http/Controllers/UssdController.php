<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learners;
use App\Models\Program;
use App\Models\Lessons;
use Illuminate\Support\Facades\Validator;

class UssdController extends Controller
{
    protected $response = "";
    protected $level = 0;

    public function index(Request $request)
    {
        $phoneNumber = $request->get('phoneNumber');
        $text = $request->get('text');

        $exploded_ussd_string = explode("*", $text);
        $this->level = count($exploded_ussd_string);

        $learner = Learners::where('phone_number', $phoneNumber)->first();

        // Early return for unregistered users
        if (!$learner) {
            $this->handle_registration($exploded_ussd_string, $phoneNumber);
            return;
        }

        // Handle registered users
        $this->handle_program_selection($exploded_ussd_string, $learner);
    }

    private function handle_registration($exploded_ussd_string, $phoneNumber)
    {
        // Switch case for level 1 actions
        switch ($this->level) {
            case 1:
                $this->display_registration_or_about($exploded_ussd_string);
                break;
            case 2:
                $this->process_registration_name($exploded_ussd_string);
                break;
            case 3:
                $this->complete_registration($exploded_ussd_string, $phoneNumber);
                break;
        }
    }

    private function display_registration_or_about($exploded_ussd_string)
    {
        if ($exploded_ussd_string[0] == "1") {
            $this->response = "Please enter your full name:";
            $this->ussd_proceed($this->response);
        } elseif ($exploded_ussd_string[0] == "2") {
            $this->response = "Arifu is an education technology company...";
            $this->ussd_stop($this->response);
        }
    }

    private function process_registration_name($exploded_ussd_string)
    {
        $name = $exploded_ussd_string[1];

        if (!ctype_alpha(str_replace(' ', '', $name))) {
            $this->response = "Invalid name. Please enter a valid name (letters only):";
            $this->ussd_proceed($this->response);
            return;
        }

        $this->response = "Enter your email address or type '1' if you don't have one:";
        $this->ussd_proceed($this->response);
    }

    private function complete_registration($exploded_ussd_string, $phoneNumber)
    {
        $name = $exploded_ussd_string[1];
        $email = strtolower($exploded_ussd_string[2]) == '1' ? null : $exploded_ussd_string[2];

        if ($email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email|unique:learners,email']);
            if ($validator->fails()) {
                $this->response = "Invalid email. Please enter a valid email or '1' to skip.";
                $this->ussd_proceed($this->response);
                return;
            }
        }

        Learners::create(['name' => $name, 'email' => $email, 'phone_number' => $phoneNumber]);
        $this->response = "You have successfully registered.";
        $this->ussd_proceed($this->response);
    }

    private function handle_program_selection($exploded_ussd_string, $learner)
    {
        // Use switch case to handle different levels in program selection
        switch ($this->level) {
            case 1:
                $this->list_programs(1);
                break;
            case 2:
                $this->select_program($exploded_ussd_string[1]);
                break;
            case 3:
                $this->handle_lessons($exploded_ussd_string, $learner);
                break;
        }
    }

    private function select_program($programId)
    {
        $program = Program::find($programId);
        if ($program) {
            $this->choose_language($program);
        } else {
            $this->response = "Invalid program selection. Please try again.";
            $this->ussd_proceed($this->response);
        }
    }

    private function list_programs($page)
    {
        $programs = Program::paginate(10, ['*'], 'page', $page);
        $this->response = "Choose a program:\n";

        foreach ($programs as $index => $program) {
            $this->response .= ($index + 1) . ". " . $program->name . "\n";
        }

        if ($programs->hasMorePages()) {
            $this->response .= "98. More\n";
        }

        if ($page > 1) {
            $this->response .= "0. Back\n";
        }

        $this->response .= "00. Program Menu\n";
        $this->ussd_proceed($this->response);
    }

    private function choose_language($program)
    {
        $this->response = "Choose a language:\n1. Swahili\n2. English";
        $this->ussd_proceed($this->response);
    }

    private function handle_lessons($exploded_ussd_string, $learner)
    {
        $programId = $exploded_ussd_string[1];
        $languageChoice = $exploded_ussd_string[2];
        $lessonIndex = isset($exploded_ussd_string[3]) ? (int)$exploded_ussd_string[3] : 1;

        $lessons = Lessons::where('program_id', $programId)->get();

        if ($lessons->isEmpty()) {
            $this->response = "No lessons available for this program.";
            $this->ussd_stop($this->response);
            return;
        }

        if ($lessonIndex > count($lessons)) {
            $this->response = "What else did you want to learn about in this training?";
            $this->collect_feedback($programId, $learner);
        } else {
            $this->display_lesson($lessons, $lessonIndex, $languageChoice);
        }
    }

    private function display_lesson($lessons, $lessonIndex, $languageChoice)
    {
        $lesson = $lessons[$lessonIndex - 1];
        $lessonText = $languageChoice == 1 ? $lesson->swahili : $lesson->english;
        $this->response = "($lessonIndex/" . count($lessons) . ") $lessonText\n1. Next\n0. Back\n00. Program Menu";
        $this->ussd_proceed($this->response);
    }

    private function collect_feedback($programId, $learner)
    {
        $this->response = "How satisfied are you with this program?\n1. Very satisfied\n2. A little satisfied\n3. Not so satisfied\n4. Not at all satisfied";
        $this->ussd_proceed($this->response);
        
        $learner->increment('programs_completed');
    }

    private function ussd_proceed($continue)
    {
        echo "CON $continue";
    }

    private function ussd_stop($end_text)
    {
        echo "END $end_text";
    }
}
