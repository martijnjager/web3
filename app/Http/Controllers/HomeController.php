<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->middleware('auth');

        return view('welcome');
    }
}
