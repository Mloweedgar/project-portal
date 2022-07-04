<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\PerformanceFailureDeleteRequest;
use App\Http\Requests\Project\PerformanceInformation\PerformanceFailuresStoreRequest;
use App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure;
use App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailuresCategory;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\performance_information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PerformanceFailureController extends Controller
{

    public $project;
    public $performance_failure;

    public function __construct(Project $project, PI_PerformanceFailure $performance_failure)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->project = $project;
        $this->performance_failure = $performance_failure;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPIPerformanceFailures($project) === false) {
            return redirect('dashboard');
        }

        $exists = false;

        $categories = PI_PerformanceFailuresCategory::all();

        if(Auth::user()->isAdmin()){

            $performance_failures = $this->performance_failure->where('performance_information_id', $project->performanceInformation->id)->orderBy('position')->get();
            $performance_failuresTables = $this->performance_failure->where('performance_information_id', $project->performanceInformation->id)->with('category')->orderBy('position')->get()->toArray();

        } else {

            $performance_failures = $this->performance_failure->where('performance_information_id', $project->performanceInformation->id)->where('published', 1)->orderBy('position')->get();
            $performance_failuresTables = $this->performance_failure->where('performance_information_id', $project->performanceInformation->id)->where('published', 1)->with('category')->orderBy('position')->get()->toArray();

        }

        //Split the array in order to form the table
        $tables = array_chunk($performance_failuresTables, 2);


        /*return $performance_failures;*/

        $project->load('performanceInformation');

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.performance-information.performance-failures',compact('exists', 'project', 'performance_failures', 'categories', 'tables', 'hasCoordinators'));
    }

    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PerformanceFailuresStoreRequest $request)
    {

        $flag = [];

        DB::beginTransaction();
        try {

            $type = $request->get('type');

            $project = Project::findOrFail($request->get('project_id'));

            $performance_failure = $this->performance_failure;
            $performance_failure->performance_information_id = $project->performanceInformation->id;
            $performance_failure->title = $request->get('title');
            $performance_failure->category_failure_id = $request->get('category_failure');
            $performance_failure->number_events = $request->get('number_events');
            $performance_failure->penalty_contract = $request->get('penalty_abatement_contract');
            $performance_failure->penalty_imposed = $request->get('penalty_abatement_imposed');
            $performance_failure->penalty_paid = $request->get('penalty_abatement_imposed_yes_no');
            $performance_failure->draft = 1;

            $maxProc = PI_PerformanceFailure::where('performance_information_id',$project->performanceInformation->id)->orderBy('position','desc')->first();

            if (!$maxProc){

                $performance_failure->position = 1;

            }else{

                $performance_failure->position = $maxProc->position+1;

            }


            $performance_failure->save();
            $flag["status"] = true;
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }
        /*dd($flag);*/
        // Load the view again
        return back()->with($flag);

    }


    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PerformanceFailuresStoreRequest $request)
    {

        $flag = [];

        DB::beginTransaction();
        try {

            $type = $request->get('type');

            $performance_failure = $this->performance_failure->find($request->get('performance_failure_id'));
            $performance_failure->title = $request->get('title');
            $performance_failure->category_failure_id = $request->get('category_failure');
            $performance_failure->number_events = $request->get('number_events');
            $performance_failure->penalty_contract = $request->get('penalty_abatement_contract');
            $performance_failure->penalty_imposed = $request->get('penalty_abatement_imposed');
            $performance_failure->penalty_paid = $request->get('penalty_abatement_imposed_yes_no');

            $performance_failure->save();

            $flag["status"] = true;
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }
        // Load the view again
        return back()->with($flag);

    }


    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(Request $request)
    {

        $flag = [];
        $this->validate($request, [
            'category_name' => 'required|unique:pi_performance_failures_category,name'
        ]);

        DB::beginTransaction();
        try {

            PI_PerformanceFailuresCategory::create(['name' => $request->get('category_name')]);

            $flag["status"] = true;

            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }


    /**
     * Remove the specified resource from storage.
     * @param PD_DocumentDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PerformanceFailureDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $this->performance_failure = $this->performance_failure->find($request->get('id'));

            // Delete
            $this->performance_failure->delete();

            // Commit the changes
            session()->flash('deleted', true);

            DB::commit();

        } catch (\Exception $e) {
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

    public function order(Request $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $failures = PI_PerformanceFailure::where('performance_information_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($failures as $failure){

                $key = array_search($failure->position,$order);
                $key++;

                if ($failure->position!=$key){
                    $failure->position = $key;
                    $failure->save();
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
            $data = PI_PerformanceFailure::where('performance_information_id', $project)->where('id', $position)->first();

            // Update the field
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $data->published = $visibilityToEdit;

            // Save the data
            $data->save();

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
