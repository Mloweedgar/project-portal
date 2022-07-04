<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_RiskAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_RiskEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_RiskDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_RiskAllocation;
use App\Models\Project\ProjectDetails\PD_RiskCategory;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_RiskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $risk;
    public $project;

    public function __construct(Project $project, PD_Risk $risk)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->risk = $risk;

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
        if (Auth::user()->canAccessPDRisks($project) === false) {
            return redirect('dashboard');
        }


        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // Get project allocations
        $allocations = PD_RiskAllocation::all();

        // Get all risks categories
        $categories = PD_RiskCategory::all();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $risks = PD_Risk::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $risks = PD_Risk::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

        } else {

            $risks = null;

        }

        $exists = false;

        if($risks){

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

        return view('back.project.projectdetails.pd_risk',compact('project', 'projectDetail', 'exists', 'risks', 'allocations', 'controller', 'hasCoordinators', 'categories'));

    }

    /**
     * @param PD_RiskAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_RiskAddRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $risk = new PD_Risk();
            $risk->project_details_id = $request->input('project_details_id');
            $risk->risk_allocation_id = $request->input('risk_allocation_id');
            $risk->name = $request->input('name');
            $risk->description = $request->input('description');
            $risk->mitigation = $request->input('mitigation');
            $risk->risk_category_id = $request->input('risk_category_id');

            // Draft
            $risk->draft = 1;

            $maxProc = PD_Risk::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $risk->position = 1;

            }else{

                $risk->position = $maxProc->position+1;

            }
            // Save the data to the database
            $risk->save();

            //Update the project date
            $risk->projectDetail->project->touch();

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
     * @param PD_RiskEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_RiskEditRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $risk = PD_Risk::find($request->input('id'));
            $risk->risk_allocation_id = $request->input('risk_allocation_id');
            $risk->name = $request->input('name');
            $risk->description = $request->input('description');
            $risk->mitigation = $request->input('mitigation');
            $risk->risk_category_id = $request->input('risk_category_id');

            // Save the data to the database
            $risk->save();

            //Update the project date
            $risk->projectDetail->project->touch();

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
     * @param $id
     * @return mixed
     */
    public function translateRiskAllocations($id){

        return PD_RiskAllocation::where('id', '=', $id)->first()->name;

    }

    /**
     * @param PD_RiskEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_RiskDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $financial = PD_Risk::find($request->input('id'));

            // Delete
            $financial->delete();

            //Update the project date
            $financial->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: RiskController@delete[".$request->get('id')."]".PHP_EOL.
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

            $risks = PD_Risk::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($risks as $risk){

                $key = array_search($risk->position,$order);
                $key++;

                if ($risk->position!=$key){
                    $risk->position = $key;
                    $risk->save();
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
            $data = PD_Risk::where('project_details_id', $project)->where('id', $position)->first();

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
