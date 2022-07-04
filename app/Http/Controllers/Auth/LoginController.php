<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // custom attempts and minuts
    public $maxAttempts  = 3;
    public $decayMinutes = 10;

    /**
    * Login
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function login(Request $request)
    {
        $email = $request->get('email');

        if(User::where('email', $email)->first()->inactive){
            return $this->sendBlockedAccountResponse($request);
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            //$this->fireLockoutEvent($request); 
            //return $this->sendLockoutResponse($request);

            $user = User::where('email', $email)->first();
            $user->inactive = 1;
            $user->save();

            return $this->sendBlockedAccountResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendBlockedAccountResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.blocked')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


    /**
     * Custom redirect for IT users, that get redirected to General settings by default.
     *
     * @return string
     */
    public function redirectTo()
    {   
        if (\Illuminate\Support\Facades\Auth::user()->isIT()) {
            return '/settings';
        }

        return '/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Overwrite credentials method to add a custom field 'inactive' in the condition
     * AuthenticatesUsers class method
     * @return array
     */

    protected function credentials(Request $request)
    {
        $c = $request->only($this->username(), 'password');
        return array_merge($c, ['inactive' => 0]);
    }


    /**
     * Overwrite credentials method to check if the password is too old
     * AuthenticatesUsers class method
     */
    protected function authenticated(Request $request, $user)
    {

        if( $user->hasOldPassword() ){

            $user->inactive = 1;
            $user->save();

            auth()->logout();

            $errors = [$this->username() => trans('auth.password_expired')];

            return redirect()->back()->withErrors($errors);

        }

    }


}
