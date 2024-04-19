<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'Contactmessage' => 'required|string',
        ]);

        // Send email
        Mail::to('memohubmemohub@gmail.com')->send(new ContactFormMail(
            $request->name,
            $request->email,
            $request->Contactmessage,
        ));

        // Redirect back with success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
