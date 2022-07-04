<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Middleware define
         * It's used to define that all the methods in this controller the user must be authenticated
         */
        $this->middleware('auth');
    }

     /**
     * Returns the homepage-management view.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepageManagement()
    {
        return view('back.homepage-management');
    }
}
