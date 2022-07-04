<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Newsletter;
use App\Models\Project\Project;
use App\Models\Task;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public $user;

    public function __construct(User $user)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->user = $user;

    }


    /**
     * Shows the dashboard screen.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::user()->isIT()) {
            \Illuminate\Support\Facades\Redirect::to('settings')->send();
        }

        if (Auth::user()->isAuditor()) {
            \Illuminate\Support\Facades\Redirect::to(route('activity_log'))->send();
        }

        $user_id = Auth::id();

        $query =  Task::select([
            'tasks.id',
            'tasks.name',
            \DB::raw('(SELECT name FROM sections WHERE section_code = tasks.section) AS section_name'),
            \DB::raw('projects.name AS project_name'),
            \DB::raw('users.email AS user_email'),
        ])
            ->join('users','tasks.user_id','=','users.id')
            ->join('projects','tasks.project_id','=','projects.id');

        // oldest one first, pending ones first
        $query->where('tasks.status', null);

        if (Auth::user()->isProjectCoordinator()) {

            $projects = DB::table('permission_user_project')->where('user_id', Auth::user()->id)->get()->toArray();
            $projectsIds = array_map(function($e) {
                return is_object($e) ? $e->project_id : $e['project_id'];
            }, $projects);
            $query->whereIn('tasks.project_id', $projectsIds);

        } else {
            $query->where('tasks.user_id', Auth::user()->id);
        }

        $tasks = $query->get();

        /** @var IN THE CASE OF ADMIN AND GUEST CACHE AT THE FRONTEND $projects_count */
        $projects_count = Project::select([
            \DB::raw('COUNT(*) as stage_count'),
            'stages.name'
        ])
            ->join('project_information','projects.id','=','project_information.project_id')
            ->join('stages','project_information.stage_id','=','stages.id')
            ->groupBy('stages.name')
            ->get();

        // projects
        if (!Auth::user()->isAdmin()) {

            $projects = Project::select([
                'projects.name',
                'projects.id',
                \DB::raw('DATE_FORMAT(projects.updated_at,\'%d-%m-%Y %H:%i\') AS updated'),
            ])
                ->join("permission_user_project",'projects.id','project_id')
                ->where('permission_user_project.user_id',Auth::user()->id)
                ->latest('projects.updated_at')
                ->limit(10)
                ->get();

            /**
             * OVERWRITE THE PROJECTS COUNT
             */
            $projects_count = Project::select([
                \DB::raw('COUNT(*) as stage_count')
            ])
                ->join("permission_user_project",'projects.id','project_id')
                ->where('permission_user_project.user_id',Auth::user()->id)
                ->get();

        } else {

            $projects = Project::select([
                'projects.name',
                'projects.id',
                \DB::raw('DATE_FORMAT(projects.updated_at,\'%d-%m-%Y %H:%i\') AS updated'),
            ])
                ->latest('projects.updated_at')
                ->limit(10)
                ->get();

        }

        $users_total = User::select([
            \DB::raw('COUNT(*) as count')
        ])
            ->first();

        $newsletter = Newsletter::select([
            \DB::raw('COUNT(*) as count')
        ])
            ->first();

        $count = 0;

        foreach ($projects_count as $pc){

            $count += $pc->stage_count;

        }

        return view('back.admin.dashboard',compact('tasks','projects','projects_count','count','users_total','newsletter'));

    }
}
