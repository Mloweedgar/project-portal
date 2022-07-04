<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_ContractSummaryAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ContractSummaryEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ContractSummaryDeleteRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_ContractSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;

class PD_ContractSummaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $contract_summaries;

    public function __construct(Project $project, PD_ContractSummary $contract_summaries)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->contract_summaries = $contract_summaries;

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
        if (Auth::user()->canAccessPDContractSummary($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail) {

            $contract_summaries = PD_ContractSummary::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

        } else {

            $contract_summaries = null;

        }

        $exists = false;

        if($contract_summaries){

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

        return view('back.project.projectdetails.pd_contract-summary', compact('project', 'projectDetail', 'exists', 'contract_summaries', 'controller', 'hasCoordinators'));

    }

    /**
     * @param PD_ContractSummaryAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_ContractSummaryAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $contract_summaries = new PD_ContractSummary();
            $contract_summaries->project_details_id = $request->input('project_details_id');
            $contract_summaries->name = $request->input('name');
            $contract_summaries->description = $request->input('description');
            $contract_summaries->draft = 1;

            $maxProc = PD_ContractSummary::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $contract_summaries->position = 1;

            }else{

                $contract_summaries->position = $maxProc->position+1;

            }

            // Save the data to the database
            $contract_summaries->save();

            //Update the project date
            $contract_summaries->projectDetail->project->touch();

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
     * @param PD_ContractSummaryEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_ContractSummaryEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $contract_summaries = PD_ContractSummary::find($request->input('id'));
            $contract_summaries->name = $request->input('name');
            $contract_summaries->description = $request->input('description');

            $type = $request->get('submit-type');

            
            // Save the data to the database
            $contract_summaries->save();

            //Update the project date
            $contract_summaries->projectDetail->project->touch();

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
     * @param PD_ContractSummaryEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_ContractSummaryDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $contract_summaries = PD_ContractSummary::find($request->input('id'));

            // Delete
            $contract_summaries->delete();

            //Update the project date
            $contract_summaries->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: ContractSummaryController@delete[".$request->get('id')."]".PHP_EOL.
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

            $summaries = PD_ContractSummary::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($summaries as $summary){

                $key = array_search($summary->position,$order);
                $key++;

                if ($summary->position!=$key){
                    $summary->position = $key;
                    $summary->save();
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
            $data = PD_ContractSummary::where('project_details_id', $project)->where('id', $position)->first();

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
