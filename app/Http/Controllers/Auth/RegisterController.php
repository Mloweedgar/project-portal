<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    protected function customRegister(Request $request){



       $sengrid= new Sengrid();
       $errors=null;

        $data=$request->all();

        $this->validator($request->all())->validate();

        try {
            if (!$this->welcome_email($request->all())) {
                $errors['email'][] = __("messages.email.error");
            }
        }catch(\Swift_TransportException  $e){
            //dd($e->getMessage());

            $errors['email'][] = __("messages.email.not.reachable");

        }

        if(!empty($sengrid->checkEmailBlocked($data['email']))){
            $errors['email'][]= __("messages.email.blocked");

        }

        if(!empty($sengrid->checkEmailInvalid($data['email']))){
            $errors['email'][] = __("messages.email.invalid");
        }

        if(!empty($sengrid->checkEmailBounce($data['email']))){
            $errors['email'][] = __("messages.email.not.reachable");
        }

        if($errors){
            return redirect()->back()->withErrors($errors);
        }


        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());


    }

    protected function welcome_email(array $data){


        $title="Register confirmation!";
        $content="Welcome to our site";
        $email['to']=$data['email'];
        $email['from']=config('mail.from.address');
        $email['from_name']=config('mail.from.name');
        $email['subject']='Register confirmation!';

        Mail::send('auth.confirmation.confirmation', ['title'=>$title, 'content'=>$content], function ($message) use ($email) {
            $message->from($email['from'], $email['from_name']);
            $message->subject($email['subject']);
            $message->to($email['to']);
        });


        if(count(Mail::failures()) > 0){

            return false;
        }else{
            return true;
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => bcrypt($data['password']),]);
    }
}


class Sengrid{

    private $apiuser;
    private $apikey;


    /**
     * Register the application services.
     *
     * @return void
     */
    public function __construct()
    {

        $this->apiuser = config('mail.username');
        $this->apikey = config('mail.password');
    }


    public function get($action){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->apikey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        return json_decode($response);

    }

    public function checkEmailBlocked($email){
        return $this->get("https://api.sendgrid.com/v3/suppression/blocks/".$email);
    }

    public function checkEmailInvalid($email){
       return $this->get("https://api.sendgrid.com/v3/suppression/invalid_emails/".$email);
    }

    public function checkEmailBounce($email){
        return $this->get("https://api.sendgrid.com/v3/suppression/bounces/".$email);
    }



}