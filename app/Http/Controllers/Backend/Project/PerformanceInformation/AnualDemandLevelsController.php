<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\AnnualDemandLevelDeleteRequest;
use App\Http\Requests\Project\PerformanceInformation\AnnualDemandLevelRequest;
use App\Http\Requests\Project\PerformanceInformation\AnnualDemandLevelTypeStoreRequest;
use App\Http\Requests\Project\PerformanceInformation\AnnualDemandLevelUpdateRequest;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevel;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelMain;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelType;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelValue;
use App\Models\Project\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class AnualDemandLevelsController extends Controller
{
    public $project;
    public $annual_demmand;

    public function __construct(Project $project, PI_AnnualDemandLevel $annual_demmand)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->annual_demmand = $annual_demmand;

    }

    public function index($id)
    {
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPIAnnualDemandLevels($project) === false) {
            return redirect('dashboard');
        }

        $exists = false;
        $year = Carbon::now()->year;

        $project = $this->project->findOrFail($id);
        $exists = false;
        $tables = [];
        $types = PI_AnnualDemandLevelType::select('id', 'type', 'unit')->get();

        $project->load('performanceInformation');

        $pi_annual_demand_levels_main_id = $project->performanceInformation->annual_demand;

        //If the record doesn't exists, create a new object.
        if(!$pi_annual_demand_levels_main_id){
            $obje = new PI_AnnualDemandLevelMain();
            $project->performanceInformation->annual_demand()->save($obje);
            $pi_annual_demand_levels_main_id = $obje->id;

        }else{
            $pi_annual_demand_levels_main_id = $pi_annual_demand_levels_main_id->id;
        }
        $tables = $this->getTable($pi_annual_demand_levels_main_id);

        $draft = PI_AnnualDemandLevelMain::where('id',$pi_annual_demand_levels_main_id)->first()->draft;

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.performance-information.annual-demand-levels',compact('exists', 'project', 'year', 'annual_demmand', 'tables', 'types','draft','hasCoordinators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(AnnualDemandLevelRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {


            $type = $request->get('type');

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();
            $pi_annual_demand_levels_main_id = $project->performanceInformation->annual_demand->id;

            $annual_demmand = $this->annual_demmand;

            $previousRecord = $this->annual_demmand->where('pi_annual_demand_levels_main_id', $pi_annual_demand_levels_main_id)->where('year', $request->get('year'))->where('type_id', $request->get('type_id'))->count();
            if($previousRecord > 0){
                throw new \Exception(trans('project/performance-information/annual_demand_levels.error_duplicate_entry'));
            }

            $annual_demmand->pi_annual_demand_levels_main_id = $pi_annual_demand_levels_main_id;

            $annual_demmand->type_id = $request->get('type_id');
            $annual_demmand->year = $request->get('year');
            $annual_demmand->value = $request->get('value');

            $annual_demmand->save();
            $flag["status"] = true;
            $flag["message"] = trans('project/performance-information/annual_demand_levels.success');
            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeType(AnnualDemandLevelTypeStoreRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {

            $objAnnualDemandLevelType = new PI_AnnualDemandLevelType;
            $objAnnualDemandLevelType->type = $request->get('type');
            $objAnnualDemandLevelType->unit = $request->get('unit');
            $objAnnualDemandLevelType->save();
            $flag["message"] = trans('project/performance-information/annual_demand_levels.success');
            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);


    }

    /**
     * Delete
     *
     * @param  AnnualDemandLevelDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function delete(AnnualDemandLevelDeleteRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $this->annual_demmand = $this->annual_demmand->find($request->get('annual_demmand_id'));
            $this->annual_demmand->delete();

            DB::commit();
            $flag["message"] = trans('project/performance-information/annual_demand_levels.deleted');
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(AnnualDemandLevelUpdateRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            if($request->get('demmands')){
                foreach ($request->get('demmands') as $key => $value) {
                    $this->annual_demmand = $this->annual_demmand->find($value["id"]);
                    $this->annual_demmand->value = $value["value"];
                    $this->annual_demmand->save();
                }
            }
            $flag["message"] = trans('project/performance-information/income_statements_metrics.success');
            $type = $request->get('submit_type');

            $annualDemandMain = PI_AnnualDemandLevelMain::where("performance_information_id",$project->performanceInformation->id)->first();

            if($type == 'publish'){
                $annualDemandMain->published = 1;
                $annualDemandMain->draft = 0;
            }else if($type == 'save_draft'){
                $annualDemandMain->draft = 1;
                $annualDemandMain->published = 0;

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
                $annualDemandMain->request_modification = 1;
            }
            $annualDemandMain->save();
            $project->save();

            DB::commit();
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return $flag;
    }

    /**
     * Get table method
     * @param annual demands main table id
     * @return array
     */
    public static function getTable($pi_annual_demand_levels_main_id){

        $tables = [];
        $types = PI_AnnualDemandLevelType::select('id', 'type', 'unit')->get();

        if(PI_AnnualDemandLevel::where('pi_annual_demand_levels_main_id', $pi_annual_demand_levels_main_id)->count() > 0){
            foreach ($types as $key => $value) {
                $records = PI_AnnualDemandLevel::where('pi_annual_demand_levels_main_id', $pi_annual_demand_levels_main_id)->where('type_id', $value->id)->select('id','value', 'year')->orderBy('year')->get();
                if(count($records) > 0){
                    $tables [] = ["type" => $value->type, "unit" => $value->unit, "records" => array_chunk($records->toArray(), 5)];
                }
            }
        }
        return $tables;

    }


}
