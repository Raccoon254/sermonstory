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
        $admins = User::whereIn('email', ['tomsteve187@gmail.com', 'info@sermonstories.org', 'joe@sermonstories.org'])->get();

        try {
            $contact = Contact::create($request->all());

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ContactFormSubmitted($contact));
            }

            return back()->with('success', 'Your message has been sent successfully.');
        } catch (Exception $e) {
            $contact= new Contact();
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message.' Error Saving '.$e->getMessage();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ContactFormSubmitted($contact));
            }

            return back()->with('warning', 'Your message has been sent successfully. We will get back to you soon.');
        }
    }
}
