<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcceptTaskRequest;
use App\Http\Requests\ConfirmationTaskRequest;
use App\Http\Requests\DeclineTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Models\Media;
use App\Models\Mystery;
use App\Models\Permissions;
use App\Models\Project\Project;
use App\Models\Section;
use App\Models\Task;
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
class TaskController extends Controller
{
    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
    }

    /**
     * Tasks Management index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->canAccessTasks() == false) {
            redirect('dashboard');
        }
        return view('back.admin.tasks');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {

        $fieldsToSelect = [
            'tasks.id',
            \DB::raw('users.id AS user_id'),
            \DB::raw('projects.id AS project_id'),
            'tasks.section',
            'tasks.position',
            'tasks.status',
            'tasks.reason_declined',
            'tasks.name',
            'tasks.reason',
            'tasks.data_json',
            \DB::raw('users.name AS user_name'),
            \DB::raw('users.email AS user_email'),
            \DB::raw('projects.name AS project_name')
        ];

        $tasks = Task::select($fieldsToSelect)
            ->join('users','tasks.user_id','=','users.id')
            ->join('projects','tasks.project_id','=','projects.id');

            $tasks->orderBy('tasks.status', 'asc');
        

        $order = $request->get('order')[0];
        switch ($order['column']) {
            case 1:
                $tasks->orderBy('tasks.name', $order['dir']);
                break;

            case 2:
                $tasks->orderBy('projects.name', $order['dir']);
                break;

            case 3:
                $tasks->orderBy('tasks.section', $order['dir']);
                break;
        }
        $tasks->orderBy('tasks.updated_at', 'asc');

        if (!Auth::user()->isAdmin() && Auth::user()->isProjectCoordinator()) {

            $projects = DB::table('permission_user_project')->where('user_id', Auth::user()->id)->get()->toArray();
            $projectsIds = array_map(function($e) {
                return is_object($e) ? $e->project_id : $e['project_id'];
            }, $projects);
            $tasks->whereIn('tasks.project_id', $projectsIds);

        } else {
            if(!Auth::user()->isAdmin())
            {
                $tasks->where('tasks.user_id', Auth::user()->id);
            }
        }

        $datatables = app('datatables')->of($tasks)
            ->addColumn('task_url', function ($task) {
                return $this->getSectionURL($task->project_id, $task->section);
            })
            ->addColumn('section_name', function ($task) {
                return $task->getSectionName();
            })
            ->addColumn('proposal', function ($task) {
                // take care here! error not specifed on table creation
                return json_encode($task->getHumanReadableData());
            })
            ->addColumn('files_json', function ($task) {

                $provFiles = \App\Models\Mystery::where('project', $task->project_id)
                    ->where('section', $task->section)
                    ->where('position', $task->position)->get()->toArray();

                foreach($provFiles as $key => $value){

                    $provFiles[$key]['url'] = route('application.mystery', ['id' => $provFiles[$key]['id']]);

                }

                return json_encode($provFiles, JSON_UNESCAPED_UNICODE);
            })
            ->addColumn('files_to_delete', function ($task) {

                $toDeleteFiles = Media::where('project', $task->project_id)
                    ->where('section', $task->section)
                    ->where('position', $task->position)
                    ->where('to_delete', 1)
                    ->get()->toArray();

                foreach($toDeleteFiles as $key => $value){

                    $toDeleteFiles[$key]['url'] = route('application.media', ['id' => $toDeleteFiles[$key]['id']]);

                }

                return json_encode($toDeleteFiles, JSON_UNESCAPED_UNICODE);
            });

        return $datatables->make(true);
    }


    private function getSectionURL($project_id,$section){

        $name = "";

        switch ($section){
            case "d": $name = "project-details-documents"; break;
            case "env": $name = "project-details-environment"; break;
            case "a": $name = "project-details-announcements"; break;
            case "pri": $name = "project.procurement"; break;
            case "ri": $name = "project-details-risks"; break;
            case "e": $name = "project-details-evaluation-ppp"; break;
            case "fi": $name = "project-details-financial"; break;
            case "gs": $name = "project-details-government-support"; break;
            case "t": $name = "project-details-tariffs"; break;
            case "ct": $name = "project-details-contract-termination"; break;
            case "r": $name = "project-details-renegotiations"; break;
            case "i": $name = "project.project-information"; break;
            case "par": $name = "project.parties"; break;
            case "g": $name = "project.gallery"; break;
            case "cm": $name = "project.contract-milestones"; break;
            case "ism": $name = "project.performance-information.income-statements-metrics"; break;
            case "of": $name = "project.performance-information.other-financial-metrics"; break;
            case "kpi": $name = "project.performance-information.key-performance-indicators"; break;
            case "pf": $name = "project.performance-information.performance-failures"; break;
            case "pa": $name = "project.performance-information.performance-assessments"; break;
            case "cs": $name = "project-details-contract-summary"; break;
            case "aw": $name = "project-details-award"; break;
            case "awf": $name = "project-details-award"; break;

        }

        return route($name,['id'=>$project_id]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pendingTable(Request $request)
    {
        $tasks = Task::select([
            'tasks.id',
            \DB::raw('users.id AS user_id'),
            \DB::raw('projects.id AS project_id'),
            'tasks.section',
            'tasks.position',
            'tasks.status',
            'tasks.reason_declined',
            'tasks.name',
            'tasks.reason',
            \DB::raw('users.name AS user_name'),
            \DB::raw('projects.name AS project_name'),
            \DB::raw('DATE_FORMAT(tasks.deadline,\'%d-%m-%Y %H:%i\') AS deadline')
        ])
        ->join('users','tasks.user_id','=','users.id')
        ->join('projects','tasks.project_id','=','projects.id')
        ->where('completed', false)
        ->orderBy('tasks.updated_at', 'desc');

        if (!Auth::user()->isAdmin()) {
            $tasks->where('tasks.user_id', Auth::user()->id)->where('tasks.accepted', true);
        }

        $datatables =  app('datatables')->of($tasks);

        return Datatables::of($tasks)->make(true);
    }

    public function accept(AcceptTaskRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $task = Task::find($request->get('id'));
            $task->accept();

            $project = $task->project()->first();
            $section = $task->section()->first();
            $subject = trans('emails/tasks.accepted_subject');
            $creator = $task->user()->first();

            $emailData = [
                'name' => $creator->name,
                'project' => $project->name,
                'section' => $section->name,
                'subject' => $subject,
            ];

            Mail::send('back.emails.tasks.rfmAccepted', $emailData, function ($message) use ($creator, $subject) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($creator->email);
            });

            $adminEmails = array_column(User::join('roles','role_id','=','roles.id')
                ->where('roles.name','role_admin')->get()->toArray(), 'email');

            Mail::send('back.emails.tasks.rfmAcceptedAdmin', $emailData, function ($message) use ($adminEmails, $subject) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($adminEmails);
            });

            $coordEmails = array_column(User::join('permission_user_project','user_id','=','users.id')
                ->join('roles','role_id','=','roles.id')
                ->where('project_id',$project->id)
                ->where('roles.name','role_data_entry_project_coordinator')->get()->toArray(),'email');

            if (in_array(Auth::user()->email, $coordEmails)) {
                $email_key = array_search(Auth::user()->email, $coordEmails);
                unset($coordEmails[$email_key]);
            }

            Mail::send('back.emails.tasks.rfmAcceptedProjectCoordinator', $emailData, function ($message) use ($coordEmails, $subject) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($coordEmails);
            });

            DB::commit();
        } catch (\Exception $e) {dump($e);exit;
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TaskController@complete[".$request->get('id')."]".PHP_EOL.
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


    public function confirm(ConfirmationTaskRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $task = Task::find($request->get('id'));
            $task->status = 2;
            $task->save();

            $project = $task->project()->first();
            $section = $task->section()->first();
            $subject = trans('emails/tasks.confirmed_subject');
            $creator = $task->user()->first();

            $emailData = [
                'name' => 'Admin',
                'project' => $project->name,
                'section' => $section->name,
                'subject' => $subject,
            ];

            $adminEmails = array_column(User::join('roles','role_id','=','roles.id')
                ->where('roles.name','role_admin')->get()->toArray(), 'email');

            Mail::send('back.emails.tasks.rfmSubmittedApprovalAdmin', $emailData, function ($message) use ($subject, $adminEmails) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($adminEmails);
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TaskController@confirm[".$request->get('id')."]".PHP_EOL.
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


    public function decline(DeclineTaskRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $task = Task::find($request->get('id'));

            $mediaToUpload = \App\Models\Mystery::where([
                'project' => $task->project_id,
                'section' => $task->section,
                'position' => $task->position
            ])->get()->toArray();

            $idsMistery = array_column($mediaToUpload, 'id');
            DB::table('mysteries')->whereIn('id', $idsMistery)->delete();
            $path = storage_path('app/mysterybox/'.$task->project_id.'/'.$task->section.'/'.$task->position);
            \Illuminate\Support\Facades\File::deleteDirectory($path);

            $task->status = 0;
            $task->reason_declined = $request->get('reason');
            $task->save();

            $project = $task->project()->first();
            $section = $task->section()->first();
            $subject = trans('emails/tasks.declined_subject');
            $creator = $task->user()->first();

            $emailData = [
                'name' => $creator->name,
                'project' => $project->name,
                'section' => $section->name,
                'subject' => $subject,
                'reason' => $task->reason_declined
            ];

            $mails = [];

            $adminEmails = [];
            
                $adminEmails = array_column(User::join('roles','role_id','=','roles.id')
                    ->where('roles.name','role_admin')->get()->toArray(), 'email');

            $coordEmails = array_column(User::join('permission_user_project','user_id','=','users.id')
                ->join('roles','role_id','=','roles.id')
                ->where('project_id',$project->id)
                ->where('roles.name','role_data_entry_project_coordinator')->get()->toArray(),'email');

            $mails = array_merge($adminEmails, $coordEmails);

            if (in_array(Auth::user()->email, $mails)) {
                $email_key = array_search(Auth::user()->email, $mails);
                unset($mails[$email_key]);
            }

            Mail::send('back.emails.tasks.rfmDeclined', $emailData, function ($message) use ($subject, $creator) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($creator->email);
            });

            Mail::send('back.emails.tasks.rfmDeclinedAdmin', $emailData, function ($message) use ($subject, $mails) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($mails);
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TaskController@complete[".$request->get('id')."]".PHP_EOL.
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

    /**
     * Edit a task.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EditTaskRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $task = Task::find($request->get('id'));

            if( Auth::user()->isAdmin() ){
                $task->name = $request->get('name');
            }

            $task->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TaskController@edit[".$request->get('id')."]".PHP_EOL.
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

    /**
     * Delete a task.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteTaskRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            $task = Task::find($request->get('id'));

            $mediaToUpload = \App\Models\Mystery::where([
                'project' => $task->project_id,
                'section' => $task->section,
                'position' => $task->position
            ])->get()->toArray();

            $idsMistery = array_column($mediaToUpload, 'id');
            DB::table('mysteries')->whereIn('id', $idsMistery)->delete();
            $path = storage_path('app/mysterybox/'.$task->project_id.'/'.$task->section.'/'.$task->position);
            \Illuminate\Support\Facades\File::deleteDirectory($path);

            $task->delete();

            DB::commit();

            // Send a declined email
            if ($task->isUnknown()) {
                $project = $task->project()->first();
                $section = $task->section()->first();
                $subject = trans('emails/tasks.declined_subject');
                $creator = $task->user()->first();

                $emailData = [
                    'name' => $creator->name,
                    'project' => $project->name,
                    'section' => $section->name,
                    'subject' => $subject,
                    'reason' => $task->reason_declined
                ];

                $adminEmails = array_column(User::join('roles','role_id','=','roles.id')
                    ->where('roles.name','role_admin')->get()->toArray(), 'email');

                Mail::send('back.emails.tasks.rfmDeclined', $emailData, function ($message) use ($adminEmails, $subject, $creator) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject($subject);
                    $message->to($creator->email);
                    $message->bcc($adminEmails);
                });
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TaskController@delete[".$request->get('id')."]".PHP_EOL.
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
