<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_RenegotiationsAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_RenegotiationsEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_RenegotiationsDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_Renegotiations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_RenegotiationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $renegotiations;

    public function __construct(Project $project, PD_Renegotiations $renegotiations)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->renegotiations = $renegotiations;

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
        if (Auth::user()->canAccessPDRenegotiations($project) === false) {
            return redirect('dashboard');
        }


        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $renegotiations = PD_Renegotiations::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $renegotiations = PD_Renegotiations::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

        } else {

            $renegotiations = null;

        }

        $exists = false;

        if($renegotiations){

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

        return view('back.project.projectdetails.pd_renegotiations', compact('project', 'projectDetail', 'exists', 'renegotiations', 'controller', 'hasCoordinators'));

    }

    /**
     * @param PD_RenegotiationsAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_RenegotiationsAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $renegotiations = new PD_Renegotiations();
            $renegotiations->project_details_id = $request->input('project_details_id');
            $renegotiations->name = $request->input('name');
            $renegotiations->description = $request->input('description');

            // Draft
            $renegotiations->draft = 1;

            $maxProc = PD_Renegotiations::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $renegotiations->position = 1;

            }else{

                $renegotiations->position = $maxProc->position+1;

            }

            // Save the data to the database
            $renegotiations->save();

            //Update the project date
            $renegotiations->projectDetail->project->touch();

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
     * @param PD_RenegotiationsEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_RenegotiationsEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $renegotiations = PD_Renegotiations::find($request->input('id'));
            $renegotiations->name = $request->input('name');
            $renegotiations->description = $request->input('description');

            // Save the data to the database
            $renegotiations->save();

            //Update the project date
            $renegotiations->projectDetail->project->touch();

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
     * @param PD_RenegotiationsDeleteRequest $request
     * @return array
     */
    public function delete(PD_RenegotiationsDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $renegotiations = PD_Renegotiations::find($request->input('id'));

            // Delete
            $renegotiations->delete();

            //Update the project date
            $renegotiations->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: TariffsController@delete[".$request->get('id')."]".PHP_EOL.
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

    public function order(Request $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $renegotiations = PD_Renegotiations::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($renegotiations as $renegotiation){

                $key = array_search($renegotiation->position,$order);
                $key++;

                if ($renegotiation->position!=$key){
                    $renegotiation->position = $key;
                    $renegotiation->save();
                }


            }

            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again

        return json_encode($flag);

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
            $data = PD_Renegotiations::where('project_details_id', $project)->where('id', $position)->first();

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
