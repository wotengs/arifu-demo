<?php

namespace App\Http\Ussd\Actions;

use App\Http\Ussd\States\RegistrationSuccessState;
use App\Models\Learners;
use Illuminate\Support\Facades\Log;
use Sparors\Ussd\Action;

class DeleteAccountAction extends Action
{
    public function run(): string
    {
        // Get the phone number of the current user from the record
        $phoneNumber = $this->record->get('phoneNumber');

        if ($phoneNumber) {
            // Find the learner in the database by their phone number
            $learner = Learners::where('phone_number', $phoneNumber)->first();

            if ($learner) {
                // Delete the learner record
                $learner->delete();

                // Optional: Add logging for debugging
                Log::info("Learner with phone number $phoneNumber successfully deleted.");
            } else {
                Log::warning("Learner with phone number $phoneNumber not found.");
            }
        } else {
            Log::error("Phone number not found in the USSD session record.");
        }

        // Redirect to the RegistrationSuccessState after deletion
        return RegistrationSuccessState::class;
    }
}
