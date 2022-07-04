<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Requests\Project\ProjectInformationEditRequest;
use App\Http\Requests\Project\ProjectInformationEditCoreRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Config;
use App\Models\Entity;
use App\Models\Location;
use App\Models\Project\Currency;
use App\Models\Project\Project;
use App\Models\Project\ProjectInformation;
use App\Models\PPPDeliveryModel;
use App\Models\Sector;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectInformationController extends ProjectBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;

    public $project_information;

    public function __construct(Project $project, ProjectInformation $project_information)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->project_information = $project_information;
    }

    /**
     * Returns the view page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {
        $project = $this->project->findOrFail($id);


        // Check specific permissions
        if (Auth::user()->canAccessProjectInformation($project) === false) {
            return redirect('dashboard');
        }

        /*$project = $project->load(array('entities' => function($query){
            $query->where('entities.sponsor', 1);
        }));*/
        $project = $project->load('projectInformation.sponsor');
        $currencies = Currency::all();
        /*return $project;*/



        if(Auth::user()->isAdmin() || Auth::user()->permission == 2){
            $sectors = Sector::all('sectors.id','sectors.name');
        }elseif(Auth::user()->permission == 1){
            $sectors = Auth::user()->sectors;
        }else{
            $sectors = Sector::all('sectors.id','sectors.name');
        }

        $regions = Location::where('type','region')->get();
        $stages = Stage::all('stages.id','stages.name');
        $ppp_delivery_models = PPPDeliveryModel::all('ppp_delivery_models.id','ppp_delivery_models.name');
        $sponsors = Entity::select('id', 'name')->get();
        $cofog = DB::table('sectors_cofog')->where('second_level_id', "<>", 0)->get();
        $exists = false;

        $project_information = $this->project_information->where('project_id', $project->id)->first();

        if($project_information){
            $ocid = $project_information->ocid;
            $project_information = $project_information->load('regions', 'sectors')->toJson();
            $exists = true;
        } else {
            $ocid = Config::where('name','ocid')->first()->select('value').'-'.$project->id;
        }

        $currency = Config::where('name','currency')->first()->value;
        /*return $project;*/

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.project-information',compact('currency','sectors','regions','stages', 'sponsors', 'project', 'exists', 'project_information', 'currencies','ocid', 'hasCoordinators', 'cofog','indicative_timing_invests','ppp_delivery_models'));
    }

    /**
     * @param ProjectInformationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(ProjectInformationEditRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Find Project Information
            $projectInformation = ProjectInformation::where('project_id', $request->get('project_id'))->first();

            // Update the field
            $tableToEdit = $request->get('position_table');
            $descriptionToEdit = $request->get('description');
            $project_id = $request->get('project_id');

            switch ($tableToEdit){

                case "project_need": $projectInformation->project_need = $descriptionToEdit; break;
                case "description_asset": $projectInformation->description_asset = $descriptionToEdit; break;
                case "description_services": $projectInformation->description_services = $descriptionToEdit; break;
                case "reasons_ppp": $projectInformation->reasons_ppp = $descriptionToEdit; break;
                case "stakeholder_consultation": $projectInformation->stakeholder_consultation = $descriptionToEdit; break;
                case "project_summary_document": $projectInformation->project_summary_document = $descriptionToEdit; break;

            }

            // Save the data
            $projectInformation->save();

            // Project PUSH
            Project::find($project_id)->touch();

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
        return back()->with($flag);

    }

    /**
     * @param ProjectInformationEditCoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editCore(ProjectInformationEditCoreRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Find Project Information
            $project_information = ProjectInformation::where('project_id', $request->get('project_id'))->first();
            $project_id = $request->get('project_id');

            $project_information->stage_id = $request->get('stage');
            $project_information->ppp_delivery_model_id = $request->get('ppp_delivery_model');
            $project_information->project_value_usd = $request->get('project_value_usd');
            if ($request->get('project_value_second') == '') {
                $project_information->project_value_second = null;
            } else {
                $project_information->project_value_second = str_replace(',', '', $request->get('project_value_second'));
            }
            $project_information->project_value_second = $request->get('project_value_second');
            $project_information->sponsor_id = $request->get('sponsor');

            /**
             * LOCAL GOVERNMENT
             */
            if ($request->get('local_government') == '') {
                $project_information->local_government = null;
            } else {
                $project_information->local_government = $request->get('local_government');
            }

            /**
             * COFOG
             */
            if ($request->get('cofog') == '') {
                $project_information->cofog_sector_id = null;
            } else {
                $project_information->cofog_sector_id = $request->get('cofog');
            }

            /**
             * Timing of investment
             */
            if ($request->get('indicative_timing_invest') == '') {
                $project_information->indicative_timing_invest = null;
            } else {
                $project_information->indicative_timing_invest = $request->get('indicative_timing_invest');
            }
            $project_information->save();

            $project_information->regions()->sync($request->get('regions'));
            $project_information->sectors()->sync($request->get('sectors'));

            // Project PUSH
            Project::find($project_id)->touch();

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
        return back()->with($flag);

    }

    /**
     * @param ChangeIndividualVisibilityRequest $request
     * @return array
     */
    public function changeIndividualVisibility(ChangeIndividualVisibilityRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Find Project Information
            $projectInformation = ProjectInformation::where('project_id', $request->get('project'))->first();

            // Update the field
            $tableToEdit = $request->get('position');
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $project = $request->get('project');

            switch ($tableToEdit){

                case "project_need_private": $projectInformation->project_need_private = $visibilityToEdit; break;
                case "description_asset_private": $projectInformation->description_asset_private = $visibilityToEdit; break;
                case "description_services_private": $projectInformation->description_services_private = $visibilityToEdit; break;
                case "reasons_ppp_private": $projectInformation->reasons_ppp_private = $visibilityToEdit; break;
                case "stakeholder_consultation_private": $projectInformation->stakeholder_consultation_private = $visibilityToEdit; break;
                case "project_summary_document_private": $projectInformation->project_summary_document_private = $visibilityToEdit; break;

            }

            // Save the data
            $projectInformation->save();

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

    /**
     * Remote validation to check if the ocid exists
     *
     * @param  Request $request
     * @return boolean
     */
    public function ocidExists(Request $request)
    {
        return ProjectInformation::where('ocid', $request->get('ocid'))->where('project_id','!=',$request->get('id'))->count() ? "false" : "true";
    }

}
