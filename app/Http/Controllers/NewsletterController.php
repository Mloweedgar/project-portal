<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeNewsletterRequest;
use App\Models\Config;
use App\Models\Newsletter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(SubscribeNewsletterRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {

            $newsletter = new Newsletter;
            $newsletter->name = $request->get('name');
            $newsletter->email = $request->get('email');
            $newsletter->page = $request->get('page');
            $newsletter->token = str_random(32);

            if ($newsletter->save()){

                //Send welcome email
                $name = $request->get('name');
                $email = $request->get('email');
                $link = route('newsletter.activate',['token'=>$newsletter->token]);
                //Get the info

                $emailData = [
                    'name' => $newsletter->name,
                    'email' => $newsletter->email,
                    'link' => $link
                ];

                Mail::send('emails.user.registernewsletter', $emailData, function ($message) use ($email, $name) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject(trans('emails/newsletter.subject'));
                    $message->to($email);
                });

                $failures = Mail::failures();
                if (count($failures) == 0) {
                    $flag['message'] = 'Message successfully sent.';
                } else {
                    $flag['message'] = 'There was a problem while sending the message.';
                    $flag['status'] = false;
                    Log::critical('Mail sending failure', $failures);
                }

            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: NewsletterController@subscribe[".$request->get('id')."]".PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
        }
        return $flag;
    }

    public function activate($token){

        $newsletter = Newsletter::where('token',$token)->first();

        $active = false;

        if ($newsletter){

            $newsletter->token = null;
            $newsletter->unsubscribe_token = str_random(32);

            if ($newsletter->save()){

                $active = true;

            }

        }

        $contactMail = Config::where('name','mail')->first()->value;

        return view('front.newsletter-confirmation',compact('newsletter','active','contactMail'));

    }

    public function unsubscribe($email,$token){

        $newsletter = Newsletter::where('unsubscribe_token',$token)->where('email',$email)->first();

        $active = false;

        if ($newsletter){

            $name = $newsletter->name;

            if ($newsletter->delete()){

                $active = true;

            }

        }

        $contactMail = Config::where('name','mail')->first()->value;

        return view('front.newsletter-unsubscribe',compact('name','active','contactMail'));

    }

    public function unsubscribe_email(Request $request)
    {
        $data = [];
        $data['status'] = true;
        $data['message'] = '';

        try {
            $user = Newsletter::find($request->get('id'));

            if ($user){


                $name = $user->name;
                $email = $user->email;
                $link = route('newsletter.unsubscribe',['email'=>$email,'token'=>$user->unsubscribe_token]);

                $emailData = [
                    'name' => $name,
                    'email' => $email,
                    'link' => $link
                ];

                Mail::send('emails.user.unsubscribenewsletter', $emailData, function ($message) use ($email, $name) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject(trans('emails/newsletter.subject_unsubscribe'));
                    $message->to($email);
                });

                $failures = Mail::failures();
                if (count($failures) == 0) {
                    $data['message'] = 'Email(s) sucessfully sent.';
                } else {
                    $data['message'] = 'There was a problem while sending the email(s).';
                    $data['status'] = false;
                    Log::critical('Mail sending failure', $failures);
                }
            }


        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: NewsletterController@unsubscribe_email".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $data['status'] = false;
            $data['message'] = __('errors.internal_error');
            dd($e);
        }

        return $data;
    }


}
