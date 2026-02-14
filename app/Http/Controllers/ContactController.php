<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
     public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone'   => 'required|string|digits:11|regex:/^01[3-9][0-9]{8}$/',
            'message' => 'required|string',
        ]);

        Mail::to('utpolodekary51@gmail.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Message sent successfully!');
    }
}
