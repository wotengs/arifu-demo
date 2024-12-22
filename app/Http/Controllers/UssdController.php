<?php

namespace App\Http\Controllers;

use App\Http\Ussd\States\ProgramSelectionState;
use App\Http\Ussd\States\RegistrationState;
use Illuminate\Http\Request;
use App\Models\Learners;
use Sparors\Ussd\Facades\Ussd;

class UssdController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve learner by phone number (assuming session contains phone number)
        $phoneNumber = $request->get('phone_number');
        $learner = Learners::where('phone_number', $phoneNumber)->first();

        // Initialize the USSD machine
        $ussd = Ussd::machine()
            ->setFromRequest([
                'phone_number' => 'phone_number', // Request parameter for phone number
                'input' => 'msg',  // The input message from the user
                'network' => 'network',  // Optional: network information
                'session_id' => 'UserSessionID',  // Optional: user session ID
            ]);

        // Check if learner is registered or not and set initial state accordingly
        if (!$learner) {
            // If the learner is not found (not registered), send them to the Registration state
            $ussd->setInitialState(RegistrationState::class);
        } else {
            // If the learner is registered, send them to the ProgramSelectionState
            $ussd->setInitialState(ProgramSelectionState::class);
        }

        // Run the USSD machine and return the response
        return response()->json($ussd->run());
    }
}
