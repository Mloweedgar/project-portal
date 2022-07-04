<?php

namespace App\Http\ViewComposers;

use App\Models\NavMenuLink;
use App\Models\Location;
use App\Models\Sector;
use App\Models\Stage;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class FrontEndProjectComposer
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
        $regions = Location::all();
        $sectors = Sector::all();
        $stages = Stage::all();
        $aboutppp = DB::table('configs')->select('name', 'value')->where('name', 'aboutppp')->first();
        $homepage = DB::table('configs')->select('name', 'value')->where('name', 'homepage')->first();
        $mail = DB::table('configs')->select('name', 'value')->where('name', 'mail')->first();
        $address = DB::table('configs')->select('name', 'value')->where('name', 'address')->first();
        $phone = DB::table('configs')->select('name', 'value')->where('name', 'phone')->first();
        $linkedin = DB::table('configs')->select('name', 'value')->where('name', 'linkedin')->first();
        $facebook = DB::table('configs')->select('name', 'value')->where('name', 'facebook')->first();
        $twitter = DB::table('configs')->select('name', 'value')->where('name', 'twitter')->first();
        $instagram = DB::table('configs')->select('name', 'value')->where('name', 'instagram')->first();
        $aboutppp_title = DB::table('configs')->select('name', 'value')->where('name', 'aboutppp_title')->first();
        $address_link = DB::table('configs')->select('name', 'value')->where('name', 'address_link')->first();
        $nav_extra = NavMenuLink::all();
        $app_title = env('APP_TITLE');

        $view->with('regions', $regions);
        $view->with('sectors', $sectors);
        $view->with('stages', $stages);
        $view->with('aboutppp', $aboutppp);
        $view->with('mail', $mail);
        $view->with('homepage', $homepage);
        $view->with('address', $address);
        $view->with('phone', $phone);
        $view->with('linkedin', $linkedin);
        $view->with('facebook', $facebook);
        $view->with('twitter', $twitter);
        $view->with('instagram', $instagram);
        $view->with('aboutppp_title', $aboutppp_title);
        $view->with('address_link', $address_link);
        $view->with('nav_extra', $nav_extra);
        $view->with('app_title', $app_title);
    }
}
