<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\Throttle\Facades\Throttle;

class ApiThrottle
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

        $throttler = Throttle::get($request, env('API_THROTTLE'), 1);

        // If limit not reached
        if($throttler->check()){

            // Perform a hit
            $throttler->hit();

            // and continue with the request
            return $next($request);

        } else {

            // Prompt error code and message to the user
            return responder()->error("api_throttle_limit", "Api throttle limit reached, please, try again later.")->respond();

        }

    }

}
