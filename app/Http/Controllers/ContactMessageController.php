<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactMessageController extends Controller
{
    /**
     * Store the message first so it is never lost, then e-mail it. A mail
     * failure is reported but does not bother the visitor: the message is
     * still waiting in the CMS inbox.
     */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $message = ContactMessage::create([
            ...$request->safe()->only(['name', 'email', 'phone', 'service_id', 'message']),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        $recipient = Setting::get('contact.notification_email') ?: config('mail.from.address');

        if (filled($recipient)) {
            try {
                Mail::to($recipient)->send(new ContactMessageReceived($message));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return back()->with(
            'success',
            Page::findByKey('contact')?->section('form.success') ?: __('Message sent! I will get back to you soon.'),
        );
    }
}
