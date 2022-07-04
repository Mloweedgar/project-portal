<?php

namespace App\Http\ViewComposers;

use App\Models\Location;
use App\Models\Sector;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BackendProjectComposer
{

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $canAccessProjectInformation = Auth::user()->canAccessProjectInformation();


        $view->with('canAccessProjectInformation', $canAccessProjectInformation);
    }
}
