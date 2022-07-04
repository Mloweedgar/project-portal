<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_EvaluationAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_EvaluationEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_EvaluationDeleteRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_EvaluationPPP;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_EvaluationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $evaluation;

    public function __construct(Project $project, PD_EvaluationPPP $evaluation)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->evaluation = $evaluation;

    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {
        // Check if the project exists
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPDEvaluationPPP($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail){

            $evaluations = PD_EvaluationPPP::where('project_details_id', $projectDetail->id)->get();

        } else {

            $evaluations = null;

        }

        $exists = false;

        if($evaluations){

            $exists = true;

        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        // Send the instance
        $controller = $this;

        return view('back.project.projectdetails.pd_evaluation-ppp', compact('project', 'projectDetail', 'exists', 'evaluations', 'controller', 'hasCoordinators'));

    }

    /**
     * @param PD_EvaluationAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_EvaluationAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $evaluation = new PD_EvaluationPPP();
            $evaluation->project_details_id = $request->input('project_details_id');
            $evaluation->name = $request->input('name');
            $evaluation->description = $request->input('description');

            // Draft
            $evaluation->draft = 1;

            // Save the data to the database
            $evaluation->save();

            //Update the project date
            $evaluation->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;



            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }

    /**
     * @param PD_EvaluationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_EvaluationEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $evaluation = PD_EvaluationPPP::find($request->input('id'));
            $evaluation->name = $request->input('name');
            $evaluation->description = $request->input('description');
            $type = $request->get('submit-type');

            if($type == 'publish'){
                $evaluation->published = 1;
                $evaluation->draft = 0;
            }else if($type == 'save_draft'){
                $evaluation->draft = 1;
                $evaluation->published = 0;

                $subject = trans('emails/tasks.publish_subject');

                $emailData = [
                    'name' => Auth::user()->name,
                    'subject' => $subject,
                ];

                Mail::send('back.emails.tasks.completeRFM', $emailData, function ($message) use ($subject) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject($subject);
                    $message->to(Auth::user()->email);
                });

            }else if($type == 'request_modification'){
                $evaluation->request_modification = 1;
            }
            // Save the data to the database
            $evaluation->save();

            //Update the project date
            $evaluation->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);
    }

    /**
     * @param PD_EvaluationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_EvaluationDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $evaluation = PD_EvaluationPPP::find($request->input('id'));

            // Delete
            $evaluation->delete();

            //Update the project date
            $evaluation->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: EvaluationController@delete[".$request->get('id')."]".PHP_EOL.
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
