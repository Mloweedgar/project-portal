<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactRequest;
use App\Http\Requests\SendOnlineRequest;
use App\Models\Config;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function contact(){

        $data['coord_x'] = Config::where('name','coord-x')->first()->value;
        $data['coord_y'] = Config::where('name','coord-y')->first()->value;

        return view('front.contact',$data);
    }

    public function send(SendContactRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            $name = $request->get('name');
            $email = $request->get('email');
            $text = $request->get('message');

            $emailData = [
                'name' => $name,
                'email' => $email,
                'text' => $text,
                'subject' => trans('emails/contact.subject')
            ];

            Mail::send('emails.contact.default', $emailData, function ($message) use ($email, $name) {
                $message->from($email, $name);
                $message->subject(trans('emails/contact.subject'));
                $message->to(config('mail.from.address'));


            });

            $failures = Mail::failures();

            if (count($failures) == 0) {
                $flag['message'] = trans('emails/contact.success');
            } else {
                $flag['message'] = trans('emails/contact.error');
                $flag['status'] = false;
                Log::critical('Mail sending failure', $failures);
            }

        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: ContactController@send".PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag['status'] = false;
            $flag['message'] = __('errors.internal_error');
        }

        return $flag;
    }

    public function sendOnlineRequest(SendOnlineRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            $name = $request->get('name');
            $email = $request->get('email');
            /*$document = \App\Models\Project\ProjectDetails\PD_Document::getRequestDocumentsList($request->get('document'));*/
            $document = Section::find($request->get('document'))->name;
            $description = $request->get('description');
            $subject = trans('emails/online_request.subject') . ' ['.$document.']';

            $emailData = [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'description' => $description,
                'subject' => $subject,
            ];

            Mail::send('emails.onlineRequest.default', $emailData, function ($message) use ($email, $name, $document, $subject) {
                $message->from($email, $name);
                $message->subject($subject);
                $message->to(config('mail.from.address'));
            });

            $failures = Mail::failures();
            if (count($failures) == 0) {
                $flag['message'] = trans('emails/online_request.success');
            } else {
                $flag['message'] = trans('emails/online_request.error');
                $flag['status'] = false;
                Log::critical('Mail sending failure', $failures);
            }
        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: ContactController@sendOnlineRequest".PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag['status'] = false;
            $flag['message'] = __('errors.internal_error');
        }

        return $flag;
    }

}
