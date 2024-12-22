<?php

namespace App\Http\Controllers;

use App\Http\Ussd\States\ProgramSelectionState;
use App\Http\Ussd\States\RegistrationState;
use Illuminate\Http\Request;
use App\Models\Learners;
use Sparors\Ussd\Facades\Ussd;
use Illuminate\Support\Facades\Log;

class UssdController extends Controller
{
    public function index(Request $request)
    {
        // Log the incoming USSD request for debugging
        Log::info('USSD request method: ' . $request->method());
        Log::info('USSD request data: ', $request->all());

        // Validate the incoming request
        $validated = $request->validate([
            'phoneNumber' => 'required|string',
            'sessionId' => 'required|string',
            'text' => 'nullable|string',
            'serviceCode' => 'required|string',
            'networkCode' => 'required|string',
        ]);

        // Extract the phone number from the request
        $phoneNumber = $validated['phoneNumber'];
        $sessionId = $validated['sessionId'];

        // Initialize the USSD machine
        $ussd = Ussd::machine()
            ->setFromRequest([
                'phone_number' => 'phoneNumber', // Maps the input field 'phoneNumber'
                'input' => 'text',               // Maps the input field 'text'
                'session_id' => 'sessionId',     // Maps the input field 'sessionId'
                'network' => 'networkCode',      // Maps the input field 'networkCode'
            ]);

        // Retrieve the learner from the database
        $learner = Learners::where('phone_number', $phoneNumber)->first();

        // Determine the initial state based on whether the learner is registered
        if (!$learner) {
            Log::info("Learner not found: Starting in RegistrationState.");
            $ussd->setInitialState(RegistrationState::class);
        } else {
            Log::info("Learner found: Starting in ProgramSelectionState.");
            $ussd->setInitialState(ProgramSelectionState::class);
        }

        // Run the USSD machine and capture the response
        try {
            $result = $ussd->run();

            // Extract the message and format it for Africa's Talking
            $message = $result['message'] ?? '';
            $action = $result['action'] ?? 'input';

            // Format the response as per Africa's Talking requirements
            $formattedResponse = ($action === 'input' ? "CON " : "END ") . $message;

            Log::info("Formatted USSD response: ", ['response' => $formattedResponse]);

            return response($formattedResponse)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            // Log any errors and respond with an error message
            Log::error('USSD processing error: ' . $e->getMessage(), $e->getTrace());

            return response("END Dear customer, the network is experiencing technical problems. Please try again later.")
                ->header('Content-Type', 'text/plain');
        }
    }
}
