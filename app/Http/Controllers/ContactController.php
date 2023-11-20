<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        try {
            $contact = Contact::create($request->all());

            $admins = User::whereIn('email', ['tomsteve187@gmail.com', 'info@sermonstories.org', 'joe@sermonstories.org'])->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ContactFormSubmitted($contact));
            }

            return back()->with('success', 'Your message has been sent successfully.');
        } catch (Exception $e) {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ContactFormSubmitted($e->getMessage()));
            }

            return back()->with('error', 'There was an error processing your request.');
        }
    }
}
