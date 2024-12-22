<?php

namespace App\Http\Ussd\Actions;

use Sparors\Ussd\Action;
use App\Models\Learners;
use Illuminate\Support\Facades\Validator;

class ProcessRegistrationNameAction extends Action
{
    public function run(): string
    {
        $email = $this->input;  // The user's input (email)
        
        // Validate the email address
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            // If the email is invalid, prompt the user to re-enter the email
            return "The email you entered is invalid. Please enter a valid email address.";
        }

        // If the email is valid, create the user in the database
        $learner = Learners::where('phone_number', $this->session->phoneNumber)->first();

        if (!$learner) {
            // Register the user with the email
            Learners::create([
                'name' => $this->session->name,  // Assuming the name is stored in session
                'phone_number' => $this->session->phoneNumber,
                'email' => $email,  // Store the validated email
            ]);

            return "You have successfully registered. Welcome!";
        }

        return "You are already registered.";
    }
}

