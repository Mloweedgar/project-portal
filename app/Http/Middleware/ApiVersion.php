<?php

namespace App\Http\Middleware;

use Closure;

class ApiVersion
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

        if(!in_array($request->version, $request->version_list)){

            return responder()->error("api_version_notfound", "The API version provided does not exist.")->respond();

        }

        return $next;

    }

}
