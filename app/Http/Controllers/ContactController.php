<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate form fields
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Example: you could save to database, send email, etc.
        // For now, just show a success message.
        return back()->with('success', 'Thank you for contacting us! We’ll get back to you soon.');
    }
}
