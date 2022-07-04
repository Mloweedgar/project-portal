<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_ProcurementAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ProcurementEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ProcurementDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PD_ProcurementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $procurement;
    public $project;

    public function __construct(Project $project, PD_Procurement $procurement)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->procurement = $procurement;

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
        if (Auth::user()->canAccessPDProcurementInformation($project) === false) {
            return redirect('dashboard');
        }

        $project->procurements;

        // IF there are projectDetails, check if there is a record for PD_Procurement

        if(Auth::user()->isAdmin()){

            $procurements = $project->procurements()->orderBy('position')->get();

        } else {

            $procurements = $project->procurements()->where('published', 1)->orderBy('position')->get();

        }

        $exists = false;

        if($procurements){

            $exists = true;

        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.projectdetails.pd_procurement',compact('project', 'exists', 'procurements', 'hasCoordinators'));
    }

    /**
     * @param PD_ProcurementAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_ProcurementAddRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {


            $project = Project::findOrFail($request->get('project_id'));
            // Create and populate the data
            $procurement = new PD_Procurement();
            $procurement->project_id = $request->input('project_id');
            $procurement->name = $request->input('name');
            $procurement->description = $request->input('description');

            // Draft
            $procurement->draft = 1;

            $maxProc = PD_Procurement::where('project_id',$project->id)->orderBy('position','desc')->first();

            if (!$maxProc){

                $procurement->position = 1;

            }else{

                $procurement->position = $maxProc->position+1;

            }

            // Save the data to the database
            $procurement->save();


            //Update project updated at
            $project->touch();

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
     * @param PD_ProcurementEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_ProcurementEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $procurement = PD_Procurement::find($request->input('id'));
            $procurement->name = $request->input('name');
            $procurement->description = $request->input('description');

            // Save the data to the database
            $procurement->save();

            //Update the project date
            $procurement->project->touch();

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
     * @param PD_ProcurementDeleteRequest $request
     * @return array
     */
    public function delete(PD_ProcurementDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $procurement = PD_Procurement::find($request->input('id'));

            // Delete
            $procurement->delete();

            //Update the project date
            $procurement->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: ProcurementController@delete[".$request->get('id')."]".PHP_EOL.
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
     * @param Request $request
     * @return string
     */
    public function order(Request $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $procurements = PD_Procurement::where('project_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($procurements as $procurement){

                $key = array_search($procurement->position,$order);
                $key++;

                if ($procurement->position!=$key){
                    $procurement->position = $key;
                    $procurement->save();
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
            $data = PD_Procurement::where('project_id', $project)->where('id', $position)->first();

            // Update the field
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $data->published = $visibilityToEdit;

            // Save the data
            $data->save();

            // If visibility transition was from Draft to Published
            // we perform a touch to the project.
            if($visibilityToEdit){

                // Project PUSH
                Project::find($project)->touch();

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
