<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactSubmitted;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Handle contact form submission.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());

        // Send email to admin
        $adminEmail = env('ADMIN_EMAIL', config('mail.from.address'));
        Mail::to($adminEmail)->send(new ContactSubmitted($contact));

        return redirect()->route('contact.index')
            ->with('status', 'Thank you for contacting us! We will get back to you soon.');
    }
}

