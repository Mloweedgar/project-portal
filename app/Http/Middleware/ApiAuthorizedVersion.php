<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthorizedVersion
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

        if($request->api_version != $request->client_api_version){

            return responder()->error("authorized_version_mismatch", "The API authorized version does not match with current client request.")->respond();

        }

        return $next;

    }

}
