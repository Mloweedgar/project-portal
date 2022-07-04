<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;

class ApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Confirm if the API is online
        $api_online = (new Config)->where("name", "api")->pluck("value")->first();

        if($api_online){

            return $next($request);

        } else {

            return responder()->error("api_offline", "The API is actually offline, please, try again later.")->respond();

        }

    }

}
