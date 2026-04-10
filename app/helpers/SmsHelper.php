<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SmsHelper
{
    public static function send($to, $message)
    {
        $apiKey = env('TERMII_API_KEY');
        $senderId = env('TERMII_SENDER_ID', 'ImperialVilla');

        $response = Http::post('https://api.ng.termii.com/api/sms/send', [
            'to' => $to,
            'from' => $senderId,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
            'api_key' => $apiKey,
        ]);

        return $response->json();
    }
}
