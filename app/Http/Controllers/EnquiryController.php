<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'messageContent' => $request->message
        ];

        try {
            Mail::send([], [], function (Message $message) use ($data) {
                $htmlBody = "
                    <div style='font-family: Arial, sans-serif; background: #f8fafc; padding: 20px;'>
                        <div style='background: white; padding: 20px; border-radius: 10px; border-top: 5px solid #0b2c4d;'>
                            <h2 style='color: #0b2c4d; margin-top: 0;'>New Website Enquiry</h2>
                            <p><strong>Sender Name:</strong> {$data['name']}</p>
                            <p><strong>Reply-To Email:</strong> {$data['email']}</p>
                            <hr style='border: none; border-bottom: 1px solid #eee; margin: 20px 0;'>
                            <p style='color: #555; white-space: pre-wrap;'>{$data['messageContent']}</p>
                        </div>
                        <p style='color: #999; font-size: 12px; text-align: center; margin-top: 20px;'>Sent from ImperialVilla Website Form</p>
                    </div>
                ";

                $message->to('support@imperialvillapropertydevelopment.com')
                        ->replyTo($data['email'], $data['name'])
                        ->subject('New Enquiry from: ' . $data['name'])
                        ->html($htmlBody);
            });

            return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you shortly!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, there was an issue sending your message. Please try again or contact us via WhatsApp.');
        }
    }
}
