<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectInformationRequest;
use App\Http\Requests\Project\ProjectInformationEditRequest;
use App\Http\Requests\Project\ProjectInformationEditCoreRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Config;
use App\Models\Entity;
use App\Models\Location;
use App\Models\Project\Currency;
use App\Models\Project\Project;
use App\Models\Project\ProjectInformation;
use App\Models\Sector;
use App\Models\Stage;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;



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
        $sponsors = Entity::select('id', 'name')->get();
        $exists = false;

        $project_information = $this->project_information->where('project_id', $project->id)->first();

        if($project_information){
            $ocid = $project_information->ocid;
            $project_information = $project_information->load('regions', 'sectors');
            $exists = true;
        } else {
            $ocid = Config::where('name','ocid')->first()->select('value').'-'.$project->id;
        }

        $currency = Config::where('name','currency')->first()->value;
        /*return $project;*/

        return view('back.project.project-information',compact('currency','sectors','regions','stages', 'sponsors', 'project', 'exists', 'project_information', 'currencies','ocid'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProjectInformationRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            /*
             * Project information
             */
            $type = $request->get('type');

            $project = Project::findOrFail($request->get('project_id'));
            $project->project_information_active = 1;
            $project->save();
            $project->touch();

            $project_information = $this->project_information->where('project_id', $project->id)->first();
            if(!$project_information){
                $project_information = $this->project_information;

            }

            /*$project_information = $this->project_information;*/
            $project_information->project_id = $project->id;
            $project_information->stage_id = $request->get('stage');
            $project_information->project_value_usd = $request->get('project_value_usd');
            $project_information->project_value_second = $request->get('project_value_second');
            $project_information->sponsor_id = $request->get('sponsor');

            $project_information->project_need = $request->get('project_need');
            $project_information->description_asset = $request->get('description_asset');
            $project_information->rationale_ppp = $request->get('rationale_ppp');
            $project_information->name_transaction_advisor = $request->get('name_transaction_advisor');
            $project_information->unsolicited_project = $request->get('unsolicited_project');
            $project_information->project_summary = $request->get('project_summary');

            if($type == 'publish'){
                $project_information->published = 1;
                $project_information->draft = 0;
            }else if($type == 'save_draft'){
                $project_information->draft = 1;
                $project_information->published = 0;

                $subject = trans('emails/tasks.publish_subject');

                $emailData = [
                    'name' => Auth::user()->name,
                    'subject' => $subject,
                ];

                Mail::send('back.emails.tasks.completeRFM', $emailData, function ($message) use ($subject) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject($subject);
                    $message->to(Auth::user()->email);
                });



            }else if($type == 'request_modification'){
                $project_information->request_modification = 1;
            }

            $project_information->save();

            $project_information->regions()->sync($request->get('regions'));
            $project_information->sectors()->sync($request->get('sectors'));
            // $project->entities()->attach($request->get('sponsor'), ['sponsor' => 1, 'party' => 0]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return $flag;

    }

    /**
     * @param ProjectInformationEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(ProjectInformationEditRequest $request){

        $flag = ["status" => true];

        try {

            DB::beginTransaction();

            // Find Project Information
            $projectInformation = ProjectInformation::where('project_id', $request->get('project_id'))->first();

            // Update the field
            $tableToEdit = $request->get('position_table');
            $descriptionToEdit = $request->get('description');
            $project_id = $request->get('project_id');

            switch ($tableToEdit){

                case "project_need": $projectInformation->project_need = $descriptionToEdit; break;
                case "description_asset": $projectInformation->description_asset = $descriptionToEdit; break;
                case "rationale_ppp": $projectInformation->rationale_ppp = $descriptionToEdit; break;
                case "name_transaction_advisor": $projectInformation->name_transaction_advisor = $descriptionToEdit; break;
                case "unsolicited_project": $projectInformation->unsolicited_project = $descriptionToEdit; break;
                case "project_summary": $projectInformation->project_summary = $descriptionToEdit; break;

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
            $project_information->project_value_usd = $request->get('project_value_usd');
            $project_information->project_value_second = $request->get('project_value_second');
            $project_information->sponsor_id = $request->get('sponsor');


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
                case "rationale_ppp_private": $projectInformation->rationale_ppp_private = $visibilityToEdit; break;
                case "name_transaction_advisor_private": $projectInformation->name_transaction_advisor_private = $visibilityToEdit; break;
                case "unsolicited_project_private": $projectInformation->unsolicited_project_private = $visibilityToEdit; break;
                case "project_summary_private": $projectInformation->project_summary_private = $visibilityToEdit; break;

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
