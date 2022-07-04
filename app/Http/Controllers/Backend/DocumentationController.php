<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->user = $user;

    }


    /**
     * Shows the dashboard screen.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        return view('back.documentation');

    }
}
