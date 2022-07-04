<?php

namespace App\Providers;

use App\Models\Media;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer(['layouts/back', 'auth/login'], function($view) {
            $logo = Media::where('name','logo')->get()->first();
            $logo=$logo->name.'.'.$logo->extension;

            $view->with('logo', $logo);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
