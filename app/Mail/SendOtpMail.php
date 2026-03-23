<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $expiresAt;

    public function __construct($otp, $expiresAt = null)
    {
        $this->otp = $otp;
        $this->expiresAt = $expiresAt;
    }
public function build()
{
    return $this->subject('ImperialVilla OTP')
            ->view('emails.otp_html')
            ->with([
                'otp' => $this->otp,
                'expiresAt' => $this->expiresAt,
            ]);

}

}
