<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $client;

    public function __construct($user, $client)
    {
        $this->user = $user;
        $this->client = $client;
    }

    public function build()
    {
        // Build verification URL
        $verificationUrl = url('/verify/' . urlencode($this->client->registration_id));

        /*
        |--------------------------------------------------------------------------
        | 100% SAFE QR CODE (NO IMAGICK)
        |--------------------------------------------------------------------------
        |
        | We use SVG format instead of PNG. SVG does NOT require Imagick, GD,
        | or any image library. It is supported in almost every modern email 
        | client when embedded as Base64.
        |
        */

        $qrSvg = \QrCode::format('svg')
                        ->size(200)
                        ->generate($verificationUrl);

        $qrCodeSrc = "data:image/svg+xml;base64," . base64_encode($qrSvg);

        return $this->subject('Welcome to ImperialVilla Portal')
                    ->view('emails.welcome-client')   // HTML email (not Markdown)
                    ->with([
                        'user' => $this->user,
                        'client' => $this->client,
                        'qrCodeSrc' => $qrCodeSrc
                    ]);
    }
}
