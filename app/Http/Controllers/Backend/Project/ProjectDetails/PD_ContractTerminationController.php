<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_ContractTerminationAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ContractTerminationEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_ContractTerminationDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_ContractTermination;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_ContractTerminationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $contract_terminations;

    public function __construct(Project $project, PD_ContractTermination $contract_terminations)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->contract_terminations = $contract_terminations;

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
        if (Auth::user()->canAccessPDContractTermination($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail) {

            if(Auth::user()->isAdmin()){

                $contract_terminations = PD_ContractTermination::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $contract_terminations = PD_ContractTermination::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

            $parties = Entity::all();

        } else {

            $contract_terminations = null;

        }

        $exists = false;

        if($contract_terminations){

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

        return view('back.project.projectdetails.pd_contract-termination', compact('project', 'projectDetail', 'exists', 'contract_terminations', 'parties', 'controller', 'hasCoordinators'));

    }

    /**
     * @param PD_ContractTerminationAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_ContractTerminationAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $contract_terminations = new PD_ContractTermination();
            $contract_terminations->project_details_id = $request->input('project_details_id');
            $contract_terminations->party_type = $request->input('party_type');
            $contract_terminations->name = $request->input('name');
            $contract_terminations->description = $request->input('description');
            $contract_terminations->termination_payment = $request->input('termination_payment');
            $contract_terminations->draft = 1;
            $maxProc = PD_ContractTermination::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $contract_terminations->position = 1;

            }else{

                $contract_terminations->position = $maxProc->position+1;

            }


            // Save the data to the database
            $contract_terminations->save();

            //Update the project date
            $contract_terminations->projectDetail->project->touch();

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
     * @param PD_ContractTerminationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_ContractTerminationEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $contract_terminations = PD_ContractTermination::find($request->input('id'));
            $contract_terminations->party_type = $request->input('party_type');
            $contract_terminations->name = $request->input('name');
            $contract_terminations->description = $request->input('description');
            $contract_terminations->termination_payment = $request->input('termination_payment');

            // Save the data to the database
            $contract_terminations->save();

            //Update the project date
            $contract_terminations->projectDetail->project->touch();

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
     * @param PD_ContractTerminationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_ContractTerminationDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $contract_terminations = PD_ContractTermination::find($request->input('id'));

            // Delete
            $contract_terminations->delete();

            //Update the project date
            $contract_terminations->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: ContractTerminationController@delete[".$request->get('id')."]".PHP_EOL.
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

            $terminations = PD_ContractTermination::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($terminations as $termination){

                $key = array_search($termination->position,$order);
                $key++;

                if ($termination->position!=$key){
                    $termination->position = $key;
                    $termination->save();
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
            $data = PD_ContractTermination::where('project_details_id', $project)->where('id', $position)->first();

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
