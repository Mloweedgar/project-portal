<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\PD_AwardAddFinancingRequest;
use App\Http\Requests\PD_AwardAddRequest;
use App\Http\Requests\PD_AwardDeleteFinancingRequest;
use App\Http\Requests\PD_AwardEditFinancingRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Entity;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Award;
use App\Models\Project\ProjectDetails\PD_AwardFinancing;
use App\Models\Project\ProjectDetails\PD_AwardStatus;
use App\Models\Project\ProjectDetails\PD_FinancialCategory;
use App\Models\Project\ProjectDetails\ProjectDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PD_AwardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;
    public $award;

    public function __construct(Project $project, PD_Award $award)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->award = $award;

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
        if (Auth::user()->canAccessPDAward($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_Award
        if($projectDetail){
            $award = PD_Award::where('project_details_id', $projectDetail->id)->first();
        } else {
            $award = null;
        }

        // Confirm the presence of award
        $exists = false;
        if($award){
            $exists = true;
            $bidder = (new Entity())->find($award->preferred_bidder_id);
        } else {
            $bidder = null;
        }

        /**
         * Retrieve the entities
         */
        $entities = Entity::all();

        /**
         * Retrieve all status
         */
        $awards_status = PD_AwardStatus::all();

        /**
         * Retrieve all award financings for this project
         */
        $award_financings = PD_AwardFinancing::where("project_details_id", $projectDetail->id)->orderBy('position')->get();

        /**
         * Retrieve all categories
         */
        $categories = PD_FinancialCategory::all();

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        // Send the instance
        $controller = $this;

        return view('back.project.projectdetails.pd_award', compact('project', 'projectDetail', 'exists', 'award', 'controller', 'hasCoordinators', 'entities', 'bidder', 'award_financings', 'categories', 'awards_status'));

    }

    /**
     * @param PD_AwardAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCore(PD_AwardAddRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // First we find if there is already an award imputed for this project
            $award = PD_Award::where('project_details_id', $request->get('project_details_id'))->first();

            if($award){

                $award->name = $request->get('award_name');
                $award->description = $request->get('award_description');
                $award->total_amount = $request->get('total_amount');
                $award->award_status_id = $request->get('award_status_id');

                // If award data exists, update the info
                if($request->has('award_date')){
                    $award->award_date = Carbon::createFromFormat('d-m-Y', $request->get('award_date'))->toDateTimeString();
                }
                if($request->has('contract_signature_date')){
                    $award->contract_signature_date = Carbon::createFromFormat('d-m-Y', $request->get('contract_signature_date'))->toDateTimeString();
                }
                if($request->has('contract_signature_date_end')){
                    $award->contract_signature_date_end = Carbon::createFromFormat('d-m-Y', $request->get('contract_signature_date_end'))->toDateTimeString();
                }

            } else {

                // If no award data exists, create a new award
                $award = new PD_Award;
                $award->project_details_id = $request->get('project_details_id');
                $award->award_code = uniqid($prefix = null, $more_entropy = true);
                $award->name = $request->get('award_name');
                $award->description = $request->get('award_description');
                $award->total_amount = $request->get('total_amount');
                $award->award_status_id = $request->get('award_status_id');

                // If award data exists, update the info
                if($request->has('award_date')){
                    $award->award_date = Carbon::createFromFormat('d-m-Y', $request->get('award_date'))->toDateTimeString();
                }
                if($request->has('contract_signature_date')){
                    $award->contract_signature_date = Carbon::createFromFormat('d-m-Y', $request->get('contract_signature_date'))->toDateTimeString();
                }
                if($request->has('contract_signature_date_end')){
                    $award->contract_signature_date_end = Carbon::createFromFormat('d-m-Y', $request->get('contract_signature_date_end'))->toDateTimeString();
                }

            }

            // Save the data
            $award->save();

            // Project PUSH
            $award->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            Log::debug($e);

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }

    /**
     * @param PD_AwardAddFinancingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFinancial(PD_AwardAddFinancingRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $award_financing = new PD_AwardFinancing();
            $award_financing->project_details_id = $request->input('project_details_id');
            $award_financing->name = $request->input('financing_name');
            // If award data exists, update the info
            if($request->has('financing_start_date')){
                $award_financing->start_date= Carbon::createFromFormat('d-m-Y', $request->get('financing_start_date'))->toDateTimeString();
            }
            if($request->has('financing_end_date')){
                $award_financing->end_date = Carbon::createFromFormat('d-m-Y', $request->get('financing_end_date'))->toDateTimeString();
            }
            $award_financing->financial_category_id = $request->input('financing_category_id'); // Take care with the typos here, FINANCIAL != FINANCING
            $award_financing->amount = $request->input('financing_amount');
            $award_financing->description = $request->input('financing_description');
            $award_financing->financing_party_id = $request->input('financing_party_id');

            // Draft
            $award_financing->draft = 1;

            $maxProc = PD_AwardFinancing::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $award_financing->position = 1;

            }else{

                $award_financing->position = $maxProc->position+1;

            }

            // Save the data to the database
            $award_financing->save();

            //Update the project date
            $award_financing->projectDetail->project->touch();

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
     * @param PD_AwardEditFinancingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editFinancial(PD_AwardEditFinancingRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $award_financing = PD_AwardFinancing::find($request->input('id'));
            $award_financing->name = $request->input('financing_name');
            // If award data exists, update the info
            if($request->has('financing_start_date')){
                $award_financing->start_date= Carbon::createFromFormat('d-m-Y', $request->get('financing_start_date'))->toDateTimeString();
            }
            if($request->has('financing_end_date')){
                $award_financing->end_date = Carbon::createFromFormat('d-m-Y', $request->get('financing_end_date'))->toDateTimeString();
            }
            $award_financing->financial_category_id = $request->input('financing_category_id'); // Take care with the typos here, FINANCIAL != FINANCING
            $award_financing->amount = number_format($request->input('financing_amount'), 2);
            $award_financing->description = $request->input('financing_description');
            $award_financing->financing_party_id = $request->input('financing_party_id');

            // Save the data to the database
            $award_financing->save();

            //Update the project date
            $award_financing->projectDetail->project->touch();

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
     * @param PD_AwardAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBidder(PD_AwardAddRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // First we find if there is already an award imputed for this project
            $award = PD_Award::where('project_details_id', $request->get('project_details_id'))->first();

            if($award){

                $award->preferred_bidder_id = $request->get('preferred_bidder_id');

            } else {

                // If no award data exists, create a new award
                $award = new PD_Award;
                $award->project_details_id = $request->get('project_details_id');
                $award->award_code = uniqid($prefix = null, $more_entropy = true);
                $award->preferred_bidder_id = $request->get('preferred_bidder_id');

            }

            // Save the data
            $award->save();

            // Project PUSH
            $award->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            Log::debug($e);

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function deleteBidder(Request $request){

        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $award = PD_Award::find($request->input('id'));

            // Delete
            $award->preferred_bidder_id = null;
            $award->save();

            //Update the project date
            $award->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: PD_AwardController@delete[".$request->get('id')."]".PHP_EOL.
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
     * @param PD_AwardDeleteFinancingRequest $request
     * @return array
     */
    public function delete(PD_AwardDeleteFinancingRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $award_financing = PD_AwardFinancing::find($request->input('id'));

            // Delete
            $award_financing->delete();

            //Update the project date
            $award_financing->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: PD_AwardController@delete[".$request->get('id')."]".PHP_EOL.
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

            $award_financing = PD_AwardFinancing::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($award_financing as $financing){

                $key = array_search($financing->position,$order);
                $key++;

                if ($financing->position!=$key){
                    $financing->position = $key;
                    $financing->save();
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
            $data = PD_AwardFinancing::where('project_details_id', $project)->where('id', $position)->first();

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
