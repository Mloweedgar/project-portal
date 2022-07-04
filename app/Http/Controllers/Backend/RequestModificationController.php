<?php

namespace App\Http\Controllers\Backend;

use App\Models\Media;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Models\Section;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class RequestModificationController extends Controller
{
    public function store(Request $request)
    {
        $rfm_complete = true;

        $input = $request->all();

        if(isset($input["files_to_delete"])){
            DB::table('media')->whereIn('id', $input["files_to_delete"])->update(array('to_delete' => true));
        }

        $rfm = new Task();
        $rfm->user_id = Auth::user()->id;

        if ($input['section'] == 'kpi' && $input['position'] == 1) {
            $data_json = [];

            if (isset($input['existingRecords'])) {
                $data_json['existingRecords'] = $input['existingRecords'];
            }

            if (isset($input['newRecords'])) {
                $data_json['newRecords'] = $input['newRecords'];
            }

            $rfm->project_id = $input['project_id'];
            $rfm->section = 'kpi';
            $rfm->position = 1;
            $rfm->reason = $input['reason'];
            $rfm->data_json = json_encode($data_json);

        } else {


            // those are section specific fields and are specified on the section view
            $section_required_fields = explode(',', $input['section_fields']);

            // those are always required to create a RFM so they are 'global' fields
            $always_required_fields = ['project', 'section', 'position', 'reason'];

            // used to build the JSON data
            $required_fields = array_merge($section_required_fields, $always_required_fields);

            $data_json = [];
            foreach ($input as $name => $value) {
                if (in_array($name, $section_required_fields)) {
                    $data_json[$name] = $value;
                }
            }

            $data_json = json_encode($data_json);

            $rfm->project_id = $request->project;
            $rfm->section = $request->section;
            $rfm->position = $request->position;
            $rfm->reason = $request->reason;
            $rfm->data_json = $data_json;
        }

        $rfm->status = null; // to be accepted or declined
        if ($rfm->position == 0) {
            $rfm->name = trans('task.request_creation');
        } else {
            $rfm->name = trans('task.request_modification');
        }

        $saved = $rfm->save();

        $project = \App\Models\Project\Project::find($rfm->project_id);
        $section = \App\Models\Section::where('section_code', $rfm->section)->first();

        $subject = trans('emails/tasks.confirmation_subject');

        $emailData = [
            'name' => Auth::user()->name,
            'project' => $project->name,
            'section' => $section->name,
            'subject' => $subject,
        ];

        Mail::send('back.emails.tasks.rfmConfirmation', $emailData, function ($message) use ($subject) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->subject($subject);
            $message->to(Auth::user()->email);
        });

        // mails
        $emails = [];

        $coordEmails = array_column(User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->get()->toArray(),'email');

        $adminEmails = [];
        $adminEmails = array_column(User::join('roles','role_id','=','roles.id')
                ->where('roles.name','role_admin')->get()->toArray(), 'email');
        
        $emails = array_merge($coordEmails, $adminEmails);

        if (in_array(Auth::user()->email, $emails)) {
            $email_key = array_search(Auth::user()->email, $emails);
            unset($emails[$email_key]);
        }

        Mail::send('back.emails.tasks.rfmConfirmationAdmin', $emailData, function ($message) use ($emails, $subject) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->subject($subject);
            $message->to($emails);
        });

        if ($input['section'] == 'kpi' && $input['position'] == 1) {
            return [
                'status' => true,
                'rfm' => true
            ];
        } else {
            return redirect()->back()->with(['rfm_complete'=>$rfm_complete]);
        }

    }

}
