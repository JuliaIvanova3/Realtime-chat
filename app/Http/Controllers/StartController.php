<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartController extends Controller
{
    public function index()
    {
        return view('start');
    }

    public function sendMessage(Request $request)
    {
        return event(new \App\Events\NewMessage($request->input('message')));
    }
}
