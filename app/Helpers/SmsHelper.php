<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class SmsHelper
{
    /**
     * Send SMS message (Mock SMS sender)
     * Replace API logic here for real SMS gateways like:
     * Termii, Infobip, Twilio, SmartSMS, etc.
     */
    public static function send($phone, $message)
    {
        if (!$phone) {
            Log::warning("SMS not sent — no phone number.");
            return false;
        }

        // Fake sending SMS (for development)
        Log::info("SMS SENT → {$phone} | {$message}");

        // If integrating real API, example:
        /*
        $response = Http::withHeaders([
            'api-key' => config('services.termii.key'),
        ])->post('https://api.ng.termii.com/api/sms/send', [
            'to' => $phone,
            'from' => 'ImperialVilla',
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
        ]);
        
        Log::info('SMS API Response: ' . $response->body());
        */

        return true;
    }
}
