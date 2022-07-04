<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_TariffsAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_TariffsEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_TariffsDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectDetails\PD_Tariffs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_TariffsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $tariffs;

    public function __construct(Project $project, PD_Tariffs $tariffs)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->tariffs = $tariffs;

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
        if (Auth::user()->canAccessPDTariffs($project) === false) {
            return redirect('dashboard');
        }


        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Procurement
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $tariffs = PD_Tariffs::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $tariffs = PD_Tariffs::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

        } else {

            $tariffs = null;

        }

        $exists = false;

        if($tariffs){

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

        return view('back.project.projectdetails.pd_tariffs', compact('project', 'projectDetail', 'exists', 'tariffs', 'controller', 'hasCoordinators'));

    }

    /**
     * @param PD_TariffsAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_TariffsAddRequest $request)
    {
        $flag = ["flag" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $tariffs = new PD_Tariffs();
            $tariffs->project_details_id = $request->input('project_details_id');
            $tariffs->name = $request->input('name');
            $tariffs->description = $request->input('description');
            $tariffs->value = $request->input('value');
            $tariffs->paidBy = $request->input('paidBy');
            if($request->has('startDate')){
                $tariffs->startDate= Carbon::createFromFormat('d-m-Y', $request->get('startDate'))->toDateTimeString();
            }
            if($request->has('endDate')){
                $tariffs->endDate = Carbon::createFromFormat('d-m-Y', $request->get('endDate'))->toDateTimeString();
            }

            // Draft
            $tariffs->draft = 1;

            $maxProc = PD_Tariffs::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $tariffs->position = 1;

            }else{

                $tariffs->position = $maxProc->position+1;

            }

            // Save the data to the database
            $tariffs->save();

            //Update the project date
            $tariffs->projectDetail->project->touch();

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
     * @param PD_TariffsEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_TariffsEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $tariffs = PD_Tariffs::find($request->input('id'));
            $tariffs->name = $request->input('name');
            $tariffs->description = $request->input('description');
            $tariffs->value = $request->input('value');
            $tariffs->paidBy = $request->input('paidBy');
            if($request->has('startDate')){
                $tariffs->startDate= Carbon::createFromFormat('d-m-Y', $request->get('startDate'))->toDateTimeString();
            }
            if($request->has('endDate')){
                $tariffs->endDate = Carbon::createFromFormat('d-m-Y', $request->get('endDate'))->toDateTimeString();
            }

            // Save the data to the database
            $tariffs->save();

            //Update the project date
            $tariffs->projectDetail->project->touch();

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
     * @param PD_TariffsEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_TariffsDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $tariffs = PD_Tariffs::find($request->input('id'));

            // Delete
            $tariffs->delete();

            //Update the project date
            $tariffs->projectDetail->project->touch();

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

            $tariffs = PD_Tariffs::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($tariffs as $tariff){

                $key = array_search($tariff->position,$order);
                $key++;

                if ($tariff->position!=$key){
                    $tariff->position = $key;
                    $tariff->save();
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
            $data = PD_Tariffs::where('project_details_id', $project)->where('id', $position)->first();

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
