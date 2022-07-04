<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteNewsletterRequest;
use App\Http\Requests\SubscribeNewsletterRequest;
use App\Models\Newsletter;
use App\Models\Project\Project;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Class TaskController
 *
 * This controller handles the requests of 'Tasks Management' section.
 *
 * @package App\Http\Controllers\Backend
 */
class NewsletterController extends Controller
{
    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin');
    }

    /**
     * Tasks Management index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('back.newsletter', compact('roles'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $subscribers = Newsletter::select(['newsletters.id','newsletters.name','newsletters.email', 'newsletters.token']);
        $datatables =  app('datatables')->of($subscribers);

        return Datatables::of($subscribers)->make(true);
    }

    public function send(Request $request)
    {
        $data = [];
        $data['status'] = true;
        $data['message'] = '';

        try {
            $subject = $request->get('subject');
            $text = $request->get('message');

            if ($roles = $request->get('roles')) {
                $emails = array_column(User::whereIn('role_id', $roles)->get(['email'])->toArray(), 'email');
            } elseif ($user_ids = $request->get('users_id')) {
                $emails =  array_column(User::whereIn('id', $user_ids)->get(['email'])->toArray());
            } else {
                $user_ids = DB::table('permission_user_project')->select('user_id')->where('project_id', $request->get('project_id'))->get()->toArray();
                $user_ids = array_map(function($e) {
                            return is_object($e) ? $e->user_id: $e['user_id'];
                        }, $user_ids);
                $emails = array_column(User::whereIn('id', $user_ids)->get(['email'])->toArray(), 'email');
            }

            $emailData = [
                'subject' => $subject,
                'text' => $text
            ];
            Mail::send('back.emails.newsletter.notification', $emailData, function ($message) use ($emails, $subject) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($emails);
            });

            $failures = Mail::failures();
            if (count($failures) == 0) {
                $data['message'] = 'Notification(s) sucessfully sent.';
            } else {
                $data['message'] = 'There was a problem while sending the notification(s).';
                $data['status'] = false;
                Log::critical('Mail sending failure', $failures);
            }
        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: NewsletterController@send".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $data['status'] = false;
            $data['message'] = __('errors.internal_error');
            dd($e);
        }

        return back()
            ->with('status', $data['status'])
            ->with('message', $data['message']);
    }

    public function delete(DeleteNewsletterRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $subscriber = Newsletter::find($request->get('id'));
            $subscriber->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: NewsletterController@delete[".$request->get('id')."]".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
        }

        return $flag;
    }

    public function deleteMultiple(Request $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            $subscribersIds = $request->get('data');

            $deleteSubscribers = DB::table('newsletters')->whereIn('id', $subscribersIds)->delete();
            if ($deleteSubscribers == 0) {
                $flag["status"] = false;
                $flag["error"] = __('errors.internal_error');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: NewsletterController@deleteMultiple[".$request->get('id')."]".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
        }
        return $flag;
    }

}
