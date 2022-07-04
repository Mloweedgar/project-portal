<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode(";", $roles);

        $flag = false;
        foreach ($roles as $key => $value) {
            if($request->user()->hasRole($value)){
                $flag = true;
            }
        }

        if (! $flag) {
            return redirect('/dashboard');
        }

        return $next($request);
    }

}