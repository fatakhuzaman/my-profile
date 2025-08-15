<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home.home');
    }

    public function about()
    {
        return view('home.about');
    }

    public function services()
    {
        return view('home.services');
    }

    public function works()
    {
        return view('home.works');
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function blog()
    {
        return view('home.blog');
    }
}
