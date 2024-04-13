<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'userMessage' => $request->message
        ];

        Mail::send('emails.contact', $details, function($message) use ($details) {
            $message->to('your-email@example.com')
                    ->subject('New Contact Us Message');
            $message->from($details['email']);
        });

        return back()->with('success', 'Thank you for contacting us!');
    }
}
