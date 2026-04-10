<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        return view('pages.home');
    }

    public function about() {
        return view('pages.about');
    }

    public function services() {
        return view('pages.services');
    }

    public function contact() {
        return view('pages.contact');
    }

    public function login() {
        return view('pages.login');
    }

    public function thankyou() {
        return view('pages.thankyou');
    }
    public function estates() {
        return view('pages.estates');
        
}
public function coming() {
        return view('pages.coming-soon');
        
}


}
