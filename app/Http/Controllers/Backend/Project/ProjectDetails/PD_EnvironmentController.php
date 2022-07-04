<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_DocumentEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_EnvironmentEditRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Environment;
use App\Models\Project\ProjectDetails\ProjectDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_EnvironmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $pd_document;
    public $project;

    public function __construct(Project $project, PD_Environment $pd_environment)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->pd_document = $pd_environment;

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
        if (Auth::user()->canAccessPDEnvironment($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_documents
        if($projectDetail){

            $environment = $projectDetail->environment;

        } else {

            $environment = null;

        }

        $exists = false;

        if($environment){
            $exists = true;
        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.projectdetails.pd_environment',compact('project', 'projectDetail', 'exists', 'environment', 'hasCoordinators'));
    }



    /**
     * @param PD_DocumentEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_EnvironmentEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $environment = PD_Environment::find($request->input('id'));
            $environment->description = $request->input('description');

            // Save the data to the database
            $environment->save();

            //Update the project date
            $environment->projectDetail->project->touch();

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
     * @param ChangeIndividualVisibilityRequest $request
     * @return array
     */
    public function visibility(ChangeIndividualVisibilityRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $project = $request->get('project');
            $position = $request->get('position');

            // Find Project Information
            $data = PD_Environment::where('project_details_id', $project)->where('id', $position)->first();

            // Update the field
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $data->published = $visibilityToEdit;

            // Save the data
            $data->save();

            // If visibility transition was from Draft to Published
            // we perform a touch to the project.
            if($visibilityToEdit){

                // Project PUSH
                $data->projectDetail->project->touch();

            }

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            Log::debug($e->getMessage());

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return $flag;

    }

}
