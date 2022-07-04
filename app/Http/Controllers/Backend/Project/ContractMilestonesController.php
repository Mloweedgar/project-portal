<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ContractMilestonesRequest;
use App\Models\Project\ContractMilestones\ContractMilestone;
use App\Models\Project\ContractMilestones\MilestonesCategory;
use App\Models\Project\ContractMilestones\MilestonesType;
use App\Models\Project\Project;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;

class ContractMilestonesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $contract_milestones;
    public $project;
    private static $section_id = 4;

    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        /*$this->middleware('project', $this->$section_id);*/

    }

    /**
     * Returns the view page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {
        $project = Project::findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessContractMilestones($project) === false) {
            return redirect('dashboard');
        }

        /*$sectors = Sector::all('sectors.id','sectors.name');
        $regions = Location::where('type','region')->get();
        $stages = Stage::all('stages.id','stages.name');
        $sponsors = Entity::where('is_sponsor', 1)->select('id', 'name')->get();*/
        $milestones = MilestonesType::all();
        $categories = MilestonesCategory::all();
        $exists = false;

        if(Auth::user()->isAdmin()){

            $contract_milestones = ContractMilestone::where('project_id', $project->id);

        } else {

            $contract_milestones = ContractMilestone::where('project_id', $project->id)->where('published', 1);

        }

        /*return $contract_milestones;*/
        if($contract_milestones->count() > 0){

            $contract_milestones = $contract_milestones->get();
            $exists = true;

        } else {

            $contract_milestones = null;

        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        /*return $contract_milestones->get();*/
        /*$milestones_numbers = [1,3,2,4];*/

        return view('back.project.contract-milestones',compact('exists', 'project', 'milestones', 'milestones_numbers', 'contract_milestones', 'hasCoordinators', 'categories'));

    }

    /**
     * @param ContractMilestonesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContractMilestonesRequest $request)
    {
        $flag = ["status" => true, "message" => "", "record" => false];

        /*dd($request->all());*/
        DB::beginTransaction();
        try {
            /*
             * Project information
             */
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $contract_milestones = new ContractMilestone();
            $contract_milestones->name = $request->get('name');
            $contract_milestones->description = $request->get('description');
            $contract_milestones->milestone_type_id = $request->get('milestone_type');
            $contract_milestones->project_id = $request->get('project_id');
            $contract_milestones->milestone_category_id = $request->get('milestone_category');

            /**
             * Check if the dates are submitted
             * These dates have are previously validated at the ContractMilestonesRequest
             * At least, one of the 2 fields have to be submitted
             */
            if($request->get('date')){
                $contract_milestones->date = Carbon::createFromFormat('d-m-Y', $request->get('date'))->toDateTimeString();
            }
            if($request->get('deadline')){
                $contract_milestones->deadline = Carbon::createFromFormat('d-m-Y', $request->get('deadline'))->toDateTimeString();
            }

            // Save the milestone
            $contract_milestones->save();

            DB::commit();
            // all good
        } catch (\Exception $e) {

            Log::debug($e);

            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }

        return back()->with($flag);
    }

    /**
     * @param ContractMilestonesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContractMilestonesRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();
            /*
             * Project information
             */
            $contract_milestones = ContractMilestone::find($request->get('contract_milestone_id'));
            $contract_milestones->name = $request->get('name');
            $contract_milestones->description = $request->get('description');
            $contract_milestones->milestone_type_id = $request->get('milestone_type');
            $contract_milestones->milestone_category_id = $request->get('milestone_category');

            /**
             * Check if the dates are submitted
             * These dates have are previously validated at the ContractMilestonesRequest
             * At least, one of the 2 fields have to be submitted
             */
            if($request->get('date')){
                $contract_milestones->date = Carbon::createFromFormat('d-m-Y', $request->get('date'))->toDateTimeString();
            }
            if($request->get('deadline')){
                $contract_milestones->deadline = Carbon::createFromFormat('d-m-Y', $request->get('deadline'))->toDateTimeString();
            } else {
                $contract_milestones->deadline = null;
            }

            $contract_milestones->save();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }
        /*return $flag;*/

        return back()->with($flag);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $this->contract_milestones = ContractMilestone::find($request->get('id'));

            // Delete
            $this->contract_milestones->delete();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: ContractMilestonesController@delete[".$request->get('id')."]".PHP_EOL.
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
            $data = ContractMilestone::where('project_id', $project)->where('id', $position)->first();

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
