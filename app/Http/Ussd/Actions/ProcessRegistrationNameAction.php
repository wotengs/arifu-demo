<?php


namespace App\Http\Ussd\Actions;

use Sparors\Ussd\Action;
use App\Models\Learners;
use Illuminate\Support\Facades\Validator;
use App\Http\Ussd\States\RegisterEmailState;
use App\Http\Ussd\States\RegistrationSuccessState;

class ProcessRegistrationNameAction extends Action
{
    public function run(): string
    {
        // Retrieve session data
        $name = $this->record->get('full_name'); //1*Martin Mwangi
        $email = $this->record->get('email');   //1*Martin Mwangi*2001mwangi@gmail.com
        $phoneNumber = $this->record->get('phoneNumber');

    
        // Check if learner is already registered
        $learner = Learners::where('phone_number', $phoneNumber)->first();

        if (!$learner) {
            // Register the learner
            Learners::create([
                'name' => $name,
                'phone_number' => $phoneNumber,
                'email' => $email, // Can be null
            ]);

            // Redirect to success state
            return RegistrationSuccessState::class;
        }

        // If learner exists, handle appropriately (e.g., show error or re-register).
    }
}



  // // Validate email if provided
        // if ($email !== null) {
        //     $validator = Validator::make(
        //         ['email' => $email],
        //         ['email' => ['required', 'email', 'unique:learners,email']]
        //     );


        //     if ($validator->fails()) {
        //         // Save error message to session and return to email input state
        //         $this->record->set('error_message', 'The email you entered is invalid. Please enter a valid email address.');
        //         return RegisterEmailState::class;
        //     }
        // }
