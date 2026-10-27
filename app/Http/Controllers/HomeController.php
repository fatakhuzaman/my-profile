<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function home()
    {
        return view('home.home', [
            "title" => "Fatakhuzaman ~ Home"
        ]);
    }

    public function about()
    {
        return view('home.about', [
            "title" => "About ~ Fatakhuzaman"
        ]);
    }

    public function services()
    {
        return view('home.services', [
            "title" => "Services ~ Fatakhuzaman"
        ]);
    }

    public function works()
    {
        return view('home.works', [
            "title" => "Works ~ Fatakhuzaman"
        ]);
    }

    public function contact()
    {
        return view('home.contact', [
            "title" => "Contact ~ Fatakhuzaman"
        ]);
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        $details = [
            'title' => 'New Message from Client',
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->message,
        ];

        Mail::send('emails.contact', $details, function ($message) use ($request) {
            $message->to('fatakhuzaman@gmail.com')
                ->subject('Contact Form Submission');
        });

        return back()->with('success', 'Message sent!');
    }

    public function blog()
    {
        return view('home.blog', [
            "title" => "Blog ~ Fatakhuzaman"
        ]);
    }
}
