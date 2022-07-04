<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_FinancialAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_FinancialEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_FinancialDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_FinancialCategory;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_Financial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_FinancialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $financial;

    public function __construct(Project $project, PD_Financial $financial)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->financial = $financial;

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
        if (Auth::user()->canAccessPDFinancialSupport($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();
        $categories = PD_FinancialCategory::all();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $financials = PD_Financial::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $financials = PD_Financial::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

        } else {

            $financials = null;

        }

        $exists = false;

        if($financials){

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

        return view('back.project.projectdetails.pd_financial', compact('project', 'projectDetail', 'exists', 'financials', 'controller', 'hasCoordinators', 'categories'));

    }

    /**
     * @param PD_FinancialAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_FinancialAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $financial = new PD_Financial();
            $financial->project_details_id = $request->input('project_details_id');
            $financial->name = $request->input('name');
            $financial->description = $request->input('description');
            $financial->financial_category_id = $request->input('financial_category_id');

            // Draft
            $financial->draft = 1;

            $maxProc = PD_Financial::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $financial->position = 1;

            }else{

                $financial->position = $maxProc->position+1;

            }

            // Save the data to the database
            $financial->save();

            //Update the project date
            $financial->projectDetail->project->touch();

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
     * @param PD_FinancialEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_FinancialEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $financial = PD_Financial::find($request->input('id'));
            $financial->name = $request->input('name');
            $financial->description = $request->input('description');
            $financial->financial_category_id = $request->input('financial_category_id');

            // Save the data to the database
            $financial->save();

            //Update the project date
            $financial->projectDetail->project->touch();

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
     * @param PD_FinancialDeleteRequest $request
     * @return array
     */
    public function delete(PD_FinancialDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $financial = PD_Financial::find($request->input('id'));

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
                "|- Action: FinancialController@delete[".$request->get('id')."]".PHP_EOL.
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

            $financials = PD_Financial::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($financials as $financial){

                $key = array_search($financial->position,$order);
                $key++;

                if ($financial->position!=$key){
                    $financial->position = $key;
                    $financial->save();
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
            $data = PD_Financial::where('project_details_id', $project)->where('id', $position)->first();

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
